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
        // dd(Auth::guard('admin')->user()); // Check if admin session is persisting

        $totalRespondents = Feedback::count();
        $maleRespondents = Feedback::where('sex', '=', 'Male')->count();
        $femaleRespondents = Feedback::where('sex', '=', 'Female')->count();
        $averageAge = Feedback::average('age');

        return view('admin.dashboard', compact('totalRespondents', 'maleRespondents', 'femaleRespondents', 'averageAge'));
    }

}

