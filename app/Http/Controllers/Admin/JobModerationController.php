<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JobPost;
use Illuminate\Http\Request;

class JobModerationController extends Controller
{
    public function index(Request $request)
    {
        $jobs = JobPost::with('user')   // ← بدل company بـ user
            ->latest('created_at')
            ->paginate(10);

        return view('admin.jobs.index', compact('jobs'));
    }

    public function pending(Request $request)
    {
        $jobs = JobPost::with('user')   // ← هنا برضه
            ->where('status', 'draft')
            ->latest('created_at')
            ->paginate(10);

        return view('admin.jobs.index', compact('jobs'));
    }

    public function show(JobPost $job)
    {
        $job->load('user');

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
