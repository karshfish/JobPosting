<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class ApplicationController extends Controller
{
    public function store(Request $request, Job $job)
    {
        $candidate = auth::user()->candidate;

        // منع التكرار
        if ($job->applications()->where('candidate_id', $candidate->id)->exists()) {
            return back()->with('error', 'You have already applied to this job.');
        }

        $path = $candidate->resume; // الافتراضي السيرة الموجودة

        // لو المرشح حب يرفع CV جديد أثناء التقديم
        if ($request->hasFile('resume')) {
            $request->validate([
                'resume' => 'mimes:pdf|max:2048',
            ]);
            $path = $request->file('resume')->store('resumes', 'public');
        }

        Application::create([
            'candidate_id' => $candidate->id,
            'job_id' => $job->id,
            'resume' => $path,
        ]);

        return redirect()->route('candidate.dashboard')->with('success', 'Application submitted successfully.');
    }
}
