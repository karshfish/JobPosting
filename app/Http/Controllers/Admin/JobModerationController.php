<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JobPost;
use Illuminate\Http\Request;

class JobModerationController extends Controller
{
    public function index(Request $request)
    {
        $jobs = JobPost::with('company')
            ->latest('created_at')
            ->paginate(10);

        return view('admin.jobs.index', compact('jobs'));
    }

    public function pending(Request $request)
    {
        $jobs = JobPost::with('company')
            ->where('status', 'pending')
            ->latest('created_at')
            ->paginate(10);

        return view('admin.jobs.index', compact('jobs'));
    }

    public function show(JobPost $job)
    {
        $job->load(['company','category']);
        return view('admin.jobs.show', compact('job'));
    }

    public function approve(JobPost $job)
    {
        $job->update([
            'status' => 'approved',
            'posted_at' => now(),
        ]);

        return back()->with('status', 'Job approved successfully.');
    }

    public function reject(Request $request, JobPost $job)
    {
        $job->update([
            'status' => 'rejected',
        ]);

        return back()->with('status', 'Job rejected.');
    }
}
