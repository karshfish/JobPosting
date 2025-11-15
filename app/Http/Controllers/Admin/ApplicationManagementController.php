<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Application;
use Illuminate\Http\Request;

class ApplicationManagementController extends Controller
{
    public function index(Request $request)
    {
        $query = Application::with(['user', 'job']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $query->whereHas('job', function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%');
            });
        }

        $applications = $query->latest()->paginate(10);

        $statusCounts = [
            'pending' => Application::where('status', 'pending')->count(),
            'accepted' => Application::where('status', 'accepted')->count(),
            'rejected' => Application::where('status', 'rejected')->count(),
        ];

        return view('admin.applications.index', compact('applications', 'statusCounts'));
    }

    public function show(Application $application)
    {
        $application->load(['user', 'job']);

        return view('admin.applications.show', compact('application'));
    }
}

