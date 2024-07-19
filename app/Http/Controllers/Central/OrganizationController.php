<?php

namespace App\Http\Controllers\Central;

use App\Http\Controllers\Controller;
use App\Http\Requests\Central\OrganizationRequest;
use App\Services\DomainService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrganizationController extends Controller
{
    public function create(Request $request)
    {
        if($request->user()->domains()->exists())
            abort(403);
        return view('domain.create');
    }

    public function store(OrganizationRequest $request, DomainService $domainService)
    {
        if(implode('', $request->only(['instagram', 'facebook', 'whatsapp'])) == null){
            return redirect()->back()->withErrors([
                'phone' => 'Please provide at least one contact info'
            ]);
        }

        DB::transaction(function() use($request){
            $request->user()->update([
                'config' => [
                    'name' => $request->name,
                    'social.whatsapp' => $request->whatsapp,
                    'social.facebook' => $request->facebook,
                    'social.instagram' => $request->instagram,
                ]
            ]);
            $request->user()->domains()->delete();
            $request->user()->createDomain($request->validated('domain'));
        });

        return redirect()->route('dashboard')
            ->with('message', 'Domain created');
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
