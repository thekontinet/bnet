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

    /**
     * @throws Exception
     */
    public function pay(Product $product): Transaction
    {
        try {
            if(!$this->tenant->wallet->canWithdraw($product->getPrice($this->tenant))){
                throw new Exception(
                    'Organization balance is low',
                    ErrorCode::TENANT_OUT_OF_BUSINESS
                );
            }

            return DB::transaction(function() use($product){
                $this->tenant->wallet->withdraw($product->getPrice($this->tenant, request()->get('amount')));
                return $this->wallet->withdraw($product->getPrice($this, request()->get('amount')), $product->getMeta());
            });
        }catch (UnacceptedTransactionException $e){
            throw new Exception("Payment for Product:$product?->title failed: " . $e->getMessage(), ErrorCode::TRANSACTION_ERROR);
        }catch (Exception $e){
            logger()->error("Payment for Product:$product?->id failed: " . $e->getMessage());

            if($e->getCode() === ErrorCode::TENANT_OUT_OF_BUSINESS){
                throw new Exception("Payment unavailable. Please try again later.", ErrorCode::TRANSACTION_ERROR);
            }

            throw new Exception("Payment for Product:$product?->title failed", ErrorCode::TRANSACTION_ERROR);
        }
    }

    /**
     * @throws Exception
     */
    public function refund(Product $product): Transaction
    {
        return DB::transaction(function() use($product){
            tenant()?->wallet->deposit($product->getPrice(tenant()), [
                ...$product->getMeta(),
                'description' => "Transaction refund"
            ]);
            return $this->wallet->deposit($product->getPrice($this), [
                ...$product->getMeta(),
                'description' => "Transaction refund"
            ]);
        });
    }
}
