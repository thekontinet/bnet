<?php

namespace App\Http\Controllers\Central;

use App\Enums\ServiceEnum;
use App\Http\Controllers\Controller;
use App\Models\Package;
use App\Services\PackageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class ServiceController extends Controller
{
    public function __construct(private readonly PackageService $packageService)
    {
    }

    public function index()
    {
        return view('service.index');
    }

    public function edit(Request $request, ServiceEnum $service)
    {
        if(Cache::lock('user' . auth()->id() . 'service-lock', 300, auth()->id())){
            $this->packageService->syncTenantPackages(auth()->user());
        }

        $data = [
            'service' => $service,
            'packages' => []
        ];


        $data['providers'] = Package::query()
            ->where('service', $service)
            ->distinct('provider')
            ->pluck('provider');

        if($request->get('provider')){
            $data['packages'] = Auth::user()->packages()
                ->where('service', $service)
                ->where('provider', $request->get('provider'))
                ->get();
        }

        return view('service.edit', $data);
    }

    public function update(Request $request, ServiceEnum $service)
    {
        $request->validate([
            'form.*' => ['required', 'decimal:2', 'money', 'numeric']
        ], [
            'form.*.required' => 'required',
            'form.*.decimal' => 'invalid format. 2 decimal place number required'
        ]);

        $data = array_map(fn($value) =>  $value * 100, $request->get('form'));

        $this->packageService->updateTenantPackages(\auth()->user(), $data);

        return back()->with('message', 'Packages has been updated');
    }
}
