<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Feedback;
use App\Models\DOSTEmployee;
use App\Models\UnitProvider;


class FeedbackController extends Controller
{
    public function index()
    {
        $unitProviders = UnitProvider::all();
        return view('feedback_form', compact('unitProviders'));
    }

    public function getEmployeesByUnit($unitProviderId)
    {
        $employees = DOSTEmployee::where('unit_provider_id', $unitProviderId)->pluck('name', 'id');
        return response()->json($employees);
    }

    // ✅ Add this method to handle form submissions
    public function store(Request $request)
    {
        \Log::info('Received Form Data:', $request->all()); // ✅ Log the incoming request

        // Validate the form data
        $validated = $request->validate([
            'name' => 'nullable|string|max:255',
            'age' => 'required|integer',
            'sex' => 'required|in:Male,Female',
            'address' => 'required|string|max:255',
            'client_classification' => 'required|array',
            'client_type' => 'required|in:Internal,External',
            'date' => 'required|date',
            'CC1' => 'required|string',
            'CC2' => 'nullable|string',
            'CC3' => 'nullable|string',
            'unit_provider' => 'required|string|max:255',
            'assistance_availed' => 'required|string|max:255',
            'DOST_employee' => 'required|string|max:255',
            'SQD0' => 'required|string|between:1,5',
            'SQD1' => 'required|string|between:1,5',
            'SQD2' => 'required|string|between:1,5',
            'SQD3' => 'required|string|between:1,5',
            'SQD4' => 'required|string|between:1,5',
            'SQD5' => 'required|string|between:1,5',
            'SQD6' => 'required|string|between:1,5',
            'SQD7' => 'required|string|between:1,5',
            'SQD8' => 'required|string|between:1,5',
            'suggestions' => 'nullable|string',
            'recommendation' => 'required|integer|between:1,10',
        ]);

        \Log::info('Validated Data:', $validated); // ✅ Log validated data

        // Save feedback to the database
        try {
            $feedback = Feedback::create([
                'name' => $request->name,
                'age' => $request->age,
                'sex' => $request->sex,
                'address' => $request->address,
                'client_classification' => json_encode($request->client_classification), // Convert array to JSON
                'client_type' => $request->client_type,
                'date' => $request->date,
                'CC1' => $request->CC1,
                'CC2' => $request->CC2,
                'CC3' => $request->CC3,
                'unit_provider' => $request->unit_provider,
                'assistance_availed' => $request->assistance_availed,
                'DOST_employee' => $request->DOST_employee,
                'SQD0' => $request->SQD0,
                'SQD1' => $request->SQD1,
                'SQD2' => $request->SQD2,
                'SQD3' => $request->SQD3,
                'SQD4' => $request->SQD4,
                'SQD5' => $request->SQD5,
                'SQD6' => $request->SQD6,
                'SQD7' => $request->SQD7,
                'SQD8' => $request->SQD8,
                'suggestions' => $request->suggestions,
                'recommendation' => $request->recommendation,
            ]);

            \Log::info('Feedback Successfully Saved:', $feedback->toArray()); // ✅ Log saved data
        } catch (\Exception $e) {
            \Log::error('Error Saving Feedback: ' . $e->getMessage()); // ❌ Log errors
        }

        return redirect()->route('home')->with('success', 'Feedback submitted successfully.');
    }

}
