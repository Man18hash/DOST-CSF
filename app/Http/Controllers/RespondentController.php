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

    public function respondents(Request $request)
    {
        $sort = $request->input('sort');

        $query = Feedback::query();

        if ($sort) {
            $parts = explode(': ', $sort);
            if (count($parts) == 2) {
                $field = strtolower($parts[0]);
                $value = $parts[1];

                switch ($field) {
                    case 'client type':
                        $query->where('client_type', $value);
                        break;
                    case 'client classification':
                        $query->whereJsonContains('client_classification', $value);
                        break;
                }
            }
        }

        $clientTypes = ['Internal', 'External'];
        $clientClassifications = ['General Public', 'Business', 'Government', 'Student'];

        $sortingOptions = [];

        foreach ($clientTypes as $type) {
            $sortingOptions[] = "Client Type: $type";
        }

        // Add separator for visual distinction
        $sortingOptions[] = "---"; // Separator

        foreach ($clientClassifications as $classification) {
            $sortingOptions[] = "Client Classification: $classification";
        }

        $respondents = $query->get();

        return view('admin.respondents', compact('respondents', 'sortingOptions', 'sort'));
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

    public function filterByYear($year, Request $request)
    {
        $quarter = $request->input('quarter');

        // Start with a base query filtering by the year
        $query = Feedback::whereYear('date', $year);

        // Apply quarter filtering if selected
        if ($quarter) {
            if ($quarter == 1) {
                $query->whereMonth('date', '>=', 1)->whereMonth('date', '<=', 3);
            } elseif ($quarter == 2) {
                $query->whereMonth('date', '>=', 4)->whereMonth('date', '<=', 6);
            } elseif ($quarter == 3) {
                $query->whereMonth('date', '>=', 7)->whereMonth('date', '<=', 9);
            } elseif ($quarter == 4) {
                $query->whereMonth('date', '>=', 10)->whereMonth('date', '<=', 12);
            }
        }

        $respondents = $query->get();
        $years = Feedback::selectRaw('YEAR(date) as year')->distinct()->orderBy('year', 'desc')->pluck('year');

        return view('admin.respondents_year', compact('respondents', 'years', 'year', 'quarter'));
    }

}
