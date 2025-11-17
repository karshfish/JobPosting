<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JobPost;
use Illuminate\Http\Request;

class JobModerationController extends Controller
{
    public function index(Request $request)
    {
        // Default view: same as the "Draft" filter
        return $this->pending($request);
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
            'closed' => JobPost::withTrashed()->where('status', 'closed')->count(),
        ];

        $viewMode = 'draft';

        return view('admin.jobs.index', compact('jobs', 'statusCounts', 'viewMode'));
    }

    public function published(Request $request)
    {
        $jobs = JobPost::with(['user', 'category'])
            ->withCount('applications')
            ->where('status', 'published')
            ->latest('created_at')
            ->paginate(10);

        $statusCounts = [
            'draft' => JobPost::where('status', 'draft')->count(),
            'published' => JobPost::where('status', 'published')->count(),
            'closed' => JobPost::withTrashed()->where('status', 'closed')->count(),
        ];

        $viewMode = 'published';

        return view('admin.jobs.index', compact('jobs', 'statusCounts', 'viewMode'));
    }

    public function trashed(Request $request)
    {
        $jobs = JobPost::onlyTrashed()
            ->with(['user', 'category'])
            ->where('status', 'closed')
            ->withCount('applications')
            ->latest('deleted_at')
            ->paginate(10);

        $statusCounts = [
            'draft' => JobPost::where('status', 'draft')->count(),
            'published' => JobPost::where('status', 'published')->count(),
            'closed' => JobPost::withTrashed()->where('status', 'closed')->count(),
        ];

        $viewMode = 'closed';

        return view('admin.jobs.index', compact('jobs', 'statusCounts', 'viewMode'));
    }

    public function show(int $jobId)
    {
        $job = JobPost::withTrashed()
            ->with(['user', 'category'])
            ->withCount('applications')
            ->findOrFail($jobId);

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

        // Soft delete closed job instead of using a separate archive action
        $job->delete();

        return back()->with('status', 'Job closed/rejected.');
    }

    public function destroy(JobPost $job)
    {
        $job->delete();

        return back()->with('status', 'Job archived.');
    }

    public function restore(Request $request, int $jobId)
    {
        $job = JobPost::withTrashed()->findOrFail($jobId);

        if (! $job->trashed()) {
            return back()->with('status', 'Job is already active.');
        }

        $job->restore();

        return redirect()->route('admin.jobs.index')->with('status', 'Job restored.');
    }

    public function forceDelete(int $jobId)
    {
        $job = JobPost::withTrashed()->findOrFail($jobId);

        if (! $job->trashed()) {
            return back()->with('status', 'Job is not archived.');
        }

        $job->forceDelete();

        return redirect()->route('admin.jobs.trashed')->with('status', 'Job permanently deleted.');
    }

    public function republish(int $jobId)
    {
        $job = JobPost::withTrashed()->findOrFail($jobId);

        if ($job->status !== 'closed') {
            return back()->with('status', 'Only closed jobs can be republished.');
        }

        if ($job->trashed()) {
            $job->restore();
        }

        $job->update(['status' => 'published']);

        return redirect()->route('admin.jobs.index')->with('status', 'Job republished.');
    }
}
