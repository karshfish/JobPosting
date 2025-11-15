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

    // ------------------------------
    // Dashboard
    // ------------------------------
    public function dashboard()
    {
        $user = Auth::user();
        $applications = Application::where('user_id', $user->id)
            ->with('job')
            ->latest()
            ->get();

        return view('candidate.dashboard', compact('user', 'applications'));
    }

    // ------------------------------
    // Profile
    // ------------------------------
    public function editProfile()
    {
        $user = Auth::user();
        return view('candidate.edit-profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'profile_photo' => 'nullable|image|mimes:jpg,jpeg,png',

        ]);

        if ($request->hasFile('profile_photo')) {
            $user->profile_photo_path = $request->file('profile_photo')->store('profile-photos', 'public');
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        return back()->with('success', 'Profile updated.');
    }

    // ------------------------------
    // Show Job
    // ------------------------------
    public function showJob(JobPost $job)
    {
        return view('candidate.show-job-posts', compact('job'));
    }

    // ------------------------------
    // Job Posts + Filters
    // ------------------------------
    public function jobPosts(Request $request)
    {
        $query = JobPost::query();

        // Search by title
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by location
        if ($request->filled('location')) {
            $query->where('location', 'like', '%' . $request->location . '%');
        }

        // Filter by work type
        if ($request->filled('work_type')) {
            $query->where('work_type', $request->work_type);
        }

        // Filter by date posted
        if ($request->filled('date')) {
            switch ($request->date) {
                case 'today':
                    $query->whereDate('created_at', now());
                    break;
                case 'week':
                    $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
                    break;
                case 'month':
                    $query->whereMonth('created_at', now()->month);
                    break;
            }
        }

        // Clone for stats
        $statsQuery = clone $query;

        // Paginate jobs
        $jobs = $query->latest()->paginate(5)->withQueryString();

        // Stats
        $totalJobs     = $statsQuery->count();
        $publishedJobs = $statsQuery->where('status', 'published')->count();
        $draftJobs     = $statsQuery->where('status', 'draft')->count();
        $closedJobs    = $statsQuery->where('status', 'closed')->count();

        // Latest 5 jobs
        $latestJobs = $statsQuery->latest()->take(5)->get();

        return view('candidate.job-posts', compact(
            'jobs',
            'totalJobs',
            'publishedJobs',
            'draftJobs',
            'closedJobs',
            'latestJobs'
        ));
    }


    // ------------------------------
    // Apply
    // ------------------------------
    public function showApplyForm(JobPost $job)
    {
        $user = Auth::user();

        // Check if job is not published
        if ($job->status !== 'published') {
            return back()->with('error', 'You cannot apply to this job because it is not published.');
        }

        // Check if user already applied
        $alreadyApplied = Application::where('user_id', $user->id)
            ->where('job_id', $job->id)
            ->exists();

        if ($alreadyApplied) {
            return back()->with('error', 'You have already applied for this job.');
        }

        return view('candidate.apply', compact('job', 'user'));
    }

    public function submitApplication(Request $request, JobPost $job)
    {
        $user = Auth::user();

        // Prevent apply if job not published
        if ($job->status !== 'published') {
            return back()->with('error', 'You cannot apply because this job is not published.');
        }

        // Prevent duplicate application
        $alreadyApplied = Application::where('user_id', $user->id)
            ->where('job_id', $job->id)
            ->exists();

        if ($alreadyApplied) {
            return back()->with('error', 'You already applied to this job.');
        }

        // Validation
        $request->validate([
            'phone' => 'required|string|max:50',
            'resume' => 'nullable|mimes:pdf|max:2048',
        ]);

        $resume = $user->resume;

        if ($request->hasFile('resume')) {
            $resume = $request->file('resume')->store('resumes', 'public');
        }

        // Create application
        Application::create([
            'user_id' => $user->id,
            'job_id' => $job->id,
            'phone' => $request->phone,
            'resume' => $resume,
            'status' => 'pending',
        ]);

        return redirect()->route('candidate.applications')
            ->with('success', 'Application submitted successfully.');
    }


    // LinkedIn Auto Apply (Fake / Simulation)
    public function applyViaLinkedIn(JobPost $job)
    {
        $user = Auth::user();

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

    // ------------------------------
    // Applications CRUD
    // ------------------------------
    public function applications()
    {
        $user = Auth::user();
        $applications = Application::where('user_id', $user->id)
            ->with('job')
            ->latest()
            ->get();

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
