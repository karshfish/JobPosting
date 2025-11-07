<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class CandidateController extends Controller
{
    public function dashboard()
    {
        $candidate = auth::user()->candidate;

        $applications = $candidate->applications()
            ->with('job')
            ->latest()
            ->get();

        return view('candidate.dashboard', compact('candidate', 'applications'));
    }

    public function editProfile()
    {
        $candidate = auth::user()->candidate;
        return view('candidate.edit-profile', compact('candidate'));
    }

    public function updateProfile(Request $request)
    {
        $candidate = auth::user()->candidate;

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
}
