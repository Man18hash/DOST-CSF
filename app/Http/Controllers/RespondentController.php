<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Feedback;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Response;

class RespondentController extends Controller
{
    /**
     * Show all respondents (unfiltered).
     */
    public function index()
    {
        $respondents = Feedback::all();
        $ages        = Feedback::distinct()->pluck('age')->sort();

        return view('admin.respondents', compact('respondents', 'ages'));
    }

    /**
     * Show respondents filtered by sort options (Client Type / Classification).
     */
    public function respondents(Request $request)
    {
        $sort  = $request->input('sort');
        $query = Feedback::query();

        if ($sort) {
            $parts = explode(': ', $sort);
            if (count($parts) === 2) {
                [$field, $value] = $parts;
                $field = strtolower($field);

                if ($field === 'client type') {
                    $query->where('client_type', $value);
                } elseif ($field === 'client classification') {
                    $query->whereJsonContains('client_classification', $value);
                }
            }
        }

        $respondents    = $query->get();
        $ages           = Feedback::distinct()->pluck('age')->sort();
        $clientTypes    = ['Internal', 'External'];
        $clientClasses  = ['General Public', 'Business', 'Government', 'Student'];
        $sortingOptions = [];

        foreach ($clientTypes as $type) {
            $sortingOptions[] = "Client Type: $type";
        }
        $sortingOptions[] = '---';
        foreach ($clientClasses as $classification) {
            $sortingOptions[] = "Client Classification: $classification";
        }

        return view('admin.respondents', compact(
            'respondents',
            'sortingOptions',
            'sort',
            'ages'
        ));
    }

    /**
     * Return JSON for a single respondent (modal preview).
     */
    public function preview($id)
    {
        $respondent = Feedback::findOrFail($id);
        $respondent->client_classification = json_decode($respondent->client_classification, true);

        return response()->json([
            'id'                    => $respondent->id,
            'name'                  => $respondent->name,
            'age'                   => $respondent->age,
            'sex'                   => $respondent->sex,
            'address'               => $respondent->address,
            'client_classification' => $respondent->client_classification,
            'client_type'           => $respondent->client_type,
            'date'                  => $respondent->date,
            'CC1'                   => $respondent->CC1,
            'CC2'                   => $respondent->CC2,
            'CC3'                   => $respondent->CC3,
            'unit_provider'         => $respondent->unit_provider,
            'assistance_availed'    => $respondent->assistance_availed,
            'DOST_employee'         => $respondent->DOST_employee,
            'SQD0'                  => $respondent->SQD0,
            'SQD1'                  => $respondent->SQD1,
            'SQD2'                  => $respondent->SQD2,
            'SQD3'                  => $respondent->SQD3,
            'SQD4'                  => $respondent->SQD4,
            'SQD5'                  => $respondent->SQD5,
            'SQD6'                  => $respondent->SQD6,
            'SQD7'                  => $respondent->SQD7,
            'SQD8'                  => $respondent->SQD8,
            'suggestions'           => $respondent->suggestions,
            'recommendation'        => $respondent->recommendation,
        ]);
    }

    /**
     * Filter respondents by year (and optional month, age, gender).
     */
    public function filterByYear($year, Request $request)
    {
        $month  = $request->input('month');
        $age    = $request->input('age');
        $gender = $request->input('gender');

        $query = Feedback::whereYear('date', $year);

        if ($month) {
            $query->whereMonth('date', $month);
        }
        if ($age) {
            $query->where('age', $age);
        }
        if ($gender) {
            $query->where('sex', $gender);
        }

        $respondents = $query->get();
        $years       = Feedback::selectRaw('YEAR(date) as year')
                        ->distinct()
                        ->orderBy('year', 'desc')
                        ->pluck('year');
        $ages        = Feedback::whereYear('date', $year)
                        ->distinct()
                        ->pluck('age')
                        ->sort();

        return view('admin.respondents_year', compact(
            'respondents',
            'years',
            'year',
            'month',
            'ages'
        ));
    }

    /**
     * Export to PDF.
     */
    public function exportToPDF($year, Request $request)
    {
        $month   = $request->input('month');
        $byMonth = [];

        if ($month) {
            $name                = date("F", mktime(0, 0, 0, $month, 10));
            $byMonth[$name]      = Feedback::whereYear('date', $year)
                                        ->whereMonth('date', $month)
                                        ->get();
        } else {
            for ($m = 1; $m <= 12; $m++) {
                $name             = date("F", mktime(0, 0, 0, $m, 10));
                $byMonth[$name]   = Feedback::whereYear('date', $year)
                                        ->whereMonth('date', $m)
                                        ->get();
            }
        }

        if (empty(array_filter($byMonth))) {
            return back()->with('error', 'No respondents found for the selected filters.');
        }

        $pdf  = Pdf::loadView('exports.respondents_pdf', compact('byMonth', 'year', 'month'));
        $name = "respondents_{$year}" . ($month ? "_". date("F", mktime(0,0,0,$month,10)) : '') . ".pdf";
        return $pdf->download($name);
    }

    /**
     * Export to CSV.
     */
    public function exportCSV($year, Request $request)
    {
        $month      = $request->input('month');
        $query      = Feedback::whereYear('date', $year);
        if ($month) {
            $query->whereMonth('date', $month);
        }
        $respondents = $query->get();

        $filename = "Respondents_{$year}" . ($month ? "_". date("F", mktime(0,0,0,$month,10)) : '') . ".csv";
        $handle   = fopen($filename, 'w');

        fputcsv($handle, [
            'Name','Age','Gender','Unit Provider','Service Availed','DOST Employee'
        ]);

        foreach ($respondents as $r) {
            fputcsv($handle, [
                $r->name,
                $r->age,
                $r->sex,
                $r->unit_provider,
                $r->assistance_availed,
                $r->DOST_employee,
            ]);
        }

        fclose($handle);
        return response()->download($filename)->deleteFileAfterSend(true);
    }
}
