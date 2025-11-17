<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;

use App\Models\JobPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmployerDashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */

public function index(Request $request)
{
    $userId = Auth::id();

    // Base query for this employer's jobs (include soft deleted closed jobs)
    $query = JobPost::withTrashed()->where('user_id', $userId);

    // Apply filters
    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }

    if ($request->filled('search')) {
        $query->where('title', 'like', '%' . $request->search . '%');
    }

    if ($request->filled('from') && $request->filled('to')) {
        $query->whereBetween('created_at', [
            $request->from . ' 00:00:00',
            $request->to . ' 23:59:59'
        ]);
    }
    if ($request->filled('period')) {
        switch ($request->period) {
            case 'today':
                $query->whereDate('created_at', now());
                break;
            case 'this_week':
                $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
                break;
            case 'this_month':
                $query->whereMonth('created_at', now()->month);
                break;
        }
    }

    // Count summary (not filtered)
    $totalJobs = JobPost::withTrashed()->where('user_id', $userId)->count();
    $publishedJobs = JobPost::where('user_id', $userId)->where('status', 'published')->count();
    $draftJobs = JobPost::where('user_id', $userId)->where('status', 'draft')->count();
    $closedJobs = JobPost::withTrashed()->where('user_id', $userId)->where('status', 'closed')->count();

    // Latest jobs (filtered)
    $latestJobs = $query->latest()->paginate(5);

    return view('employer.dashboard.dashboard', compact(
        'totalJobs',
        'publishedJobs',
        'draftJobs',
        'closedJobs',
        'latestJobs'
    ));
}


}
