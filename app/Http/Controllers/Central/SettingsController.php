<?php

namespace App\Http\Controllers\Central;

use App\Enums\Settings\AutomaticPaymentSetting;
use App\Enums\Settings\ManualPaymentSetting;
use App\Enums\TenantSettingsType;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SettingsController extends Controller
{

    public function edit(Request $request, TenantSettingsType $type)
    {
        return view("settings.payment", [
            'user' => Auth::user(),
            'forms' => $type->getForms()
        ]);
    }

    public function update(Request $request, TenantSettingsType $type)
    {
        $validated = $request->validate($type->rules(), $type->messages());

//        foreach ($request->allFiles() ?? [] as $key => $file){
//            $data[$key] = $file->store("uploads", 'public');
//        }

        $data =  Auth::user()->config ?? [];

        $data = $type->modeifyDataBeforeSave((array) $data, $validated);


        Auth::user()->updateConfig($data);


        return redirect()->back()->with('message', 'updated');
    }
}
