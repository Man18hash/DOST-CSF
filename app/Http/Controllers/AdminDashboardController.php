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

    public function dashboard()
    {
        $totalRespondents = Feedback::count();
        $maleRespondents = Feedback::where('sex', 'Male')->count();
        $femaleRespondents = Feedback::where('sex', 'Female')->count();

        // Prevent division by zero
        $malePercentage = ($totalRespondents > 0) ? round(($maleRespondents / $totalRespondents) * 100, 2) : 0;
        $femalePercentage = ($totalRespondents > 0) ? round(($femaleRespondents / $totalRespondents) * 100, 2) : 0;

        // Age Distribution
        $ageDistribution = [
            '18-25' => Feedback::whereBetween('age', [18, 25])->count(),
            '26-35' => Feedback::whereBetween('age', [26, 35])->count(),
            '36-45' => Feedback::whereBetween('age', [36, 45])->count(),
            '46-60' => Feedback::whereBetween('age', [46, 60])->count(),
            '60+'   => Feedback::where('age', '>', 60)->count(),
        ];

        // Classification Data (Decode JSON column)
        $classificationLabels = ['General Public', 'Business', 'Government', 'Student'];
        $classificationData = [];

        foreach ($classificationLabels as $label) {
            $classificationData[$label] = Feedback::whereJsonContains('client_classification', $label)->count();
        }

        // Client Type Data
        $internalCount = Feedback::where('client_type', 'Internal')->count();
        $externalCount = Feedback::where('client_type', 'External')->count();

        return view('admin.dashboard', compact(
            'totalRespondents', 'maleRespondents', 'femaleRespondents',
            'malePercentage', 'femalePercentage',
            'ageDistribution', 'classificationData',
            'internalCount', 'externalCount'
        ));
    }

    public function respondents()
    {
        // Fetch all respondents from the Feedback model
        $respondents = Feedback::all();

        // Pass the data to the respondents view
        return view('admin.respondents', compact('respondents'));
    }

}
