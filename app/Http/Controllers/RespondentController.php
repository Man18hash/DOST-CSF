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
        $respondent = Feedback::findOrFail($id); // Find respondent by ID

        // Ensure client classification is properly decoded
        $respondent->client_classification = json_decode($respondent->client_classification, true);

        return response()->json($respondent); // Return JSON response for AJAX
    }

}
