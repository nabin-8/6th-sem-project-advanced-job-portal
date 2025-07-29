@extends('layouts.master')

@section('title', $profile->name)

@push('styles')
    <style>
        .org-profile-header {
            background: linear-gradient(135deg, var(--secondary-color) 0%, var(--primary-color) 100%);
            padding: 3rem 0;
            margin-bottom: 2rem;
            position: relative;
            overflow: hidden;
        }
        
        .org-profile-header::before {
            content: '';
            position: absolute;
            top: -50px;
            right: -50px;
            width: 200px;
            height: 200px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            z-index: 0;
        }
        
        .org-profile-header::after {
            content: '';
            position: absolute;
            bottom: -70px;
            left: -70px;
            width: 300px;
            height: 300px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.05);
            z-index: 0;
        }
        
        .org-logo {
            width: 150px;
            height: 150px;
            object-fit: contain;
            background-color: #fff;
            padding: 1rem;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        
        .org-card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            overflow: hidden;
            height: auto !important;
            /* min-height: 100%; */
            background-color: #fff;
            margin-bottom: 1.5rem;
        }
        
        .org-card .card-header {
            border-bottom: none;
            padding: 1.25rem 1.5rem;
            background: #fff;
            display: flex;
            align-items: center;
        }
        
        .org-card .card-header h5 {
            margin: 0;
            font-weight: 600;
            color: #333;
            font-size: 1.1rem;
        }
        
        .org-card .card-header i {
            color: #0056b3;
            margin-right: 10px;
            font-size: 1.1rem;
        }
        
        .org-card .card-body {
            padding: 1.5rem;
            font-size: 0.95rem;
            line-height: 1.6;
            color: #555;
        }
        
        .org-info-list {
            border-radius: 0;
            overflow: hidden;
        }
        
        .org-info-list .list-group-item {
            padding: 1rem 1.5rem;
            border: none;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }
        
        .org-info-list .list-group-item:last-child {
            border-bottom: none;
        }
        
        .info-icon {
            width: 40px;
            height: 40px;
            background-color: rgba(0, 86, 179, 0.08);
            color: #0056b3;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            margin-right: 1rem;
            flex-shrink: 0;
            font-size: 1rem;
        }
        
        .org-info-list small.text-muted {
            font-size: 0.75rem;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #6c757d;
        }
        
        .org-info-list span, .org-info-list a {
            font-weight: 500;
            color: #333;
        }
        
        .org-info-list a {
            color: #0056b3;
            text-decoration: none;
        }
        
        .org-info-list a:hover {
            text-decoration: underline;
        }
        
        /* Footer overlap fix */
        .footer-spacer {
            position: relative;
            z-index: -1;
        }
        
        /* Override any footer styles that might be causing the overlap */
        /* footer, .footer {
            position: relative !important;
            z-index: 10;
            margin-top: 3rem !important;
            clear: both;
        } */
        
        /* Ensure the container doesn't have overflow issues */
        .container.mb-5 {
            overflow: visible;
            padding-bottom: 50px;
        }
        
        /* Force the page to have enough height */
        html, body {
            min-height: 100%;
            height: auto !important;
        }
        
        /* Featured job styling */
        .featured-job-item {
            background-color: rgba(255, 193, 7, 0.05);
            transition: all 0.3s ease;
        }
        
        .featured-job-item:hover {
            background-color: rgba(255, 193, 7, 0.1);
        }
        
        /* Responsive styles */
        @media (max-width: 992px) {
            .org-logo {
                width: 130px;
                height: 130px;
            }
            
            .job-stats h2 {
                font-size: 1.5rem;
            }
        }
        
        @media (max-width: 768px) {
            .org-logo {
                width: 120px;
                height: 120px;
            }
            
            .org-profile-header {
                padding: 2rem 0;
            }
            
            .list-group-item {
                padding: 0.75rem 1rem;
            }
            
            .info-icon {
                width: 35px;
                height: 35px;
                font-size: 0.9rem;
            }
            
            .job-stats-icon {
                width: 50px;
                height: 50px;
                font-size: 1.25rem;
                margin-bottom: 0.5rem;
            }
            
            .job-stats {
                padding: 1rem;
            }
        }
        
        @media (max-width: 576px) {
            .org-logo {
                width: 100px;
                height: 100px;
                padding: 0.75rem;
            }
            
            h1.h2 {
                font-size: 1.5rem;
            }
            
            .lead {
                font-size: 1rem;
            }
            
            .list-group-item .small {
                font-size: 0.7rem;
            }
            
            .card-header h5 {
                font-size: 1rem;
            }
            
            .job-stats h2 {
                font-size: 1.25rem;
            }
            
            .list-group-item p-4 {
                padding: 0.75rem !important;
            }
            
            .btn-sm {
                padding: 0.25rem 0.5rem;
                font-size: 0.75rem;
            }
        }
        
        /* Adaptive footer and container styles */
        .footer-spacer {
            display: block;
            width: 100%;
            min-height: 3rem;
            clear: both;
        }
        
        main {
            min-height: calc(100vh - 350px);
            display: flex;
            flex-direction: column;
        }
        
        main > .container {
            flex: 1;
        }
        
        footer, .footer {
            position: relative !important;
            margin-top: auto;
        }
        
        /* Override fixed heights with min-height to adapt to content */
        .org-card, .job-stats {
            height: auto !important;
            /* min-height: 100%; */
        }
        
        /* Job listing responsive styling */
        .list-group-item {
            transition: all 0.3s ease;
        }
        
        .list-group-item:hover {
            background-color: rgba(0, 0, 0, 0.01);
        }
        
        @media (max-width: 576px) {
            .d-flex.justify-content-between.align-items-start {
                flex-direction: column;
            }
            
            .d-flex.justify-content-between.align-items-start > div:last-child {
                margin-top: 1rem;
                align-self: flex-start;
            }
        }
    </style>
@endpush

@section('content')    <!-- Organization Profile Header -->
    <div class="org-profile-header text-white">
        <div class="container position-relative" style="z-index: 1;">
            <div class="d-flex flex-column flex-md-row align-items-md-center">
                <div class="me-md-4 mb-3 mb-md-0 text-center text-md-start">
                    @if ($profile->logo)
                        <img src="{{ asset('uploads/' . $profile->logo) }}" alt="{{ $profile->name }}" class="org-logo">
                    @else
                        <div class="org-logo d-flex align-items-center justify-content-center">
                            <i class="fas fa-building fa-3x text-secondary"></i>
                        </div>
                    @endif
                </div>
                <div class="org-header-content">
                    <h1 class="h2 mb-2">{{ $profile->name }}</h1>
                    <p class="lead mb-2">{{ $profile->industry ?? 'Organization' }}</p>
                    <div class="d-flex align-items-center">
                        <i class="fas fa-map-marker-alt me-2"></i>
                        <span>{{ $profile->location ?? 'Location not specified' }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div><div class="container mb-5">
        <div class="row">
            <div class="col-lg-4">
                <!-- Company Information -->
                <div class="org-card mb-4">
                    <div class="card-header">
                        <h5><i class="fas fa-info-circle me-2 text-primary"></i>Company Information</h5>
                    </div>
                    <div class="card-body p-0">
                        <ul class="list-group org-info-list">
                            @if($profile->founded_year)
                            <li class="list-group-item d-flex align-items-center">
                                <div class="info-icon">
                                    <i class="fas fa-calendar"></i>
                                </div>
                                <div>
                                    <small class="text-muted d-block">Founded Year</small>
                                    <span>{{ $profile->founded_year }}</span>
                                </div>
                            </li>
                            @endif
                            
                            @if($profile->company_size)
                            <li class="list-group-item d-flex align-items-center">
                                <div class="info-icon">
                                    <i class="fas fa-users"></i>
                                </div>
                                <div>
                                    <small class="text-muted d-block">Company Size</small>
                                    <span>{{ $profile->company_size }}</span>
                                </div>
                            </li>
                            @endif
                            
                            @if($profile->website)
                            <li class="list-group-item d-flex align-items-center">
                                <div class="info-icon">
                                    <i class="fas fa-globe"></i>
                                </div>
                                <div>
                                    <small class="text-muted d-block">Website</small>
                                    <a href="{{ $profile->website }}" target="_blank" class="text-primary">Visit website</a>
                                </div>
                            </li>
                            @endif
                            
                            @if($profile->email)
                            <li class="list-group-item d-flex align-items-center">
                                <div class="info-icon">
                                    <i class="fas fa-envelope"></i>
                                </div>
                                <div>
                                    <small class="text-muted d-block">Email</small>
                                    <a href="mailto:{{ $profile->email }}">{{ $profile->email }}</a>
                                </div>
                            </li>
                            @endif
                            
                            @if($profile->phone)
                            <li class="list-group-item d-flex align-items-center">
                                <div class="info-icon">
                                    <i class="fas fa-phone"></i>
                                </div>
                                <div>
                                    <small class="text-muted d-block">Phone</small>
                                    <span>{{ $profile->phone }}</span>
                                </div>
                            </li>
                            @endif
                        </ul>
                    </div>
                </div>
                
                <!-- Social Media Links -->
                @if($profile->linkedin || $profile->twitter)
                <div class="org-card mb-4">
                    <div class="card-header">
                        <h5><i class="fas fa-share-alt me-2 text-primary"></i>Connect With Us</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex flex-wrap">
                            @if($profile->linkedin)
                                <a href="{{ $profile->linkedin }}" target="_blank" class="social-btn btn btn-outline-primary mb-2">
                                    <i class="fab fa-linkedin me-2"></i> LinkedIn
                                </a>
                            @endif
                            
                            @if($profile->twitter)
                                <a href="{{ $profile->twitter }}" target="_blank" class="social-btn btn btn-outline-info mb-2">
                                    <i class="fab fa-twitter me-2"></i> Twitter
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
                @endif
                
                <!-- Job Statistics -->                <div class="row g-3">
                    <div class="col-6">
                        <div class="job-stats" style="background-color: #f8f9fa; border-radius: 12px;">
                            <div class="job-stats-icon" style="background-color: rgba(13, 110, 253, 0.1); color: #0d6efd;">
                                <i class="fas fa-briefcase"></i>
                            </div>
                            <h2 class="fw-bold mb-0">{{ $activeJobsCount ?? 0 }}</h2>
                            <p class="text-muted mb-0">Active Jobs</p>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="job-stats" style="background-color: #f8f9fa; border-radius: 12px;">
                            <div class="job-stats-icon" style="background-color: rgba(255, 193, 7, 0.1); color: #ffc107;">
                                <i class="fas fa-star"></i>
                            </div>
                            <h2 class="fw-bold mb-0">{{ $featuredJobsCount ?? 0 }}</h2>
                            <p class="text-muted mb-0">Featured</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-8">
                <!-- About -->
                <div class="org-card mb-4">
                    <div class="card-header">
                        <h5><i class="fas fa-building me-2 text-primary"></i>About {{ $profile->name }}</h5>
                    </div>
                    <div class="card-body">
                        @if($profile->description)
                            <div class="mb-0">
                                {!! nl2br(e($profile->description)) !!}
                            </div>
                        @else
                            <p class="text-muted mb-0">No company description available.</p>
                        @endif
                    </div>
                </div>
                
                <!-- Company Jobs -->                <div class="org-card mb-4">                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><i class="fas fa-briefcase me-2 text-primary"></i>Open Positions</h5>
                        <a href="{{ route('jobs.index', ['organization_id' => $profile->id]) }}" class="btn btn-sm btn-primary rounded-pill px-3">View All</a>
                    </div>
                    <div class="card-body p-0">
                        @if(isset($jobs) && $jobs->count() > 0)
                            <ul class="list-group list-group-flush">
                                @foreach($jobs as $job)                                    <li class="list-group-item p-4 {{ $job->is_featured ? 'featured-job-item border-start border-warning border-3' : '' }}" style="border-bottom: 1px solid rgba(0,0,0,0.08);">
                                        <a href="{{ route('jobs.show', $job->id) }}" class="text-decoration-none">
                                            <div class="d-flex justify-content-between align-items-start job-list-item">
                                                <div class="job-details">
                                                    <h6 class="mb-2 text-dark fw-bold">
                                                        {{ $job->title }}
                                                        @if($job->is_featured)
                                                            <span class="badge bg-warning text-dark ms-2"><i class="fas fa-star me-1"></i>Featured</span>
                                                        @endif
                                                    </h6>
                                                    <div class="d-flex flex-wrap align-items-center mb-2 job-meta">
                                                        <div class="me-3 mb-1">
                                                            <i class="fas fa-map-marker-alt me-1 text-muted"></i> 
                                                            <span class="text-muted">{{ $job->location }}</span>
                                                        </div>
                                                        <div class="me-3 mb-1">
                                                            <i class="fas fa-clock me-1 text-muted"></i> 
                                                            <span class="text-muted">{{ ucfirst(str_replace('_', ' ', $job->employment_type)) }}</span>
                                                        </div>
                                                        @if($job->salary_min && $job->salary_max)
                                                        <div class="me-3 mb-1">
                                                            <i class="fas fa-money-bill-wave me-1 text-muted"></i> 
                                                            <span class="text-muted">${{ number_format($job->salary_min) }} - ${{ number_format($job->salary_max) }}</span>
                                                        </div>
                                                        @endif
                                                    </div>
                                                    <div class="d-flex flex-wrap job-dates">
                                                        <div class="me-3 mb-1">
                                                            <i class="fas fa-calendar-check me-1 text-primary"></i> 
                                                            <span class="text-primary">Posted: {{ $job->created_at->format('M d, Y') }}</span>
                                                        </div>
                                                        @if($job->application_deadline)
                                                        <div>
                                                            <i class="fas fa-calendar-times me-1 text-danger"></i> 
                                                            <span class="text-danger">Deadline: {{ $job->application_deadline->format('M d, Y') }}</span>
                                                        </div>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="job-apply-btn">
                                                    <span class="btn btn-primary btn-sm px-3">Apply Now</span>
                                                </div>
                                            </div>
                                        </a>
                                    </li>@endforeach
                            </ul>                            @if($activeJobsCount > 5)
                                <div class="text-center py-4">
                                    <a href="{{ route('jobs.index', ['organization_id' => $profile->id]) }}" class="btn btn-outline-primary btn-sm px-4">
                                        View {{ $activeJobsCount - 5 }} More Jobs
                                    </a>
                                </div>
                            @endif
                        @else
                            <div class="p-4 text-center">
                                <i class="fas fa-briefcase fa-3x text-muted mb-3"></i>
                                <p class="mb-0">No open positions available at the moment.</p>
                            </div>
                        @endif
                    </div>
                </div>            </div>
        </div>    </div>    <!-- Footer spacing that adapts to content -->
    <div class="footer-spacer"></div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Function to check and adjust footer spacing - adaptive to content
    function adjustFooterSpacing() {
        const contentHeight = document.body.scrollHeight;
        const viewportHeight = window.innerHeight;
        const footerSpacer = document.querySelector('.footer-spacer');
        const footer = document.querySelector('footer') || document.querySelector('.footer');
        
        if (!footerSpacer) return;
        
        // Reset any previously set heights
        footerSpacer.style.paddingBottom = '0';
        
        // Get updated measurements after reset
        const updatedContentHeight = document.body.scrollHeight;
        
        if (updatedContentHeight < viewportHeight) {
            // Calculate needed space to push footer to bottom
            const footerHeight = footer ? footer.offsetHeight : 100;
            const mainContent = document.querySelector('main') || document.body;
            const mainContentHeight = mainContent.offsetHeight;
            const neededSpace = viewportHeight - mainContentHeight - footerHeight;
            
            // Apply padding only if we need to push the footer down
            if (neededSpace > 0) {
                footerSpacer.style.paddingBottom = neededSpace + 'px';
            }
        }
    }
    
    // Run the adjustment after images have loaded for accurate height calculation
    window.addEventListener('load', function() {
        adjustFooterSpacing();
        
        // Additional check for dynamic content loading
        setTimeout(adjustFooterSpacing, 500);
    });
    
    // Run on window resize
    window.addEventListener('resize', adjustFooterSpacing);
    
    // Run when content changes (like when jobs might load dynamically)
    const observer = new MutationObserver(function(mutations) {
        adjustFooterSpacing();
    });
    
    // Target node is the job listings container
    const targetNode = document.querySelector('.org-card .card-body');
    if (targetNode) {
        observer.observe(targetNode, { childList: true, subtree: true });
    }
});
</script>
@endpush