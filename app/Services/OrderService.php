<?php

namespace App\Services;

use App\Enums\ErrorCode;
use App\Models\Contracts\Customer;
use App\Models\Contracts\Product;
use App\Models\Order;
use App\Models\Transaction;
use App\Services\VtuProviders\Contracts\PackageManager;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrderService
{
    /**
     * Creates a new order for a product and customer.
     *
     * @param Product $product
     * @param Customer $customer
     * @param array $data Additional data to be stored with the order.
     *
     * @return Order The newly created order.
     *
     * @throws Exception If any errors occur during order creation.
     */
    public function create(Product $product, Customer $customer, array $data = []): Order
    {
        if(!$product->canBePurchased()) throw new Exception("Product not available for purchase. Try again later", ErrorCode::ORDER_PROCESSING_FAILED);
        return DB::transaction(function() use($product, $customer, $data){
            $sellPrice = money($product->getPrice($customer))->getAmount();
            $costPrice = money($product->getPrice(tenant()))->getAmount();

            return Order::query()->create([
                'tenant_id' => tenant('id'),
                'owner_type' => $customer::class,
                'owner_id' => $customer->id,
                'item_type' => $product::class,
                'item_id' => $product->id,
                'total' => $sellPrice,
                'profit' => 0,
                'reference' => time() . Str::random(8), // TODO: generate a better unique refrence
                'status' => Order::STATUS_PENDING,
                'data' => [
                    'title' => $product->title,
                    'cost_price' => $costPrice,
                    ...$data
                ]
            ]);
        });
    }

    /**
     * Processes the payment for an order.
     *
     * @param Order $order The order to process payment for.
     *
     * @throws Exception If the payment has already been successful or if any errors occur during payment processing.
     */
    public function processPayment(Order $order): Transaction
    {
        if($order->isDelivered() || $order->isPaid())
            throw new Exception("Order has already been payed", ErrorCode::ORDER_PROCESSING_FAILED);


        return DB::transaction(function() use($order){
            $order->fill([
                'status' => Order::STATUS_PAID,
            ])->save();
            return $order->owner->pay($order->item);
        });
    }

    /**
     * Processes a refund for an order.
     *
     * @param Order $order
     *
     * @throws Exception If any errors occur during the refund process.
     */
    public function processRefund(Order $order): void
    {
        logger()->info('Refunding order ' . $order->id);

        if($order->isPaid()){
            DB::transaction(function() use($order){
                $order->owner->refund($order->item);
                $order->fill([
                    'status' => Order::STATUS_FAILED,
                    'profit' => 0
                ])->save();
            });
        }
    }

    /**
     * @throws Exception
     */
    public function handleDelivery(Order $order): void
    {
        try{
            $deliveryService = app(VirtualTopupService::class, ['service' => $order->item->service]);
            $reponse = $deliveryService->subscribe($order->item, $order->data);

            $order->fill([
                'status' => Order::STATUS_DELIVERED,
                'data' => [...$order->data, 'delivery_response' => $reponse],
                'profit' => $order->total - $order->data['cost_price']
            ])->save();
        }catch (Exception $exception){
            $this->processRefund($order);
            throw $exception;
        }
    }

    /**
     * Processes payment for an order and initiates its delivery.
     *
     * @param Order $order
     *
     * @throws Exception If any errors occur during payment processing or delivery.
     */
    public function processPaymentAndDeliver(Order $order): void
    {
        $this->processPayment($order);
        $this->handleDelivery($order);
    }
}
