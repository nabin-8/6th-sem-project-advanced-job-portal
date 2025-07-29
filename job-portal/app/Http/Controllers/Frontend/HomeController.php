<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Job;
use App\Models\Faq;

class HomeController extends Controller
{
    /**
     * Show the home page.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Get featured jobs for the homepage
        $featuredJobs = Job::where('status', 'open')
                        ->where('is_featured', true)
                        ->with(['organization', 'category'])
                        ->latest()
                        ->take(4)
                        ->get();
        
        // Get recent jobs for the homepage
        $recentJobs = Job::where('status', 'open')
                        ->with(['organization', 'category'])
                        ->latest()
                        ->take(6)
                        ->get();
                        
        // Get job categories with counts
        $categories = \App\Models\JobCategory::withCount('jobs')
                        ->orderBy('jobs_count', 'desc')
                        ->take(6)
                        ->get();
                        
        // Get employment type counts
        $employmentTypes = [
            'full_time' => Job::where('status', 'open')->where('employment_type', 'full_time')->count(),
            'part_time' => Job::where('status', 'open')->where('employment_type', 'part_time')->count(),
            'contract' => Job::where('status', 'open')->where('employment_type', 'contract')->count(),
            'internship' => Job::where('status', 'open')->where('employment_type', 'internship')->count(),
        ];
                        
        // Get published FAQs for the footer
        $faqs = Faq::where('is_published', true)
                ->orderBy('order')
                ->take(6)
                ->get();
        // dd($faqs, $featuredJobs, $recentJobs, $categories);
                        
        return view('home', [
            'featuredJobs' => $featuredJobs,
            'recentJobs' => $recentJobs,
            'categories' => $categories,
            'employmentTypes' => $employmentTypes,
            'totalJobs' => Job::where('status', 'open')->count(),
            'faqs' => $faqs,
        ]);
    }
    
    /**
     * Show the about page.
     *
     * @return \Illuminate\View\View
     */
    public function about()
    {
        return view('about');
    }
}
