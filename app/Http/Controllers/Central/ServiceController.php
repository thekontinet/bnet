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
        return view('service.index', [
            'services' => ServiceEnum::cases()
        ]);
    }

    public function show(ServiceEnum $service)
    {
        return view('service.show', [
            'service' => $service,
            'providers' => Package::query()
                ->where('service', $service)
                ->distinct('provider')
                ->pluck('provider')
        ]);
    }

    public function edit(ServiceEnum $service, string $provider)
    {
        return view('service.edit', [
            'service' => $service,
            'provider' => $provider,
            'packages' => Auth::user()->packages()
                ->orderBy('package_id')
                ->where('service', $service)
                ->where('provider', $provider)
                ->get()
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'fixed' => ['sometimes', 'array'],
            'fixed.*' => ['sometimes', 'decimal:2', 'money', 'numeric'],
            'discount' => ['sometimes', 'array'],
            'discount.*' => ['sometimes', 'integer']
        ], [
            'fixed.*.decimal' => 'Please provide a number with two decimal places',
            'discount.*.integer' => 'Please enter a whole number for the discount.',
        ]);

        $data = ($request->get('fixed') ?? []) + ($request->get('discount') ?? []);


        $packages = Package::query()->whereIn('id', array_keys($data))->get();

        $this->packageService->addPackagesToTenant($packages, auth()->user(), $data, true);

        return back()->with('message', 'Packages has been updated');
    }
}
