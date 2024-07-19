<?php

namespace App\Http\Controllers\Central;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BusinessController extends Controller
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
//            'logo' => ['nullable', 'image',  'mimes:jpeg,png,jpg', 'max:2048'],
            'name' => ['required', 'string'],
            'description' => ['required', 'string', 'max:150'],
            'whatsapp' => ['nullable', 'url'],
            'facebook' => ['nullable', 'url'],
            'instagram' => ['nullable', 'url'],
        ]);

        if($request->hasFile('logo')){
            $validated['logo'] = $request->file('logo')
                ->store("uploads/{$request->user()->id}/logo", 'public');
        }

        $validated['social.facebook'] = $validated['facebook'];
        $validated['social.whatsapp'] = $validated['whatsapp'];
        $validated['social.instagram'] = $validated['instagram'];
        $request->user()->updateConfig($validated);

        return back()
            ->with('message', 'Business info updated')
            ->with('website-updated', 'Business info updated');
    }
}
