<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use Illuminate\Http\Request;
use App\Models\JobPost;
use App\Models\Application;

use Illuminate\Support\Facades\Auth;
class CandidateController extends Controller
{
    // Dashboard
    public function dashboard()
    {
        $candidate = Candidate::first(); // بدل Auth

        $applications = $candidate->applications()
            ->with('job')
            ->latest()
            ->get();

        return view('candidate.dashboard', compact('candidate', 'applications'));
    }

    // Show Edit Profile Page
    public function editProfile()
    {
        $candidate = Candidate::first(); // بدل Auth
        return view('candidate.edit-profile', compact('candidate'));
    }

    // Update Profile
    public function updateProfile(Request $request)
    {
        $candidate = Candidate::first(); // بدل Auth

        $request->validate([
            'phone' => 'nullable|string|max:50',
            'address' => 'nullable|string|max:255',
            'resume' => 'nullable|mimes:pdf|max:2048',
        ]);

        if ($request->hasFile('resume')) {
            $path = $request->file('resume')->store('resumes', 'public');
            $candidate->resume = $path;
        }

        $candidate->phone = $request->phone;
        $candidate->address = $request->address;
        $candidate->save();

        return back()->with('success', 'Profile updated.');
    }

    // Candidate Applications Page
    public function applications()
    {
        $candidate = Candidate::first(); // بدل Auth

        $applications = $candidate->applications()
            ->with('job')
            ->latest()
            ->get();

        return view('candidate.applications', compact('applications'));
    }


    // Show apply form
    public function showApplyForm(JobPost $job)
    {
        $candidate = Candidate::first(); // بدل Auth
        return view('candidate.apply', compact('job', 'candidate'));
    }

    // Submit application
    public function submitApplication(Request $request, JobPost $job)
    {
        $candidate = Candidate::first(); // بدل Auth

        $request->validate([
            'resume' => 'nullable|mimes:pdf|max:2048',
        ]);

        $resumePath = $candidate->resume; // default resume
        if ($request->hasFile('resume')) {
            $resumePath = $request->file('resume')->store('resumes', 'public');
        }

        Application::create([
            'candidate_id' => $candidate->id,
            'job_id' => $job->id,
            'resume' => $resumePath,
            'status' => 'pending',
        ]);

        return redirect()->route('candidate.applications')->with('success', 'Application submitted successfully.');
    }
}
