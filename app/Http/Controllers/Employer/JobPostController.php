<?php

namespace App\Http\Controllers\Employer;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreJobPostRequest;
use App\Http\Requests\UpdateJobPostRequest;
use App\Models\JobPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JobPostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jobPosts = JobPost::with('user')->latest()->get();
        return view('employer.jobs.index', compact('jobPosts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('employer.jobs.create');
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
    return view('employer.jobs.show', compact('job'));
}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(JobPost $job)
{
    return view('employer.jobs.edit', compact('job'));
}

public function update(UpdateJobPostRequest $request, JobPost $jobPost)
{
    $data = $request->validated();
    $data['user_id'] = Auth::id();

    // ✅ حفظ الصورة (مع الاحتفاظ القديمة إن لم تُرفع جديدة)
    $data['branding_image'] = $this->handleBrandingImage($request, $jobPost->branding_image);

    $jobPost->update($data);

    return redirect()
        ->route('jobs.index')
        ->with('success', 'Job post updated successfully.');
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(JobPost $job)
    {
        $job->delete();

        return redirect()->route('jobs.index')
            ->with('success', 'Job deleted successfully!');
    }
}
