<?php

namespace App\Services;

use App\Enums\ServiceEnum;
use App\Enums\StatusEnum;
use App\Exceptions\PaymentError;
use App\Exceptions\ServicePurchaseError;
use App\Models\Customer;
use App\Models\Item;
use App\Models\Order;
use App\Models\Service;
use App\Services\VtuProviders\AirtimePackageManager;
use App\Services\VtuProviders\DataPackageManager;
use Illuminate\Support\Str;
use MannikJ\Laravel\Wallet\Exceptions\UnacceptedTransactionException;

class OrderService
{
    public function addItems(Order $order, Service $service, int $amount, int $quantity = 1, int $platform_amount = 0, array $attributes = []): void
    {
        $order->items()->create([
            'product_id' => $service->id,
            'product_type' => $service::class,
            'quantity' => $quantity,
            'customer_amount' => $amount,
            'platform_amount' => $platform_amount,
            'attr' => $attributes,
            'status' => StatusEnum::PENDING
        ]);
    }

    public function create(Customer $customer, array $attributes = []): Order
    {
        return $customer->orders()->create([
            'organization_id' => tenant('id'),
            'reference' => Str::uuid(),
            'status' => StatusEnum::PENDING,
            'attr' => $attributes
        ]);
    }

    /**
     * @throws UnacceptedTransactionException
     * @throws PaymentError
     */
    public function handleOrderPayment(Order $order): void
    {
        if($order->organization->wallet->canWithdraw($order->getPlatformTotal())){
            $order->organization->wallet->withdraw($order->getPlatformTotal(), [
                'description' => 'new order'
            ]);
        }else{
            throw new PaymentError('Cannot process payment at the moment');
        }

        $order->customer->wallet->withdraw($order->getTotal(), [
            'description' => 'new order'
        ]);

        $order->updateStatus(StatusEnum::PAID);
    }

    public function sendDeliverableItems(Order $order): void
    {
        foreach ($order->items as $item){
            try{
                $this->deliverServiceItem($item);
            } catch (ServicePurchaseError $e) {
                logger()->error('Item delivery failed: ' . $e->getMessage(), $item->toArray());
                continue;
            }
        }
    }

    /**
     * @throws ServicePurchaseError
     */
    public function deliverServiceItem(Item $item): void
    {
        if($item->status !== StatusEnum::PENDING) return;

        if(($item->product instanceof Service) === false) return;

        $manager = match ($item->product->name){
            ServiceEnum::AIRTIME->value => AirtimePackageManager::class,
            ServiceEnum::DATA->value => DataPackageManager::class,
            default => null
        };

        try {
            if(!$manager){
                throw new ServicePurchaseError('This item delivery manager could not be found');
            }

            $manager::deliverPurchase($item);

        }catch (ServicePurchaseError|\Exception $e) {
            $item->updateStatus(StatusEnum::FAILED, $e->getMessage());
            $this->handleItemRefund($item);
            throw $e;
        }
    }

    private function handleItemRefund(Item $item): void
    {
        if($item->status === StatusEnum::REFUNDED) return;

        \DB::transaction(function() use($item){
            $order = $item->order;
            $order->organization->wallet->deposit($item->platform_amount, [
                'description' => 'refund'
            ]);
            $order->customer->wallet->deposit($item->customer_amount, [
                'description' => 'refund'
            ]);

            $item->updateStatus(StatusEnum::REFUNDED);
        });
    }


}
