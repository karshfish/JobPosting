<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use App\Models\JobPost;
use App\Models\Application;
use Illuminate\Support\Facades\Auth;

class AnalysisController extends Controller
{
    public function index()
    {

        return view('employer.analysis');
    }
}
