<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JobPost;
use Illuminate\Http\Request;

class JobModerationController extends Controller
{
    public function index(Request $request)
    {
        $jobs = JobPost::with(['user', 'category'])
            ->withCount('applications')
            ->latest('created_at')
            ->paginate(10);

        $statusCounts = [
            'draft' => JobPost::where('status', 'draft')->count(),
            'published' => JobPost::where('status', 'published')->count(),
            'closed' => JobPost::where('status', 'closed')->count(),
        ];

        $viewMode = 'all';

        return view('admin.jobs.index', compact('jobs', 'statusCounts', 'viewMode'));
    }

    public function pending(Request $request)
    {
        $jobs = JobPost::with(['user', 'category'])
            ->withCount('applications')
            ->where('status', 'draft')
            ->latest('created_at')
            ->paginate(10);

        $statusCounts = [
            'draft' => JobPost::where('status', 'draft')->count(),
            'published' => JobPost::where('status', 'published')->count(),
            'closed' => JobPost::where('status', 'closed')->count(),
        ];

        $viewMode = 'draft';

        return view('admin.jobs.index', compact('jobs', 'statusCounts', 'viewMode'));
    }

    public function show(JobPost $job)
    {
        $job->load(['user', 'category'])
            ->loadCount('applications');

        return view('admin.jobs.show', compact('job'));
    }

    public function approve(JobPost $job)
    {
        $job->update([
            'status' => 'published',
        ]);

        return back()->with('status', 'Job published successfully.');
    }

    public function reject(Request $request, JobPost $job)
    {
        $job->update([
            'status' => 'closed',
        ]);

        return back()->with('status', 'Job closed/rejected.');
    }
}

