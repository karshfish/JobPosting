<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Category;
use App\Models\JobPost;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        // High level stats
        $stats = [
            'jobs' => [
                'total' => JobPost::count(),
                'draft' => JobPost::where('status', 'draft')->count(),
                'published' => JobPost::where('status', 'published')->count(),
                'closed' => JobPost::where('status', 'closed')->count(),
            ],
            'applications' => [
                'total' => Application::count(),
                'pending' => Application::where('status', 'pending')->count(),
                'accepted' => Application::where('status', 'accepted')->count(),
                'rejected' => Application::where('status', 'rejected')->count(),
            ],
            'entities' => [
                'users' => User::count(),
                'categories' => Category::count(),
            ],
        ];

        // Aggregated data for charts
        $jobsByStatus = JobPost::selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        $applicationsByStatus = Application::selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        $charts = [
            'jobs_by_status' => [
                'labels' => $jobsByStatus->keys()
                    ->map(fn ($status) => Str::headline($status))
                    ->values()
                    ->all(),
                'data' => $jobsByStatus->values()->all(),
            ],
            'applications_by_status' => [
                'labels' => $applicationsByStatus->keys()
                    ->map(fn ($status) => Str::headline($status))
                    ->values()
                    ->all(),
                'data' => $applicationsByStatus->values()->all(),
            ],
        ];

        // Recent activity
        $recentApplications = Application::with(['user', 'job'])
            ->latest()
            ->limit(5)
            ->get();

        // Admin recent jobs list with filters (similar to employer dashboard)
        $jobsQuery = JobPost::with('user');

        if ($request->filled('status')) {
            $jobsQuery->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $jobsQuery->where('title', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('from') && $request->filled('to')) {
            $jobsQuery->whereBetween('created_at', [
                $request->from . ' 00:00:00',
                $request->to . ' 23:59:59',
            ]);
        }

        if ($request->filled('period')) {
            switch ($request->period) {
                case 'today':
                    $jobsQuery->whereDate('created_at', now());
                    break;
                case 'this_week':
                    $jobsQuery->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
                    break;
                case 'this_month':
                    $jobsQuery->whereMonth('created_at', now()->month);
                    break;
            }
        }

        $latestJobs = $jobsQuery->latest()->paginate(5);

        return view('admin.dashboard.dashboard', [
            'stats' => $stats,
            'charts' => $charts,
            'recentApplications' => $recentApplications,
            'latestJobs' => $latestJobs,
        ]);
    }
}
