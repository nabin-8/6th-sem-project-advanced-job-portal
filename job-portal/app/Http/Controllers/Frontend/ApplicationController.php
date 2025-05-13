<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Job;
use App\Models\JobApplication;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ApplicationController extends Controller
{
    /**
     * Display a listing of the candidate's applications.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Get the authenticated candidate's applications
        $candidateId = Auth::user()->candidateProfile->id;
        $applications = JobApplication::with(['job.organization'])
            ->where('candidate_id', $candidateId)
            ->latest()
            ->paginate(10);
            
        return view('candidate.applications.index', [
            'applications' => $applications
        ]);
    }

    /**
     * Display the specified application.
     *
     * @param  \App\Models\JobApplication  $application
     * @return \Illuminate\View\View
     */
    public function show(JobApplication $application)
    {
        // Ensure the authenticated user owns this application
        $candidateId = Auth::user()->candidateProfile->id;
        
        if ($application->candidate_id != $candidateId) {
            return redirect()->route('applications.index')
                ->with('error', 'You are not authorized to view this application.');
        }
        
        return view('candidate.applications.show', [
            'application' => $application
        ]);
    }

    /**
     * Apply for a job.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Job  $job
     * @return \Illuminate\Http\RedirectResponse
     */
    public function apply(Request $request, Job $job)
    {
        // Check if the job is open
        if ($job->status !== 'open') {
            return redirect()->route('jobs.show', $job->id)
                ->with('error', 'This job is no longer accepting applications.');
        }

        // Check if application deadline has passed
        if ($job->application_deadline->isPast()) {
            return redirect()->route('jobs.show', $job->id)
                ->with('error', 'The application deadline for this job has passed.');
        }
        
        // Get the authenticated user's candidate profile
        $candidateId = Auth::user()->candidateProfile->id;
        
        // Check if the candidate has already applied to this job
        $existingApplication = JobApplication::where('job_id', $job->id)
            ->where('candidate_id', $candidateId)
            ->exists();
            
        if ($existingApplication) {
            return redirect()->route('jobs.show', $job->id)
                ->with('error', 'You have already applied for this job.');
        }
        
        // Check if candidate profile is complete
        if (!Auth::user()->candidateProfile->is_complete) {
            return redirect()->route('profile.edit')
                ->with('error', 'Please complete your profile before applying for jobs.');
        }
        
        // Create a new job application
        $application = new JobApplication();
        $application->job_id = $job->id;
        $application->candidate_id = $candidateId;
        $application->status = 'pending';
        $application->cover_letter = $request->cover_letter ?? null;
        $application->save();
        
        return redirect()->route('applications.show', $application->id)
            ->with('success', 'Your application has been submitted successfully!');
    }

    /**
     * Withdraw an application.
     *
     * @param  \App\Models\JobApplication  $application
     * @return \Illuminate\Http\RedirectResponse
     */
    public function withdraw(JobApplication $application)
    {
        // Ensure the authenticated user owns this application
        $candidateId = Auth::user()->candidateProfile->id;
        
        if ($application->candidate_id != $candidateId) {
            return redirect()->route('applications.index')
                ->with('error', 'You are not authorized to withdraw this application.');
        }
        
        // Check if the application can be withdrawn
        if (in_array($application->status, ['offered', 'rejected'])) {
            return redirect()->route('applications.show', $application->id)
                ->with('error', 'You cannot withdraw an application that has been ' . $application->status . '.');
        }
        
        // Update the application status
        $application->status = 'withdrawn';
        $application->save();
        
        return redirect()->route('applications.index')
            ->with('success', 'Your application has been withdrawn successfully.');
    }
    
    /**
     * Display a listing of applications for a specific job (for organization).
     *
     * @param  \App\Models\Job  $job
     * @return \Illuminate\View\View
     */
    public function jobApplications(Job $job)
    {
        // Ensure the authenticated user owns this job
        $organizationId = Auth::user()->organizationProfile->id;
        
        if ($job->organization_id != $organizationId) {
            return redirect()->route('jobs.manage')
                ->with('error', 'You are not authorized to view applications for this job.');
        }
        
        $applications = JobApplication::with('candidate.user')
            ->where('job_id', $job->id)
            ->latest()
            ->paginate(10);
            
        return view('organization.applications.index', [
            'job' => $job,
            'applications' => $applications
        ]);
    }
    
    /**
     * Display the specified application (for organization).
     *
     * @param  \App\Models\Job  $job
     * @param  \App\Models\JobApplication  $application
     * @return \Illuminate\View\View
     */
    public function showJobApplication(Job $job, JobApplication $application)
    {
        // Ensure the authenticated user owns this job
        $organizationId = Auth::user()->organizationProfile->id;
        
        if ($job->organization_id != $organizationId) {
            return redirect()->route('jobs.manage')
                ->with('error', 'You are not authorized to view applications for this job.');
        }
        
        // Ensure the application belongs to the job
        if ($application->job_id != $job->id) {
            return redirect()->route('jobs.applications', $job->id)
                ->with('error', 'The application does not belong to this job.');
        }
        
        return view('organization.applications.show', [
            'job' => $job,
            'application' => $application
        ]);
    }
    
    /**
     * Update application status (for organization).
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Job  $job
     * @param  \App\Models\JobApplication  $application
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateStatus(Request $request, Job $job, JobApplication $application)
    {
        // Ensure the authenticated user owns this job
        $organizationId = Auth::user()->organizationProfile->id;
        
        if ($job->organization_id != $organizationId) {
            return redirect()->route('jobs.manage')
                ->with('error', 'You are not authorized to update applications for this job.');
        }
        
        // Ensure the application belongs to the job
        if ($application->job_id != $job->id) {
            return redirect()->route('jobs.applications', $job->id)
                ->with('error', 'The application does not belong to this job.');
        }
        
        $request->validate([
            'status' => 'required|in:pending,reviewing,interview,offered,rejected'
        ]);
        
        $application->status = $request->status;
        $application->save();
        
        return redirect()->route('jobs.applications.show', [$job->id, $application->id])
            ->with('success', 'Application status updated successfully.');
    }
}
