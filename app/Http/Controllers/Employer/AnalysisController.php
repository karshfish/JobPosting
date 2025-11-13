<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\JobPost;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class AnalysisController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        // 1. Applications by Status
        $applicationsPending = Application::whereHas('job', fn($q) => $q->where('user_id', $userId))
            ->where('status', 'pending')->count();
        $applicationsaccepted = Application::whereHas('job', fn($q) => $q->where('user_id', $userId))
            ->where('status', 'accepted')->count();
        $applicationsRejected = Application::whereHas('job', fn($q) => $q->where('user_id', $userId))
            ->where('status', 'rejected')->count();

        // 2. Applications Trend (last 6 months)
        $months = [];
        $applicationsPerMonth = [];

        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $months[] = $month->format('M');
            $applicationsPerMonth[] = Application::whereHas('job', fn($q) => $q->where('user_id', $userId))
                ->whereMonth('created_at', $month->month)
                ->whereYear('created_at', $month->year)
                ->count();
        }

        // 3. Top Jobs by applications
        $topJobs = JobPost::withCount('applications')
            ->where('user_id', $userId)
            ->orderBy('applications_count', 'desc')
            ->limit(5)
            ->get();

        // 4. Total Users Trend (all candidates over 6 months)
        $usersPerMonth = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $usersPerMonth[] = User::whereMonth('created_at', $month->month)
                ->whereYear('created_at', $month->year)
                ->count();
        }

        return view('employer.analysis.index', compact(
            'applicationsPending',
            'applicationsaccepted',
            'applicationsRejected',
            'months',
            'applicationsPerMonth',
            'topJobs',
            'usersPerMonth'
        ));
    }
}
