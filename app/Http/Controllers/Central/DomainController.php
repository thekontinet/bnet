<?php

namespace App\Http\Controllers\Central;

use App\Http\Controllers\Controller;
use App\Http\Requests\Central\OrganizationRequest;

class DomainController extends Controller
{
    public function store(OrganizationRequest $request)
    {
        $domain = $request->validated('domain');
        $request->user()->domain()->update(compact('domain'));
        return back()->with(['message' => 'Domain saved']);
    }
}
