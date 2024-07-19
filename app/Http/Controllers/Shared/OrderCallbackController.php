<?php

namespace App\Http\Controllers\Shared;

use App\Enums\StatusEnum;
use App\Http\Controllers\Controller;
use App\Models\Item;
use Exception;
use Illuminate\Http\Request;

class OrderCallbackController extends Controller
{
    public function __invoke(Item $item, Request $request){
        try{
            logger()->info('Checking item: ' . $item->id, $request->all());

            if($request->get('delivery_status') === 'success'){
                $item->updateStatus(StatusEnum::DELIVERED, $request->get('gateway_response'));
            }else{
                $item->updateStatus(StatusEnum::FAILED, $request->get('gateway_response'));
            }
        }catch (Exception $e){
            logger()->error($e);
        }
    }
}
