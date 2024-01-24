<?php

namespace App\Models\Contracts;

use App\Enums\ErrorCode;
use App\Models\Payment;
use App\Models\Transaction;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Cknow\Money\Money;
use MannikJ\Laravel\Wallet\Exceptions\UnacceptedTransactionException;

trait Payable
{
    use HasWallet;
    public function payments()
    {
        return $this->morphMany(Payment::class, 'payable');
    }

    public function initializePayment(Money $money)
    {
        return $this->payments()->create([
            'tenant_id' => tenant('id'),
            'reference' => time() . Str::random(4),
            'amount' => $money->getAmount(),
            'status' => Payment::STATUS_PENDING,
            'gateway' => 'paystack'
        ]);
    }

    /**
     * @throws Exception
     */
    public function pay(Product $product): Transaction
    {
        try {
            DB::beginTransaction();
            if(!tenant()) return $this->wallet->withdraw($product->getPrice($this), $product->getMeta());

            if (!tenant()?->wallet->canWithdraw($product->getPrice(tenant()))) {
                throw new Exception(
                    'Service unavailable. Try again later.',
                    ErrorCode::TENANT_OUT_OF_BUSINESS
                );
            }

            tenant()?->wallet->withdraw($product->getPrice(tenant()), $product->getMeta());
            $transaction = $this->wallet->withdraw($product->getPrice($this), $product->getMeta());

            DB::commit();
            return $transaction;
        }catch (Exception $e){
            DB::rollBack();
            throw new Exception($e->getMessage(), ErrorCode::LOW_BALANCE);
        }
    }

    /**
     * @throws Exception
     */
    public function refund(Product $product): Transaction
    {
        try {
            return DB::transaction(function() use($product){
                if(tenant()) tenant()->wallet->deposit($product->getPrice(tenant()), [...$product->getMeta(), 'description' => 'Refund for '. $product->title]);
                return $this->wallet->deposit($product->getPrice($this), [...$product->getMeta(), 'description' => 'Refund for '. $product->title]);
            });
        }catch (UnacceptedTransactionException $exception){
            throw new Exception($exception->getMessage(), ErrorCode::ORDER_PROCESSING_FAILED);
        }
    }
}
