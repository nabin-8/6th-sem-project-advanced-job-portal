<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JobApplication;
use Illuminate\Http\Request;

class JobApplicationController extends Controller
{
    /**
     * Display a listing of applications.
     */
    public function index()
    {
        $applications = JobApplication::with(['job', 'candidate.user', 'job.organization'])
            ->latest()
            ->paginate(10);
        
        return view('admin.applications.index', compact('applications'));
    }

    /**
     * Display the specified application.
     */
    public function show(JobApplication $application)
    {
        $application->load(['job', 'candidate.user', 'job.organization']);
        
        return view('admin.applications.show', compact('application'));
    }

    /**
     * Update the status of the specified application.
     */
    public function updateStatus(Request $request, JobApplication $application)
    {
        $request->validate([
            'status' => 'required|in:pending,reviewed,rejected',
        ]);

        $application->update([
            'status' => $request->status,
        ]);

        return redirect()->route('applications.show', $application)
            ->with('success', 'Application status updated successfully.');
    }

    /**
     * Remove the specified application from storage.
     */
    public function destroy(JobApplication $application)
    {
        $application->delete();

        return redirect()->route('applications.index')
            ->with('success', 'Application deleted successfully.');
    }
    
}