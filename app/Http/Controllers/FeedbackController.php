<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Feedback;
use App\Models\FeedbackResponse;

class FeedbackController extends Controller
{
    public function index()
    {
        $fields = Feedback::all(); // Fetch all form fields
        return view('feedback_form', compact('fields'));
    }

}
