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

        return view('admin.dashboard', compact(
            'totalRespondents', 'maleRespondents', 'femaleRespondents',
            'malePercentage', 'femalePercentage'
        ));
    }

    public function respondents()
    {
        return view('admin.respondents'); // Ensure you have this view
    }

}

