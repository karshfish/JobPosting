<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;

use App\Models\JobPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JobListingController extends Controller
{
    /**
     * Display a listing of the resource.
     */

public function index(Request $request)
{
    $userId = Auth::id();

    // Base query for this employer's jobs
    $query = JobPost::where('user_id', $userId);

    // Apply filters
    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }

    if ($request->filled('search')) {
        $query->where('title', 'like', '%' . $request->search . '%');
    }

    if ($request->filled('from') && $request->filled('to')) {
        $query->whereBetween('created_at', [
            $request->from . ' 00:00:00',
            $request->to . ' 23:59:59'
        ]);
    }
    if ($request->filled('period')) {
        switch ($request->period) {
            case 'today':
                $query->whereDate('created_at', now());
                break;
            case 'this_week':
                $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
                break;
            case 'this_month':
                $query->whereMonth('created_at', now()->month);
                break;
        }
    }

    // Count summary (not filtered)
    $totalJobs = JobPost::where('user_id', $userId)->count();
    $publishedJobs = JobPost::where('user_id', $userId)->where('status', 'published')->count();
    $draftJobs = JobPost::where('user_id', $userId)->where('status', 'draft')->count();
    $closedJobs = JobPost::where('user_id', $userId)->where('status', 'closed')->count();

    // Latest jobs (filtered)
    $latestJobs = $query->latest()->paginate(5);

    return view('employer.jobListings', compact(
        'totalJobs',
        'publishedJobs',
        'draftJobs',
        'closedJobs',
        'latestJobs'
    ));
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
