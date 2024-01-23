<?php

namespace App\Http\Controllers\Central;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WebsiteController extends Controller
{
    public function edit()
    {
        return view('website.edit', [
            'tenant' => auth()->user(),
        ]);
    }

    public function update(Request $request)
    {
        $validated = $request->validateWithBag('websiteUpdated', [
            'logo' => ['nullable', 'file', 'mimes:jpeg,png,jpg', 'max:2048'],
            'brand_name' => ['required', 'string'],
            'brand_description' => ['required', 'string', 'max:150'],
        ]);

        if($request->hasFile('logo')){
            $validated['logo'] = $request->file('logo')
                ->store("uploads/{$request->user()->id}/logo", 'public');
        }

        $request->user()->update($validated);

        return to_route('site')
            ->with('website-updated', 'Business info updated');
    }
}
