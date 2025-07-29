<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Job;
use App\Models\JobApplication;
use App\Models\OrganizationProfile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class JobsController extends Controller
{
    /**
     * Display a listing of jobs with search and filters.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $query = Job::where('status', 'open');
        
        // Apply search filters
        if ($request->has('keyword') && $request->keyword) {
            $keyword = $request->keyword;
            $query->where(function($q) use ($keyword) {
                $q->where('title', 'like', "%{$keyword}%")
                  ->orWhere('description', 'like', "%{$keyword}%")
                  ->orWhere('requirements', 'like', "%{$keyword}%");
            });
        }
        
        if ($request->has('location') && $request->location) {
            $query->where('location', 'like', "%{$request->location}%");
        }
        
        if ($request->has('employment_type') && $request->employment_type) {
            $query->where('employment_type', $request->employment_type);
        }
        
        if ($request->has('category_id') && $request->category_id) {
            $query->where('category_id', $request->category_id);
        }
        
        if ($request->has('salary_min') && $request->salary_min) {
            $query->where('salary_min', '>=', $request->salary_min);
        }
        
        if ($request->has('salary_max') && $request->salary_max) {
            $query->where('salary_max', '<=', $request->salary_max);
        }
        
        // Apply sorting if requested
        if ($request->has('sort')) {
            if ($request->sort === 'oldest') {
                $query->oldest();
            } else {
                $query->latest(); // Default to newest first
            }
        } else {
            $query->latest(); // Default sorting
        }
        
        $jobs = $query->with(['organization', 'category'])
                      ->paginate(10)
                      ->withQueryString(); // Use withQueryString to preserve pagination
                      
        $employmentTypes = ['full_time', 'part_time', 'contract', 'internship', 'remote'];
        
        // Create a clean array of filters for the view
        $filters = [
            'keyword' => $request->input('keyword', ''),
            'location' => $request->input('location', ''),
            'employment_type' => $request->input('employment_type', ''),
            'category_id' => $request->input('category_id', ''),
            'salary_min' => $request->input('salary_min', ''),
            'salary_max' => $request->input('salary_max', ''),
            'sort' => $request->input('sort', 'newest')
        ];
        
        // Get job categories for filtering
        $categories = \App\Models\JobCategory::orderBy('name')->get();
        
        return view('jobs.index', [
            'jobs' => $jobs,
            'employmentTypes' => $employmentTypes,
            'filters' => $filters,
            'categories' => $categories,
        ]);
    }
    
    /**
     * Display the specified job.
     *
     * @param  \App\Models\Job  $job
     * @return \Illuminate\View\View
     */
    public function show(Job $job)
    {
        // Check if the authenticated user has already applied for this job
        $hasApplied = false;
        if (Auth::check() && Auth::user()->hasRole('Candidate')) {
            $hasApplied = JobApplication::where('job_id', $job->id)
                           ->where('candidate_id', Auth::user()->candidateProfile->id)
                           ->exists();
        }
        
        // Get related jobs from the same organization
        $relatedJobs = Job::where('status', 'open')
                        ->where('id', '!=', $job->id)
                        ->where('organization_id', $job->organization_id)
                        ->latest()
                        ->take(3)
                        ->get();
        // dd($job, $hasApplied, $relatedJobs);
        
        return view('jobs.show', [
            'job' => $job,
            'hasApplied' => $hasApplied,
            'relatedJobs' => $relatedJobs,
        ]);
    }
    
    /**
     * Display a listing of jobs for organization management.
     *
     * @return \Illuminate\View\View
     */
    public function manage()
    {
        $organizationId = Auth::user()->organizationProfile->id;
        $jobs = Job::where('organization_id', $organizationId)
                  ->withCount('applications')
                  ->latest()
                  ->paginate(10);
   
        return view('organization.jobs.manage', [
            'jobs' => $jobs,
        ]);
    }
    
    /**
     * Show the form for creating a new job.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        // Check if organization profile is complete
        $organizationProfile = Auth::user()->organizationProfile;
        if (!$organizationProfile->is_complete) {
            return redirect()->route('profile.edit')
                             ->with('error', 'Please complete your organization profile before posting jobs.');
        }
        
        $employmentTypes = ['full-time', 'part-time', 'contract', 'internship', 'remote'];
        $categories = \App\Models\JobCategory::orderBy('name')->get();
        
        return view('organization.jobs.create', [
            'employmentTypes' => $employmentTypes,
            'categories' => $categories,
        ]);
    }
    
    /**
     * Store a newly created job in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'employment_type' => 'required|string|in:full-time,part-time,contract,internship,remote',
            'description' => 'required|string',
            'requirements' => 'required|string',
            'salary_min' => 'nullable|numeric|min:0',
            'salary_max' => 'nullable|numeric|min:0|gte:salary_min',
            'application_deadline' => 'required|date|after:today',
            'category_id' => 'required|exists:job_categories,id',
        ]);
        
        $job = new Job();
        $job->title = $request->title;
        $job->location = $request->location;
        $job->employment_type = $request->employment_type;
        $job->description = $request->description;
        $job->requirements = $request->requirements;
        $job->salary_min = $request->salary_min;
        $job->salary_max = $request->salary_max;
        $job->application_deadline = $request->application_deadline;
        $job->is_featured = false;
        $job->status = 'open';
        $job->organization_id = Auth::user()->organizationProfile->id;
        $job->category_id = $request->category_id;
        $job->save();
        
        return redirect()->route('jobs.manage')
                         ->with('success', 'Job posted successfully!');
    }
    
    /**
     * Show the form for editing the specified job.
     *
     * @param  \App\Models\Job  $job
     * @return \Illuminate\View\View
     */
    public function edit(Job $job)
    {
        // Authorization check
        $organizationId = Auth::user()->organizationProfile->id;
        if ($job->organization_id != $organizationId) {
            return redirect()->route('jobs.manage')
                             ->with('error', 'You are not authorized to edit this job.');
        }
        
        $employmentTypes = ['full-time', 'part-time', 'contract', 'internship', 'remote'];
        $categories = \App\Models\JobCategory::orderBy('name')->get();
        
        return view('organization.jobs.edit', [
            'job' => $job,
            'employmentTypes' => $employmentTypes,
            'categories' => $categories,
        ]);
    }
    
    /**
     * Update the specified job in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Job  $job
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Job $job)
    {
        // Authorization check
        $organizationId = Auth::user()->organizationProfile->id;
        if ($job->organization_id != $organizationId) {
            return redirect()->route('jobs.manage')
                             ->with('error', 'You are not authorized to update this job.');
        }
        
        $request->validate([
            'title' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'employment_type' => 'required|string|in:full-time,part-time,contract,internship,remote',
            'description' => 'required|string',
            'requirements' => 'required|string',
            'salary_min' => 'nullable|numeric|min:0',
            'salary_max' => 'nullable|numeric|min:0|gte:salary_min',
            'application_deadline' => 'required|date',
            'category_id' => 'required|exists:job_categories,id',
        ]);
        
        $job->title = $request->title;
        $job->location = $request->location;
        $job->employment_type = $request->employment_type;
        $job->description = $request->description;
        $job->requirements = $request->requirements;
        $job->salary_min = $request->salary_min;
        $job->salary_max = $request->salary_max;
        $job->application_deadline = $request->application_deadline;
        $job->category_id = $request->category_id;
        $job->save();
        
        return redirect()->route('jobs.manage')
                         ->with('success', 'Job updated successfully!');
    }
    
    /**
     * Remove the specified job from storage.
     *
     * @param  \App\Models\Job  $job
     * @return \Illuminate\Http\Response
     */
    public function destroy(Job $job)
    {
        // Authorization check
        $organizationId = Auth::user()->organizationProfile->id;
        if ($job->organization_id != $organizationId) {
            return redirect()->route('jobs.manage')
                             ->with('error', 'You are not authorized to delete this job.');
        }
        
        // Check if there are applications
        $applicationsCount = JobApplication::where('job_id', $job->id)->count();
        if ($applicationsCount > 0) {
            return redirect()->route('jobs.manage')
                             ->with('error', 'Cannot delete job with active applications. Please close the job instead.');
        }
        
        $job->delete();
        
        return redirect()->route('jobs.manage')
                         ->with('success', 'Job deleted successfully!');
    }
    
    /**
     * Toggle job status (open/closed).
     *
     * @param  \App\Models\Job  $job
     * @return \Illuminate\Http\Response
     */
    public function toggleStatus(Job $job)
    {
        // Authorization check
        $organizationId = Auth::user()->organizationProfile->id;
        if ($job->organization_id != $organizationId) {
            return redirect()->route('jobs.manage')
                             ->with('error', 'You are not authorized to update this job.');
        }
        
        $job->status = $job->status === 'open' ? 'closed' : 'open';
        $job->save();
        
        $statusMessage = $job->status === 'open' ? 'reopened' : 'closed';
        
        return redirect()->route('jobs.manage')
                         ->with('success', "Job {$statusMessage} successfully.");
    }
}
