<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Job;
use App\Models\JobCategory;
use App\Models\OrganizationProfile;
use App\Models\Faq;
use Illuminate\Support\Facades\DB;

class PublicController extends Controller
{
    public function home()
    {
        $featuredJobs = Job::with('organization', 'category')
            ->where('is_featured', true)
            ->where('status', 'open')
            ->latest()
            ->take(4)
            ->get();
            
        $categories = JobCategory::withCount('jobs')
            ->orderByDesc('jobs_count')
            ->take(8)
            ->get();
            
        $organizations = OrganizationProfile::withCount(['jobs' => function($query) {
                $query->where('status', 'open');
            }])
            ->orderByDesc('jobs_count')
            ->take(4)
            ->get();
            
        $faqs = Faq::where('is_published', true)
            ->orderBy('order')
            ->take(6)
            ->get();
        
        return view('public.home', compact('featuredJobs', 'categories', 'organizations', 'faqs'));
    }
    
    public function jobsIndex(Request $request)
    {
        $query = Job::with('organization', 'category')->where('status', 'open');
        
        // Apply search filters
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhereHas('organization', function($q2) use ($search) {
                      $q2->where('name', 'like', "%{$search}%");
                  });
            });
        }
        
        // Category filter
        if ($request->filled('categories')) {
            $query->whereIn('category_id', $request->input('categories'));
        }
        
        // Employment type filter
        if ($request->filled('employment_types')) {
            $query->whereIn('employment_type', $request->input('employment_types'));
        }
        
        // Salary range filter
        if ($request->filled('min_salary')) {
            $query->where('salary_min', '>=', $request->input('min_salary'));
        }
        
        if ($request->filled('max_salary')) {
            $query->where('salary_max', '<=', $request->input('max_salary'));
        }
        
        // Location filter
        if ($request->filled('location')) {
            $query->where('location', 'like', '%' . $request->input('location') . '%');
        }
        
        // Featured jobs filter
        if ($request->filled('featured')) {
            $query->where('is_featured', true);
        }
        
        // Sorting
        $sort = $request->input('sort', 'Newest');
        switch ($sort) {
            case 'Oldest':
                $query->oldest();
                break;
            case 'Salary: High to Low':
                $query->orderByDesc('salary_max')->orderByDesc('salary_min');
                break;
            case 'Salary: Low to High':
                $query->orderBy('salary_min')->orderBy('salary_max');
                break;
            case 'Newest':
            default:
                $query->latest();
                break;
        }
        
        $jobs = $query->paginate(10);
        $categories = JobCategory::all();
        
        return view('public.jobs.index', compact('jobs', 'categories'));
    }
    
    public function jobShow($slug)
    {
        $job = Job::with('organization', 'category')
            ->where('slug', $slug)
            ->firstOrFail();
            
        // Get similar jobs
        $similarJobs = Job::with('organization')
            ->where('id', '!=', $job->id)
            ->where('status', 'open')
            ->when($job->category_id, function($query) use ($job) {
                return $query->where('category_id', $job->category_id);
            })
            ->take(4)
            ->get();
            
        return view('public.jobs.show', compact('job', 'similarJobs'));
    }
    
    public function jobApply($slug)
    {
        $job = Job::with('organization')
            ->where('slug', $slug)
            ->firstOrFail();
            
        if (!auth()->check()) {
            return redirect()->route('login')
                ->with('error', 'Please login to apply for jobs.');
        }
        
        if (!auth()->user()->hasRole('Candidate')) {
            return redirect()->back()
                ->with('error', 'Only candidates can apply for jobs.');
        }
        
        return view('public.jobs.apply', compact('job'));
    }
    
    public function organizationsIndex(Request $request)
    {
        $query = OrganizationProfile::withCount(['jobs' => function($query) {
            $query->where('status', 'open');
        }]);
        
        // Apply search filters
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('industry', 'like', "%{$search}%");
            });
        }
        
        // Industry filter
        if ($request->filled('industries')) {
            $query->whereIn('industry', $request->input('industries'));
        }
        
        // Company size filter
        if ($request->filled('sizes')) {
            $query->whereIn('size', $request->input('sizes'));
        }
        
        // Location filter
        if ($request->filled('location')) {
            $query->where('location', 'like', '%' . $request->input('location') . '%');
        }
        
        // Sorting
        $sort = $request->input('sort', 'Name');
        switch ($sort) {
            case 'Most Jobs':
                $query->orderByDesc('jobs_count');
                break;
            case 'Newest':
                $query->orderByDesc('created_at');
                break;
            case 'Name':
            default:
                $query->orderBy('name');
                break;
        }
        
        $organizations = $query->paginate(10);
        
        return view('public.organizations.index', compact('organizations'));
    }
    
    public function organizationShow($slug)
    {
        $organization = OrganizationProfile::where('slug', $slug)->firstOrFail();
        
        $jobs = Job::where('organization_id', $organization->id)
            ->where('status', 'open')
            ->latest()
            ->paginate(5);
            
        return view('public.organizations.show', compact('organization', 'jobs'));
    }
}
