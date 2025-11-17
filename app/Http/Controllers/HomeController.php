<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreJobPostRequest;
use App\Http\Requests\UpdateJobPostRequest;
use App\Models\Category;
use App\Models\JobPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    public function index()
    {
        return view('pages.index', [
            'categories' => Category::latest()->take(8)->get(),
            'trendJobs' => JobPost::withCount('applications')
            ->orderBy('applications_count', 'DESC')
            ->take(6)
            ->get()
        ]);
    }

    public function about()
    {
        return view('pages.about');
    }

    public function contact()
    {
        return view('pages.contact');
    }

    public function jobs(Request $request)
    {
        // Always return only published jobs
    $query = JobPost::where('status', 'published');

    // Keywords
    if ($request->filled('keywords')) {
        $query->where(function ($q) use ($request) {
            $q->where('title', 'like', '%' . $request->keywords . '%')
              ->orWhere('description', 'like', '%' . $request->keywords . '%');
        });
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

    // Only published jobs will be returned from the query
    $jobPosts = $query->paginate(10);

    // Side stats
    $categories = Category::all();

    $allCount = JobPost::withTrashed()->count();
    $publishedCount = JobPost::where('status', 'published')->count();
    $draftCount = JobPost::where('status', 'draft')->count();
    $closedCount = JobPost::withTrashed()->where('status', 'closed')->count();

    return view('pages.jobs', compact(
        'jobPosts',
        'categories',
        'allCount',
        'publishedCount',
        'draftCount',
        'closedCount'
    ));
    }

    public function show(JobPost $job)
    {
        $job->load([
            'comments' => fn($q) => $q->whereNull('parent_id')->latest(),
            'comments.user',
            'comments.replies.user',
        ]);

        return view('pages.show', compact('job'));
    }
}
