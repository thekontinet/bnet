<?php

namespace App\Http\Controllers\Central;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    public function index(Request $request)
    {
        //TODO: Add search and filter feature
        return view('orders.index', [
            'orders' => $request->user()->orders()
                ->with(['owner'])->latest()->paginate(50)
        ]);
    }
}
