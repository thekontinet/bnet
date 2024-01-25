<?php

namespace App\Http\Controllers\Central;

use App\Http\Controllers\Controller;
use App\Http\Requests\Central\DomainRequest;
use App\Libs\WhoIsApi;
use App\Services\DomainService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Stancl\Tenancy\Database\Models\Domain;

class DomainController extends Controller
{
    public function create(Request $request)
    {
        if($request->user()->domains()->exists())
            return redirect()->route('dashboard');
        return view('domain.create');
    }

    public function store(DomainRequest $request, DomainService $domainService)
    {
        if($domainService->checkAvailability($request->validated('domain')) === true){
            DB::transaction(function() use($request){
                $this->resetToFirstDomain($request);
                $request->user()->createDomain($request->validated('domain'));
            });

            return redirect()->back()
                ->with('message', 'Domain created');
        }



        return back()->withErrors(
            ['domain' => $request->messages()['domain.unique']],
            'domainCreated'
        );
    }

    public function destroy(Request $request)
    {
        $this->resetToFirstDomain($request);
        return back()->with('status', 'domain-reset');
    }

    private function resetToFirstDomain(Request $request)
    {
        if($request->user()->domains()->count() > 1){
            $request->user()->domains()->latest()->first()->delete();
        }
    }
}
