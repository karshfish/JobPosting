<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreJobPostRequest;
use App\Http\Requests\UpdateJobPostRequest;
use App\Models\Category;
use App\Models\JobPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class JobPostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
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

    $allCount = JobPost::count();
    $publishedCount = JobPost::where('status', 'published')->count();
    $draftCount = JobPost::where('status', 'draft')->count();
    $closedCount = JobPost::where('status', 'closed')->count();

    return view('employer.jobs.index', compact(
        'jobPosts',
        'categories',
        'allCount',
        'publishedCount',
        'draftCount',
        'closedCount'
    ));
}




    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('employer.jobs.create', compact('categories'));
    }

    //image functionality to be added later

    private function handleBrandingImage($request, $oldImage = null)
    {
        if ($request->hasFile('branding_image')) {
            if ($oldImage && file_exists(storage_path('app/public/' . $oldImage))) {
                unlink(storage_path('app/public/' . $oldImage));
            }

            $image = $request->file('branding_image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();

            // storage/app/public/branding_image
            $image->storeAs('branding_image', $imageName, 'public');

            return 'branding_image/' . $imageName;
        }

        return $oldImage;
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreJobPostRequest $request)
    {
        // Validate and create the job post
        $data = $request->validated();
        $data['user_id'] = Auth::id();

        $data['branding_image'] = $this->handleBrandingImage($request);

        // dd($data);

        JobPost::create($data);

        return redirect()->route('jobs.index')
            ->with('success', 'Job created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(JobPost $job)
    {
        $job->load([
            'comments' => fn($q) => $q->whereNull('parent_id')->latest(),
            'comments.user',
            'comments.replies.user',
        ]);

        return view('employer.jobs.show', compact('job'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(JobPost $job)
    {
        $categories = Category::all();
        return view('employer.jobs.edit', compact('job', 'categories'));
    }

    public function update(UpdateJobPostRequest $request, JobPost $job)
    {
        $data = $request->validated();

        // ensure arrays for JSON columns (model casts handle storing)
        $data['skills'] = $request->input('skills', []);
        $data['qualifications'] = $request->input('qualifications', []);
        $data['technologies'] = $request->input('technologies', []);
        $data['benefits'] = $request->input('benefits', []);

        // handle salary fields if present
        if ($request->filled('salary_min')) {
            $data['salary_min'] = $request->input('salary_min');
        }
        if ($request->filled('salary_max')) {
            $data['salary_max'] = $request->input('salary_max');
        }

        // Branding image upload (public disk)
        if ($request->hasFile('branding_image')) {
            // delete old file if exists
            if ($job->branding_image && Storage::disk('public')->exists($job->branding_image)) {
                Storage::disk('public')->delete($job->branding_image);
            }

            $path = $request->file('branding_image')->store('branding', 'public');
            $data['branding_image'] = $path;
        }

        $job->update($data);

        return redirect()
            ->route('jobs.index')
            ->with('success', 'Job updated successfully.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(JobPost $job)
    {

        if ($job->branding_image && file_exists(storage_path('app/public/storage/' . $job->branding_image))) {
            unlink(storage_path('app/public/' . $job->branding_image));
        }

        $job->delete();
        return redirect()->route('jobs.index')
            ->with('success', 'Job deleted successfully!');
    }
}
