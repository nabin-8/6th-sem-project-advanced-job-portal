<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Job;

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
                        //   ->where('is_featured', true)
                          ->latest()
                          ->take(6)
                          ->get();
        
        // Get recent jobs for the homepage
        $recentJobs = Job::where('status', 'open')
                        ->latest()
                        ->take(8)
                        ->get();
                        
        return view('home', [
            'featuredJobs' => $featuredJobs,
            'recentJobs' => $recentJobs,
            'totalJobs' => Job::where('status', 'open')->count(),
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
