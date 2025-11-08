<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use App\Models\JobPost;
use Illuminate\Support\Facades\Auth;

class EmployerDashboardController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        $totalJobs = JobPost::where('user_id', $userId)->count();
        $publishedJobs = JobPost::where('user_id', $userId)->where('status', 'published')->count();
        $draftJobs = JobPost::where('user_id', $userId)->where('status', 'draft')->count();
        $closedJobs = JobPost::where('user_id', $userId)->where('status', 'closed')->count();

        $latestJobs = JobPost::where('user_id', $userId)->latest()->take(5)->get();

        return view('employer.dashboard', compact('totalJobs', 'publishedJobs', 'draftJobs', 'closedJobs', 'latestJobs'));
    }
}
