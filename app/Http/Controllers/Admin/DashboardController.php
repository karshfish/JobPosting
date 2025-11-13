<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\JobPost;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $stats = [
            'pending_jobs' => JobPost::where('status', 'pending')->count(),
            'approved_jobs' => JobPost::where('status', 'approved')->count(),
            'categories' => Category::count(),
        ];

        // Chart: jobs by status (pending/approved/rejected)
        $statusRaw = JobPost::select('status', DB::raw('COUNT(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status')
            ->toArray();

        $jobStatusCounts = [
            'pending' => (int)($statusRaw['pending'] ?? 0),
            'approved' => (int)($statusRaw['approved'] ?? 0),
            'rejected' => (int)($statusRaw['rejected'] ?? 0),
        ];

        // Chart: top categories by job count (up to 7)
        $topCategories = JobPost::select('category', DB::raw('COUNT(*) as total'))
            ->whereNotNull('category')
            ->where('category', '!=', '')
            ->groupBy('category')
            ->orderByDesc('total')
            ->limit(7)
            ->get();

        $categoryLabels = $topCategories->pluck('category');
        $categoryTotals = $topCategories->pluck('total');

        return view('admin.dashboard.dashboard', compact('stats', 'jobStatusCounts', 'categoryLabels', 'categoryTotals'));
    }
}
