<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CandidateProfile;
use App\Models\Job;
use App\Models\JobApplication;
use App\Models\OrganizationProfile;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Display the admin dashboard.
     */
    public function dashboard()
    {
        // Get counts for the dashboard
        $stats = [
            'users_count' => User::count(),
            'candidates_count' => CandidateProfile::count(),
            'organizations_count' => OrganizationProfile::count(),
            'jobs_count' => Job::count(),
            'open_jobs_count' => Job::where('status', 'open')->count(),
            'applications_count' => JobApplication::count(),
            'pending_applications_count' => JobApplication::where('status', 'pending')->count(),
        ];
        
        // Get recent data for quick overview
        $recent = [
            'users' => User::latest()->take(5)->get(),
            'jobs' => Job::with('organization')->latest()->take(5)->get(),
            'applications' => JobApplication::with(['job', 'candidate.user'])->latest()->take(5)->get(),
        ];

        // dd($stats, $recent);
        
        return view('admin.dashboard', compact('stats', 'recent'));
    }
}