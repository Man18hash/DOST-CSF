<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Feedback;
use App\Models\Office;
use App\Models\UnitProvider;
use App\Models\DOSTEmployee;

class FeedbackController extends Controller
{
    /**
     * Show the feedback form.
     */
    public function index()
    {
        $offices       = Office::all();
        $unitProviders = UnitProvider::all();
        $employees     =  [];

        return view('feedback_form', compact('offices', 'unitProviders', 'employees'));
    }

    /**
     * AJAX endpoint to get employees for a given unit provider.
     */
    // GET UNITS BY OFFICE
public function getUnitsByOffice($office_id)
{
    return response()->json(
        \App\Models\UnitProvider::where('office_id', $office_id)
            ->where('status', 'Active')
            ->pluck('unit_name', 'id')
    );
}

// GET EMPLOYEES BY UNIT
public function getEmployeesByUnit($unit_id)
{
    $employees = DOSTEmployee::where('unit_provider_id', $unit_id)
        ->where('status', 'Active')
        ->get(['id', 'name']);

    \Log::info("EMPLOYEES AJAX RETURNED:", $employees->toArray()); // 💥 Log it raw

    return response()->json($employees->pluck('name', 'id'));
}



    /**
     * Handle the form submission and save to database.
     */
    public function store(Request $request)
    {
        \Log::info('Received Form Data:', $request->all());

        $validated = $request->validate([
            'name'                  => 'nullable|string|max:255',
            'age'                   => 'required|integer',
            'sex'                   => 'required|in:Male,Female',
            'address'               => 'required|string|max:255',
            'client_classification' => 'required|string|max:255',
            'client_type'           => 'required|in:Internal,External',
            'date'                  => 'required|date',
            'office_id'             => 'required|exists:offices,id', // ✅ FIXED: validation here
            'CC1'                   => 'required|string|max:255',
            'CC2'                   => 'nullable|string|max:255',
            'CC3'                   => 'nullable|string|max:255',
            'unit_provider'         => 'required|integer|exists:unit_providers,id',
            'assistance_availed'    => 'required|string|max:255',
            'DOST_employee'         => 'required|integer|exists:dost_employees,id',
            'SQD0'                  => 'required|in:1,2,3,4,5,N/A',
            'SQD1'                  => 'required|in:1,2,3,4,5,N/A',
            'SQD2'                  => 'required|in:1,2,3,4,5,N/A',
            'SQD3'                  => 'required|in:1,2,3,4,5,N/A',
            'SQD4'                  => 'required|in:1,2,3,4,5,N/A',
            'SQD5'                  => 'required|in:1,2,3,4,5,N/A',
            'SQD6'                  => 'required|in:1,2,3,4,5,N/A',
            'SQD7'                  => 'required|in:1,2,3,4,5,N/A',
            'SQD8'                  => 'required|in:1,2,3,4,5,N/A',
            'suggestions'           => 'nullable|string',
            'recommendation'        => 'required|integer|between:1,10',
        ]);

        \Log::info('Validated Data:', $validated);

        try {
            $feedback = Feedback::create([
                'name'                  => $validated['name'] ?? null,
                'age'                   => $validated['age'],
                'sex'                   => $validated['sex'],
                'address'               => $validated['address'],
                'client_classification' => json_encode($validated['client_classification']),
                'client_type'           => $validated['client_type'],
                'date'                  => $validated['date'],
                'office_id'             => $validated['office_id'], // ✅ FIXED: assign value here
                'CC1'                   => $validated['CC1'],
                'CC2'                   => $validated['CC2'] ?? null,
                'CC3'                   => $validated['CC3'] ?? null,
                'unit_provider'         => $validated['unit_provider'],
                'assistance_availed'    => $validated['assistance_availed'],
                'DOST_employee'         => $validated['DOST_employee'],
                'SQD0'                  => $validated['SQD0'],
                'SQD1'                  => $validated['SQD1'],
                'SQD2'                  => $validated['SQD2'],
                'SQD3'                  => $validated['SQD3'],
                'SQD4'                  => $validated['SQD4'],
                'SQD5'                  => $validated['SQD5'],
                'SQD6'                  => $validated['SQD6'],
                'SQD7'                  => $validated['SQD7'],
                'SQD8'                  => $validated['SQD8'],
                'suggestions'           => $validated['suggestions'] ?? null,
                'recommendation'        => $validated['recommendation'],
            ]);

            \Log::info('Feedback Successfully Saved:', $feedback->toArray());
        } catch (\Exception $e) {
            \Log::error('Error Saving Feedback: ' . $e->getMessage());
        }

        return redirect()->route('home')
                         ->with('success', 'Feedback submitted successfully.');
    }
}
