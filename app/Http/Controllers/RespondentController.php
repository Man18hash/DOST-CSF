<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Feedback; // Import the Feedback model
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Response;


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
        $age = $request->input('age');
        $gender = $request->input('gender');

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

        // 🔥 Apply Age and Gender Filtering
        if ($age) {
            $query->where('age', $age);
        }

        if ($gender) {
            $query->where('sex', $gender);
        }

        // Get the filtered respondents
        $respondents = $query->get();

        // Get unique years for the dropdown
        $years = Feedback::selectRaw('YEAR(date) as year')->distinct()->orderBy('year', 'desc')->pluck('year');

        // Get unique ages for filtering
        $ages = Feedback::whereYear('date', $year)->distinct()->pluck('age')->sort();

        return view('admin.respondents_year', compact('respondents', 'years', 'year', 'quarter', 'ages'));
    }


    public function exportToPDF($year, Request $request)
    {
        $quarter = $request->input('quarter'); // Get selected quarter

        // Define quarter-month mapping
        $quarters = [
            '1' => ['Q1 (January - March)', [1, 2, 3]],
            '2' => ['Q2 (April - June)', [4, 5, 6]],
            '3' => ['Q3 (July - September)', [7, 8, 9]],
            '4' => ['Q4 (October - December)', [10, 11, 12]]
        ];

        $respondentsByQuarter = [];

        if ($quarter && isset($quarters[$quarter])) {
            // If a quarter is selected, fetch only that quarter's data
            $title = $quarters[$quarter][0];
            $respondentsByQuarter[$title] = Feedback::whereYear('date', $year)
                ->whereIn(\DB::raw('MONTH(date)'), $quarters[$quarter][1])
                ->get();
        } else {
            // If no quarter is selected, fetch all records within the year
            foreach ($quarters as $key => [$title, $months]) {
                $respondentsByQuarter[$title] = Feedback::whereYear('date', $year)
                    ->whereIn(\DB::raw('MONTH(date)'), $months)
                    ->get();
            }
        }

        // Prevent exporting empty PDFs
        if (empty(array_filter($respondentsByQuarter))) {
            return back()->with('error', 'No respondents found for the selected filters.');
        }

        // Load the PDF view with the filtered data
        $pdf = Pdf::loadView('exports.respondents_pdf', compact('respondentsByQuarter', 'year', 'quarter'));

        return $pdf->download("respondents_{$year}_quarter_{$quarter}.pdf");
    }


    public function exportCSV($year, Request $request)
    {
        $quarter = $request->input('quarter');

        // Define quarter-month mapping
        $quarters = [
            '1' => [1, 2, 3],
            '2' => [4, 5, 6],
            '3' => [7, 8, 9],
            '4' => [10, 11, 12]
        ];

        $query = Feedback::whereYear('date', $year);

        if ($quarter && isset($quarters[$quarter])) {
            $query->whereIn(\DB::raw('MONTH(date)'), $quarters[$quarter]);
        }

        $respondents = $query->get();

        $filename = "Respondents_{$year}_quarter_{$quarter}.csv";
        $handle = fopen($filename, 'w');
        fputcsv($handle, ['Name', 'Age', 'Gender', 'Unit Provider', 'Service Availed', 'DOST Employee']);

        foreach ($respondents as $respondent) {
            fputcsv($handle, [
                $respondent->name,
                $respondent->age,
                $respondent->sex,
                $respondent->unit_provider,
                $respondent->assistance_availed,
                $respondent->DOST_employee
            ]);
        }

        fclose($handle);

        return response()->download($filename)->deleteFileAfterSend(true);
    }

}
