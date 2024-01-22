<?php

namespace App\Http\Controllers\Central;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DomainController extends Controller
{
    public function store(Request $request)
    {
        $mainDomain = $request->host();
        $request->validateWithBag('domainCreated', [
           'domain' => ['required', 'string', "ends_with:$mainDomain",  'regex:/^(?:[-A-Za-z0-9]+\.)+[A-Za-z]{2,6}$/', 'unique:domains,domain']
        ], [
            'domain.regex' => 'invalid domain name'
        ]);

        DB::transaction(function() use($request){
            $this->resetDomain($request);

            $request->user()->createDomain($request->get('domain'));
        });

        return back()->with('status', 'domain-created');
    }

    public function update(Request $request)
    {
        $this->resetDomain($request);

        return back()->with('status', 'domain-reset');
    }

    private function resetDomain(Request $request)
    {
        if($request->user()->domains()->count() > 1){
            $request->user()->domains()->latest()->first()->delete();
        }
    }
}
