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
        $job->load([
            'comments' => fn($q) => $q->whereNull('parent_id')->latest(),
            'comments.user',
            'comments.replies.user',
        ]);

        return view('candidate.show-job-posts', compact('job'));
    }

    // ------------------------------
    // Job Posts + Filters
    // ------------------------------
    public function jobPosts(Request $request)
    {
        $query = JobPost::query();

        // Keywords
        if ($request->filled('keywords')) {
            $query->where('title', 'like', '%' . $request->keywords . '%')
                ->orWhere('description', 'like', '%' . $request->keywords . '%');
        }

        // Location
        if ($request->filled('location')) {
            $query->where('location', 'like', '%' . $request->location . '%');
        }

        // Category
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // Salary Range
        if ($request->filled('salary')) {
            $salary = $request->salary;

            $query->where(function ($q) use ($salary) {
                $q->where('salary_min', '<=', $salary)
                    ->where('salary_max', '>=', $salary);
            });
        }

        // Date Posted
        if ($request->filled('date_posted')) {
            if ($request->date_posted == 'today') {
                $query->whereDate('created_at', now());
            } elseif ($request->date_posted == 'week') {
                $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
            } elseif ($request->date_posted == 'month') {
                $query->whereMonth('created_at', now()->month);
            }
        }

        // Pagination
        $jobPosts = $query->paginate(10);

        // Categories list
        $categories = \App\Models\Category::all();

        // Stats
        $allCount       = JobPost::count();
        $publishedCount = JobPost::where('status', 'published')->count();
        $draftCount     = JobPost::where('status', 'draft')->count();
        $closedCount    = JobPost::where('status', 'closed')->count();

        return view('candidate.job-posts', compact(
            'jobPosts',
            'categories',
            'allCount',
            'publishedCount',
            'draftCount',
            'closedCount'
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
            return redirect()->route('candidate.show-job', $job->id)
                ->with('error', 'You have already submitted an application for this job.');
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
            return redirect()->route('candidate.show-job', $job->id)
                ->with('error', 'You have already applied to this job.');
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
