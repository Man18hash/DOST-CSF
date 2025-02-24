<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Feedback;

class AdminDashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function dashboard(Request $request)
    {
        $year = $request->input('year', null);

        // Filter data based on the selected year
        $query = Feedback::query();
        if ($year) {
            $query->whereYear('created_at', $year);
        }

        $totalRespondents = $query->count();

        // Use fresh queries for gender counts to avoid incorrect filtering
        $maleRespondents = Feedback::where('sex', 'Male')
            ->when($year, function ($query) use ($year) {
                return $query->whereYear('created_at', $year);
            })->count();

        $femaleRespondents = Feedback::where('sex', 'Female')
            ->when($year, function ($query) use ($year) {
                return $query->whereYear('created_at', $year);
            })->count();

        // Calculate percentages
        $malePercentage = $totalRespondents > 0 ? round(($maleRespondents / $totalRespondents) * 100, 2) : 0;
        $femalePercentage = $totalRespondents > 0 ? round(($femaleRespondents / $totalRespondents) * 100, 2) : 0;

        $ageDistribution = [
            '18-25' => Feedback::whereBetween('age', [18, 25])
                ->when($year, function ($query) use ($year) {
                    return $query->whereYear('created_at', $year);
                })->count(),

            '26-35' => Feedback::whereBetween('age', [26, 35])
                ->when($year, function ($query) use ($year) {
                    return $query->whereYear('created_at', $year);
                })->count(),

            '36-45' => Feedback::whereBetween('age', [36, 45])
                ->when($year, function ($query) use ($year) {
                    return $query->whereYear('created_at', $year);
                })->count(),

            '46-60' => Feedback::whereBetween('age', [46, 60])
                ->when($year, function ($query) use ($year) {
                    return $query->whereYear('created_at', $year);
                })->count(),

            '60+' => Feedback::where('age', '>', 60)
                ->when($year, function ($query) use ($year) {
                    return $query->whereYear('created_at', $year);
                })->count(),
        ];


        // Client Classification Data
        $classificationData = [
            'General Public' => Feedback::whereJsonContains('client_classification', 'General Public')
                ->when($year, function ($query) use ($year) {
                    return $query->whereYear('created_at', $year);
                })->count(),
            'Business' => Feedback::whereJsonContains('client_classification', 'Business')
                ->when($year, function ($query) use ($year) {
                    return $query->whereYear('created_at', $year);
                })->count(),
            'Government' => Feedback::whereJsonContains('client_classification', 'Government')
                ->when($year, function ($query) use ($year) {
                    return $query->whereYear('created_at', $year);
                })->count(),
            'Student' => Feedback::whereJsonContains('client_classification', 'Student')
                ->when($year, function ($query) use ($year) {
                    return $query->whereYear('created_at', $year);
                })->count(),
        ];

        // Client Type Counts
        $internalCount = Feedback::where('client_type', 'Internal')
            ->when($year, function ($query) use ($year) {
                return $query->whereYear('created_at', $year);
            })->count();

        $externalCount = Feedback::where('client_type', 'External')
            ->when($year, function ($query) use ($year) {
                return $query->whereYear('created_at', $year);
            })->count();

        return view('admin.dashboard', compact(
            'totalRespondents', 'malePercentage', 'femalePercentage',
            'ageDistribution', 'classificationData', 'internalCount', 'externalCount'
        ));
    }


    public function respondents(Request $request)
    {
        $year = $request->input('year');
        $clientType = $request->input('client_type');
        $clientClassification = $request->input('client_classification');

        $query = Feedback::query();

        // Filter by Year
        if ($year) {
            $query->whereYear('created_at', $year);
        }

        // Filter by Client Type
        if ($clientType) {
            $query->where('client_type', $clientType);
        }

        // Filter by Client Classification
        if ($clientClassification) {
            $query->whereJsonContains('client_classification', $clientClassification);
        }

        $respondents = $query->get();
        $years = Feedback::selectRaw('YEAR(created_at) as year')->distinct()->orderBy('year', 'desc')->pluck('year');

        return view('admin.respondents', compact('respondents', 'years'));
    }

}
