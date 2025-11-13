<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JobPost;
use App\Models\Application;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class CandidateController extends Controller
{
    use AuthorizesRequests;

    // Dashboard
    public function dashboard()
    {
        $user = Auth::user();
        $applications = Application::where('user_id', $user->id)
            ->with('job')
            ->latest()
            ->get();

        return view('candidate.dashboard', compact('user', 'applications'));
    }

    // Profile
    public function editProfile()
    {
        $user = Auth::user();
        return view('candidate.edit-profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'phone' => 'nullable|string|max:50',
            'address' => 'nullable|string|max:255',
            'resume' => 'nullable|mimes:pdf|max:2048',
        ]);

        if ($request->hasFile('resume')) {
            $user->resume = $request->file('resume')->store('resumes', 'public');
        }

        $user->phone = $request->phone;
        $user->address = $request->address;
        // $user->save();

        return back()->with('success', 'Profile updated.');
    }

    // Jobs - صفحة Job Posts مع الإحصائيات والفلاتر
    public function showJob(JobPost $job)
    {
        return view('candidate.show-job-posts', compact('job'));
    }
    public function jobPosts(Request $request)
    {
        // Base query
        $query = JobPost::query();

        // Filters
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('from')) {
            $query->whereDate('created_at', '>=', $request->from);
        }
        if ($request->filled('to')) {
            $query->whereDate('created_at', '<=', $request->to);
        }

        // Paginated jobs for grid
        $jobs = $query->latest()->paginate(5)->withQueryString();

        // Stats
        $totalJobs = JobPost::count();
        $publishedJobs = JobPost::where('status', 'published')->count();
        $draftJobs = JobPost::where('status', 'draft')->count();
        $closedJobs = JobPost::where('status', 'closed')->count();

        // Latest jobs for table
        $latestJobs = $query->latest()->paginate(5);

        return view('candidate.job-posts', compact(
            'jobs',
            'totalJobs',
            'publishedJobs',
            'draftJobs',
            'closedJobs',
            'latestJobs'
        ));
    }

    public function showApplyForm(JobPost $job)
    {
        $user = Auth::user();
        return view('candidate.apply', compact('job', 'user'));
    }

    public function submitApplication(Request $request, JobPost $job)
    {
        $user = Auth::user();

        $request->validate([
            'phone' => 'required|string|max:50',
            'resume' => 'nullable|mimes:pdf|max:2048',
        ]);

        $resume = $user->resume;
        if ($request->hasFile('resume')) {
            $resume = $request->file('resume')->store('resumes', 'public');
        }

        Application::create([
            'user_id' => $user->id,
            'job_id' => $job->id,
            'phone' => $request->phone,
            'resume' => $resume,
            'status' => 'pending',
        ]);

        return redirect()->route('candidate.applications')->with('success', 'Application submitted.');
    }

    public function applyViaLinkedIn(JobPost $job)
    {
        $user = Auth::user();

        // Simulation for LinkedIn integration
        $linkedinPhone = $user->phone ?? '01000000000';
        $linkedinResume = $user->resume ?? null;

        Application::create([
            'user_id' => $user->id,
            'job_id' => $job->id,
            'phone' => $linkedinPhone,
            'resume' => $linkedinResume,
            'status' => 'pending',
        ]);

        return redirect()->route('candidate.applications')->with('success', 'Applied via LinkedIn!');
    }

    // Applications CRUD
    public function applications()
    {
        $user = Auth::user();
        $applications = Application::where('user_id', $user->id)->with('job')->latest()->get();
        return view('candidate.applications', compact('applications'));
    }

    public function editApplication(Application $application)
    {
        if ($application->user_id !== Auth::id()) {
            abort(403);
        }

        $user = Auth::user();
        return view('candidate.edit-application', compact('application', 'user'));
    }

    public function updateApplication(Request $request, Application $application)
    {
        if ($application->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'resume' => 'nullable|mimes:pdf|max:2048',
            'phone' => 'nullable|string|max:50',
        ]);

        $application->phone = $request->phone;

        if ($request->hasFile('resume')) {
            $application->resume = $request->file('resume')->store('resumes', 'public');
        }

        $application->save();

        return back()->with('success', 'Application updated.');
    }


    public function deleteApplication(Application $application)
    {
        if ($application->user_id !== Auth::id()) {
            abort(403);
        }

        $application->delete();
        return back()->with('success', 'Application deleted.');
    }
}
