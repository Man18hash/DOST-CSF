<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Feedback; // Import the Feedback model

class RespondentController extends Controller
{
    // Display the list of respondents
    public function index()
    {
        $respondents = Feedback::all(); // Fetch all respondents
        return view('admin.respondents', compact('respondents'));
    }

    // Fetch a specific respondent's feedback for the modal preview
    public function preview($id)
    {
        $respondent = Feedback::findOrFail($id);

        // Ensure client classification is properly decoded
        $respondent->client_classification = json_decode($respondent->client_classification, true);

        return response()->json([
            'id' => $respondent->id,
            'name' => $respondent->name,
            'age' => $respondent->age,
            'sex' => $respondent->sex,
            'address' => $respondent->address,
            'client_classification' => $respondent->client_classification,
            'client_type' => $respondent->client_type,
            'date' => $respondent->date,
            // **Include missing fields**
            'CC1' => $respondent->CC1,
            'CC2' => $respondent->CC2,
            'CC3' => $respondent->CC3,
            'unit_provider' => $respondent->unit_provider,
            'assistance_availed' => $respondent->assistance_availed,
            'DOST_employee' => $respondent->DOST_employee,
            'SQD0' => $respondent->SQD0,
            'SQD1' => $respondent->SQD1,
            'SQD2' => $respondent->SQD2,
            'SQD3' => $respondent->SQD3,
            'SQD4' => $respondent->SQD4,
            'SQD5' => $respondent->SQD5,
            'SQD6' => $respondent->SQD6,
            'SQD7' => $respondent->SQD7,
            'SQD8' => $respondent->SQD8,
            'suggestions' => $respondent->suggestions,
            'recommendation' => $respondent->recommendation,
        ]);
    }
}
