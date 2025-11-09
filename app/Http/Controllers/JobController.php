<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Http\Request;

class JobController extends Controller
{
    public function index(Request $request)
    {
        $query = Job::query()->where('status', 'approved'); // يفترض اسلام عامل status

        if ($request->keyword) {
            $query->where('title', 'like', '%' . $request->keyword . '%');
        }

        if ($request->location) {
            $query->where('location', $request->location);
        }

        if ($request->work_type) {
            $query->where('work_type', $request->work_type);
        }

        $jobs = $query->latest()->paginate(10);

        return view('jobs.index', compact('jobs'));
    }

    public function show(Job $job)
    {
        return view('jobs.show', compact('job'));
    }
}
