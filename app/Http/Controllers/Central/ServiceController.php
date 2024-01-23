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

    public function edit(Request $request, ?ServiceEnum $service = null)
    {
        return view('service.index', [
            'service' => $service,
            'providers' => $service ? Package::query()
                ->where('service', $service)
                ->distinct('provider')
                ->pluck('provider') : null,
            'packages' => $request->query('provider') ? Auth::user()->packages()
                ->orderBy('package_id')
                ->where('service', $service)
                ->where('provider', $request->get('provider'))
                ->get() : null
        ]);
    }

    public function update(Request $request, ServiceEnum $service)
    {
        $request->validate([
            'form.*' => $service->pricingTypeIsFixed() ?
                ['required', 'decimal:2', 'money', 'numeric']:
                ['required', 'numeric', 'max:100', 'min:1']
        ], [
            'form.*.required' => 'required',
            'form.*.decimal' => 'invalid format. 2 decimal place number required'
        ]);

        $data = $request->get('form');

        $packages = Package::query()->whereIn('id', array_keys($data))->get();

        $this->packageService->addPackagesToTenant($packages, auth()->user(), $data, true);

        return back()->with('message', 'Packages has been updated');
    }
}
