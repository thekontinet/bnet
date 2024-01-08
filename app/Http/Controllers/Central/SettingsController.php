<?php

namespace App\Http\Controllers\Central;

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
        return view("settings.$type", [
            'user' => Auth::user(),
            'forms' => [
                $this->makeForm(AutomaticPaymentSetting::class, 'Automatic Payment', 'Update automatic payment info to enable automatic payment on your site'),
                $this->makeForm(ManualPaymentSetting::class, 'Manual Payment', 'Update bank details users can deposit to'),
            ]
        ]);
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'form.*' => ['required']
        ]);

        foreach ($validated['form'] as $name => $value){
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
