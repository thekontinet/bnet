<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\BaseTenantController;

class OrderController extends BaseTenantController
{
    public function index()
    {
        return $this->view('order',[
            'orders' => auth()->user()->orders()->latest()->paginate(50)
        ]);
    }
}
