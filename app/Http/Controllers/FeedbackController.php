<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Feedback; // Assume you have a Feedback model

class FeedbackController extends Controller
{
    public function index()
    {
        return view('feedback_form'); // Blade file
    }

    public function store(Request $request)
    {
        $fields = $request->input('field_name');
        $types = $request->input('field_type');

        foreach ($fields as $index => $field) {
            Feedback::create([
                'field_name' => $field,
                'field_type' => $types[$index]
            ]);
        }

        return redirect()->route('feedback.form')->with('success', 'Form fields saved successfully!');
    }
}
