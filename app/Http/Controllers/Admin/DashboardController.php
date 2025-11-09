<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\JobPost;
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

        return view('admin.dashboard.dashboard', compact('stats'));
    }
}
