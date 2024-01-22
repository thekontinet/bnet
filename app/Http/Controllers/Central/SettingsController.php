<?php

namespace App\Http\Controllers\Central;

use App\Enums\Config;
use App\Enums\Settings\AutomaticPaymentSetting;
use App\Enums\Settings\ManualPaymentSetting;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

//TODO: Test this controller
class SettingsController extends Controller
{

    public function edit(Request $request, string $type)
    {
        /**
         * To add more preference settings, add more makeForm() to the array
         */

        /**
         * TODO: Restructure the settings class. The implementation is not cool
         */
        return view("settings.payment", [
            'user' => Auth::user(),
            'forms' => \config("form.$type")
        ]);
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'form.*' => []
        ]);

        $data = $validated['form'];

        foreach ($request->allFiles()['form'] ?? [] as $key => $file){
            $data[$key] = $file->store("uploads", 'public');
        }

        foreach ($data as $name => $value){
            Auth::user()->settings()->set($name, $value);
        }

        return back()->with('message', 'upadated');
    }

    public function makeForm(string $fields, ?string $title = null, ?string $description = null)
    {
        return [
            'title' => $title,
            'description' => $description,
            'fields' => $fields::getFields()
        ];
    }
}
