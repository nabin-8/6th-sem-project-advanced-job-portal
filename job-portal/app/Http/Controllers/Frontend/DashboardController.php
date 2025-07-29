<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Job;
use App\Models\JobApplication;
use App\Models\CandidateProfile;
use App\Models\OrganizationProfile;

class DashboardController extends Controller
{
    /**
     * Main dashboard route that redirects to appropriate role-specific dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $activeRole = session('active_role');

        if ($activeRole === 'Candidate' && $user->hasRole('Candidate')) {
            return redirect()->route('candidate.dashboard');
        } elseif ($activeRole === 'Organization' && $user->hasRole('Organization')) {
            return redirect()->route('organization.dashboard');
        } elseif ($user->hasRole('Candidate')) {
            session(['active_role' => 'Candidate']);
            return redirect()->route('candidate.dashboard');
        } elseif ($user->hasRole('Organization')) {
            session(['active_role' => 'Organization']);
            return redirect()->route('organization.dashboard');
        } else {
            // Fallback in case user has no defined roles
            return redirect()->route('home');
        }
    }

    /**
     * Display the candidate dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function candidateDashboard()
    {
        $user = Auth::user();
        $candidateProfile = $user->candidateProfile;
        
        // Calculate profile completion percentage
        $profileCompletionPercentage = $this->calculateCandidateProfileCompletion($candidateProfile);
        
        // Get job applications stats
        $totalApplications = JobApplication::where('candidate_id', $candidateProfile->id)->count();
        $pendingApplications = JobApplication::where('candidate_id', $candidateProfile->id)
            ->where('status', 'pending')
            ->count();
        $interviewApplications = JobApplication::where('candidate_id', $candidateProfile->id)
            ->where('status', 'interview')
            ->count();
        
        // Get recent applications
        $recentApplications = JobApplication::with('job.organization')
            ->where('candidate_id', $candidateProfile->id)
            ->latest()
            ->take(5)
            ->get();
        
        // Get recommended jobs based on candidate skills
        $recommendedJobs = $this->getRecommendedJobs($candidateProfile);
        
        return view('candidate.dashboard', [
            'user' => $user,
            'candidateProfile' => $candidateProfile,
            'profileCompletionPercentage' => $profileCompletionPercentage,
            'totalApplications' => $totalApplications,
            'pendingApplications' => $pendingApplications,
            'interviewApplications' => $interviewApplications,
            'recentApplications' => $recentApplications,
            'recommendedJobs' => $recommendedJobs,
        ]);
    }

    /**
     * Display the organization dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function organizationDashboard()
    {
        $user = Auth::user();
        // dd($user);
        $organizationProfile = $user->organizationProfile;
        
        // Calculate profile completion percentage
        $profileCompletionPercentage = $this->calculateOrganizationProfileCompletion($organizationProfile);
        
        // Get job posting stats
        $totalJobs = Job::where('organization_id', $organizationProfile->id)->count();
        $activeJobs = Job::where('organization_id', $organizationProfile->id)
            ->where('status', 'open')
            ->count();
        $totalApplications = JobApplication::whereHas('job', function($query) use ($organizationProfile) {
            $query->where('organization_id', $organizationProfile->id);
        })->count();
        
        // Get recent job applications
        $recentApplications = JobApplication::with(['candidate.user', 'job'])
            ->whereHas('job', function($query) use ($organizationProfile) {
                $query->where('organization_id', $organizationProfile->id);
            })
            ->latest()
            ->take(5)
            ->get();
        
        // Get recent jobs posted with applications count
        $recentJobs = Job::where('organization_id', $organizationProfile->id)
            ->withCount('applications')
            ->latest()
            ->take(5)
            ->get();
        
        return view('organization.dashboard', [
            'user' => $user,
            'organizationProfile' => $organizationProfile,
            'profileCompletionPercentage' => $profileCompletionPercentage,
            'totalJobs' => $totalJobs,
            'activeJobs' => $activeJobs,
            'totalApplications' => $totalApplications,
            'recentApplications' => $recentApplications,
            'recentJobs' => $recentJobs,
        ]);
    }

    /**
     * Calculate the completion percentage for a candidate profile.
     *
     * @param  \App\Models\CandidateProfile  $profile
     * @return int
     */
    private function calculateCandidateProfileCompletion(CandidateProfile $profile)
    {
        $fields = CandidateProfile::getRequiredFields();
        
        $filledFields = 0;
        
        foreach ($fields as $field) {
            // For location field, check address column which is the actual db column
            if ($field === 'location' && !empty($profile->address)) {
                $filledFields++;
            }
            // For resume, check either resume or resume_path
            elseif ($field === 'resume' && (!empty($profile->resume) || !empty($profile->resume_path))) {
                $filledFields++;
            }
            elseif (!empty($profile->$field)) {
                $filledFields++;
            }
        }
        
        // Set is_complete flag based on percentage
        $percentage = intval(($filledFields / count($fields)) * 100);
        if ($percentage >= 80 && $profile->is_complete == false) {
            $profile->is_complete = true;
            $profile->save();
        }
        
        return $percentage;
    }

    /**
     * Calculate the completion percentage for an organization profile.
     *
     * @param  \App\Models\OrganizationProfile  $profile
     * @return int
     */
    private function calculateOrganizationProfileCompletion(OrganizationProfile $profile)
    {
        $fields = OrganizationProfile::getRequiredFields();
        
        $filledFields = 0;
        
        foreach ($fields as $field) {
            if (!empty($profile->$field)) {
                $filledFields++;
            }
        }
        
        // Set is_complete flag based on percentage
        $percentage = intval(($filledFields / count($fields)) * 100);
        if ($percentage >= 80 && $profile->is_complete == false) {
            $profile->is_complete = true;
            $profile->save();
        }
        
        return $percentage;
    }

    /**
     * Get recommended jobs for a candidate based on their skills.
     *
     * @param  \App\Models\CandidateProfile  $candidateProfile
     * @return \Illuminate\Database\Eloquent\Collection
     */
    private function getRecommendedJobs(CandidateProfile $candidateProfile)
    {
        // First check if profile is complete - only recommend jobs for complete profiles
        if (!$candidateProfile->is_complete) {
            return collect([]); // Return empty collection if profile is not complete
        }
        
        // Base query for open jobs
        $jobsQuery = Job::where('status', 'open');
        
        // Handle skills parsing from different formats
        $skills = [];
        if (!empty($candidateProfile->skills)) {
            // Try to decode as JSON first (some records may store skills as JSON)
            $jsonSkills = json_decode($candidateProfile->skills);
            if (json_last_error() === JSON_ERROR_NONE && is_array($jsonSkills)) {
                $skills = $jsonSkills;
            } else {
                // Fall back to comma-separated string
                $skills = explode(',', $candidateProfile->skills);
            }
        }
        
        // If candidate has skills, match them with job requirements
        if (count($skills) > 0) {
            $jobsQuery->where(function($query) use ($skills) {
                foreach ($skills as $skill) {
                    $skill = trim($skill);
                    if (!empty($skill)) {
                        $query->orWhere('title', 'like', "%{$skill}%")
                              ->orWhere('description', 'like', "%{$skill}%")
                              ->orWhere('requirements', 'like', "%{$skill}%");
                    }
                }
            });
        }
        
        // Exclude jobs that the candidate has already applied to (regardless of status)
        $appliedJobIds = JobApplication::where('candidate_id', $candidateProfile->id)
            ->pluck('job_id')
            ->toArray();
            
        if (!empty($appliedJobIds)) {
            $jobsQuery->whereNotIn('id', $appliedJobIds);
        }
        
        return $jobsQuery->latest()->take(2)->get();
    }
}
