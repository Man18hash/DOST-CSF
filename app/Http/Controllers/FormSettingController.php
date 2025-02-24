<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FormSetting;

class FormSettingController extends Controller
{
    public function index()
    {
        $formSetting = FormSetting::first();
        return view('admin.manage_form', compact('formSetting'));
    }

    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'fields' => 'required|array',
        ]);

        $formSetting = FormSetting::first();
        if (!$formSetting) {
            $formSetting = new FormSetting();
        }
        $formSetting->fields = $validatedData['fields'];
        $formSetting->save();

        return redirect()->route('admin.manage_form')->with('success', 'Form updated successfully.');
    }
}
