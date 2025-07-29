@extends('layouts.master')

@section('title', 'Home')

@section('content')
    <!-- Include SVG icons -->
    <div class="d-none">
        @include('components.svg-icons')
    </div>    @push('styles')
        <style>
            /* Hero */
            .hero {
                padding: 6rem 0;
                position: relative;
                overflow: hidden;
            }

            .hero .hero-text {
                position: relative;
                z-index: 2;
            }

            .hero .hero-bg-element {
                position: absolute;
                z-index: 1;
                opacity: 0.05;
                background: #fff;
                border-radius: 50%;
            }

            .hero .btn {
                min-width: 160px;
                transition: transform 0.25s ease;
            }

            .hero .btn:hover {
                transform: translateY(-3px);
            }              /* Hero section styling - Simplified to match diagram */
            .hero-section {
                padding: 60px 0;
                background-color: #ffffff;
                position: relative;
                overflow: hidden;
                border: 1px solid #eee;
                border-radius: 20px;
                margin: 20px auto;
            }
            
            .hero-content {
                position: relative;
                z-index: 1;
            }
            
            /* Handwritten style font for the heading */
            .handwritten-style {
                font-family: 'Inter', 'Segoe UI', sans-serif;
                font-weight: 700;
                font-size: 2.5rem;
                line-height: 1.3;
                color: #333;
            }
            
            /* Badge outline style */
            .badge-outline {
                border: 1px solid #333;
                background: transparent;
                color: #333;
                padding: 8px 16px;
                border-radius: 20px;
                font-weight: 500;
            }
            
            /* Keyword pills like in the diagram */
            .keyword-pill {
                display: inline-block;
                padding: 6px 16px;
                border: 1px solid #ddd;
                border-radius: 50px;
                color: #333;
                text-decoration: none;
                font-size: 0.9rem;
                transition: all 0.2s;
                background: #f8f9fa;
            }
            
            .keyword-pill:hover {
                background-color: #e9ecef;
                color: #333;
            }
            
            /* Banner placeholder with simple border */
            .banner-placeholder {
                border: 1px solid #ddd;
                border-radius: 10px;
                overflow: hidden;
                background-color: #f8f9fa;
                height: 350px;
                display: flex;
                align-items: center;
                justify-content: center;
            }
            
            .banner-placeholder img {
                max-height: 100%;
                object-fit: cover;
            }
            
            /* Carousel styling */
            .carousel-item {
                transition: transform 0.8s ease-in-out;
            }
            
            .carousel-indicators {
                position: relative;
                margin-top: 15px;
                display: flex;
                justify-content: center;
                padding-left: 0;
                margin-right: 15%;
                margin-left: 15%;
            }
            
            .carousel-indicators button {
                width: 10px;
                height: 10px;
                margin-right: 8px;
                background-color: rgba(0,0,0,.1);
                border: none;
                border-radius: 50%;
            }
            
            .carousel-indicators button.active {
                background-color: #000;
            }

            /* Step circles */
            .step-circle {
                width: 80px;
                height: 80px;
                border: 1px solid rgba(0, 86, 179, 0.1);
                background-color: #fff;
                border-radius: 50%;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                margin-bottom: 1.5rem;
                box-shadow: var(--box-shadow);
                transition: var(--transition);
                color: var(--primary-color);
            }

            .steps-container:hover .step-item:not(:hover) .step-circle {
                opacity: 0.7;
            }
            
            .step-item:hover .step-circle {
                background-color: var(--primary-color);
                color: #fff;
                transform: translateY(-5px);
            }

            /* Category circles */
            .category-item {
                transition: var(--transition);
                border: 1px solid rgba(0, 0, 0, 0.05);
            }
            
            .category-item:hover {
                transform: translateY(-5px);
                box-shadow: var(--box-shadow);
            }

            .category-circle {
                width: 60px;
                height: 60px;
                border: 2px solid rgba(0, 86, 179, 0.1);
                background-color: rgba(0, 86, 179, 0.03);
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                margin-bottom: 0.5rem;
                margin-right: 1rem;
            }

            /* Featured & Recent cards */
            .job-card {
                border: 1px solid rgba(0, 0, 0, 0.05);
                border-radius: 10px;
                transition: transform .3s, box-shadow .3s;
                position: relative;
                overflow: hidden;
                background: #fff;
            }

            .job-card:hover {
                transform: translateY(-5px);
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            }

            .job-card .card-accent {
                position: absolute;
                top: 0;
                left: 0;
                height: 4px;
                width: 100%;
                background: var(--primary-color);
            }

            /* Stats cards */
            .stats-card {
                background: #fff;
                border-radius: 10px;
                border: none;
                transition: transform .3s, box-shadow .3s;
                position: relative;
                overflow: hidden;
            }
            
            .stats-card:hover {
                transform: translateY(-5px);
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            }

            .stats-card::before {
                content: '';
                position: absolute;
                top: -40px;
                right: -40px;
                width: 120px;
                height: 120px;
                background: rgba(0, 86, 179, 0.05);
                border-radius: 50%;
                z-index: 0;
            }

            /* FAQ accordion */
            .accordion-item {
                border: 1px solid rgba(0, 0, 0, 0.05);
                border-radius: 10px;
                margin-bottom: 1rem;
                overflow: hidden;
            }
            
            .accordion-button:not(.collapsed) {
                background-color: rgba(0, 86, 179, 0.05);
                color: var(--primary-color);
            }
            
            .accordion-button:focus {
                box-shadow: none;
                border-color: rgba(0, 0, 0, 0.1);
            }

            /* Utility classes */
            .rounded-lg {
                border-radius: 10px !important;
            }

            .bg-gradient-primary {
                background: linear-gradient(135deg, var(--primary-color) 0%, #0078ff 100%);
            }

            .text-primary {
                color: var(--primary-color) !important;
            }
            
            .text-secondary {
                color: var(--secondary-color) !important;
            }

            .hover-shadow:hover {
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            }
        </style>
    @endpush    <!-- Hero Section with Left Content and Right Slider - Simplified Design -->
    <section class="hero-section py-5">
        <div class="container">
            <div class="row align-items-center">
                <!-- Left Content -->
                <div class="col-lg-6 mb-5 mb-lg-0">
                    <div class="hero-content pe-lg-4">
                        <!-- Badge in an outlined format as shown in diagram -->
                        <div class="mb-3">
                            <span class="badge badge-outline">Find Your Career</span>
                        </div>
                        
                        <!-- Heading with handwritten style font -->
                        <h1 class="handwritten-style mb-4">
                            Find Your Career<br>
                            to Make a Better Life
                        </h1>
                        
                        <!-- Simple paragraph text -->
                        <p class="text-muted mb-4">
                            Creating a beautiful job website is not easy always.<br>
                            To make your life easier, we are introducing Jobcamp template.
                        </p>
                        
                        <!-- Simple search form with single input and button -->
                        <div class="simple-search-form mb-4">
                            <form action="{{ route('jobs.index') }}" method="GET" class="d-flex">
                                <input type="text" class="form-control  border border-2 rounded-pill me-2" 
                                    name="q" placeholder="Search title, skill, organization" style="border-radius: 30px;">
                                <button type="submit" class="btn btn-primary px-4 rounded-pill">Search</button>
                            </form>
                        </div>
                        
                        <!-- Popular Keywords with oval pills -->
                        <div class="popular-keywords">
                            <p class="mb-2">Popular keywords:</p>
                            <div class="d-flex flex-wrap gap-2">
                                <a href="{{ route('jobs.index', ['q' => 'Administrative']) }}" class="keyword-pill">Administrative</a>
                                <a href="{{ route('jobs.index', ['q' => 'Android']) }}" class="keyword-pill">Android</a>
                                <a href="{{ route('jobs.index', ['q' => 'app']) }}" class="keyword-pill">app</a>
                                <a href="{{ route('jobs.index', ['q' => 'ASP.NET']) }}" class="keyword-pill">ASP.NET</a>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Right Banner with placeholder X as in diagram -->
                <div class="col-lg-6">
                    <div id="heroBannerCarousel" class="carousel slide" data-bs-ride="carousel">
                        <!-- Images -->
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <div class="banner-placeholder">
                                    <img src="{{ asset('uploads/banners/banner3.jpg') }}" class="d-block w-100" alt="Job Portal Banner">
                                </div>
                            </div>
                            <div class="carousel-item">
                                <div class="banner-placeholder">
                                    <img src="{{ asset('uploads/banners/banner1.jpg') }}" class="d-block w-100" alt="Job Portal Banner">
                                </div>
                            </div>
                            <div class="carousel-item">
                                <div class="banner-placeholder">
                                    <img src="{{ asset('uploads/banners/banner2.jpg') }}" class="d-block w-100" alt="Job Portal Banner">
                                </div>
                            </div>
                            <div class="carousel-item">
                                <div class="banner-placeholder">
                                    <img src="{{ asset('uploads/banners/banner4.jpg') }}" class="d-block w-100" alt="Job Portal Banner">
                                </div>
                            </div>
                            <div class="carousel-item">
                                <div class="banner-placeholder">
                                    <img src="{{ asset('uploads/banners/banner1.png') }}" class="d-block w-100" alt="Job Portal Banner">
                                </div>
                            </div>
                        </div>
                        
                        <!-- Indicators similar to the diagram -->
                        <div class="carousel-indicators position-relative mt-3">
                            <button type="button" data-bs-target="#heroBannerCarousel" data-bs-slide-to="0" class="active" aria-current="true" 
                                aria-label="Slide 1" style="width: 10px; height: 10px; border-radius: 50%; background-color: #000;"></button>
                            <button type="button" data-bs-target="#heroBannerCarousel" data-bs-slide-to="1" aria-label="Slide 2"
                                style="width: 10px; height: 10px; border-radius: 50%;"></button>
                            <button type="button" data-bs-target="#heroBannerCarousel" data-bs-slide-to="2" aria-label="Slide 3"
                                style="width: 10px; height: 10px; border-radius: 50%;"></button>
                            <button type="button" data-bs-target="#heroBannerCarousel" data-bs-slide-to="3" aria-label="Slide 4"
                                style="width: 10px; height: 10px; border-radius: 50%;"></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Video Modal -->
    <div class="modal fade" id="videoModal" tabindex="-1" aria-labelledby="videoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="videoModalLabel">Job Portal Introduction</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-0">
                    <div class="ratio ratio-16x9">
                        <iframe src="about:blank" title="Job Portal Video" allowfullscreen id="videoFrame"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Steps Section -->
    <div class="container py-5">
        <div class="row mb-4">
            <div class="col-12 text-center">
                <h2 class="fw-bold">How It Works</h2>
                <p class="text-muted">Three simple steps to find your dream job</p>
            </div>
        </div>
        <div class="row justify-content-center steps-container">
            <div class="col-md-4 col-lg-4 text-center mb-4 step-item">
                <div class="p-4">
                    <div class="step-circle mb-4">
                        <i class="fas fa-user-plus fs-3"></i>
                    </div>
                    <h5 class="fw-bold">Register Account</h5>
                    <p class="text-muted">Create your profile to get started</p>
                </div>
            </div>
            <div class="col-md-4 col-lg-4 text-center mb-4 step-item">
                <div class="p-4">
                    <div class="step-circle mb-4">
                        <i class="fas fa-id-card fs-3"></i>
                    </div>
                    <h5 class="fw-bold">Complete Profile</h5>
                    <p class="text-muted">Add your skills and experience</p>
                </div>
            </div>
            <div class="col-md-4 col-lg-4 text-center mb-4 step-item">
                <div class="p-4">
                    <div class="step-circle mb-4">
                        <i class="fas fa-paper-plane fs-3"></i>
                    </div>
                    <h5 class="fw-bold">Apply for Jobs</h5>
                    <p class="text-muted">Submit applications with one click</p>
                </div>
            </div>
        </div>
    </div> 
    
    <!-- Stats Section -->
    <div class="bg-light py-5">
        <div class="container">
            <div class="row g-4 text-center">
                <div class="col-md-4">
                    <div class="stats-card p-4 h-100">
                        <div class="position-relative" style="z-index: 1;">
                            <div class="rounded-circle bg-primary bg-opacity-10 d-inline-flex justify-content-center align-items-center mb-4"
                                style="width: 80px; height: 80px;">
                                <i class="fas fa-briefcase fa-2x text-primary"></i>
                            </div>
                            <h2 class="fw-bold display-6 mb-2">{{ $totalJobs }}+</h2>
                            <h5 class="fw-bold text-primary mb-3">Job Opportunities</h5>
                            <p class="text-muted mb-0">Find exciting career opportunities across various industries</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stats-card p-4 h-100">
                        <div class="position-relative" style="z-index: 1;">
                            <div class="rounded-circle bg-primary bg-opacity-10 d-inline-flex justify-content-center align-items-center mb-4"
                                style="width: 80px; height: 80px;">
                                <i class="fas fa-building fa-2x text-primary"></i>
                            </div>
                            <h2 class="fw-bold display-6 mb-2">500+</h2>
                            <h5 class="fw-bold text-primary mb-3">Leading Companies</h5>
                            <p class="text-muted mb-0">Connect with top employers looking for talent like you</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stats-card p-4 h-100">
                        <div class="position-relative" style="z-index: 1;">
                            <div class="rounded-circle bg-primary bg-opacity-10 d-inline-flex justify-content-center align-items-center mb-4"
                                style="width: 80px; height: 80px;">
                                <i class="fas fa-users fa-2x text-primary"></i>
                            </div>
                            <h2 class="fw-bold display-6 mb-2">10,000+</h2>
                            <h5 class="fw-bold text-primary mb-3">Successful Placements</h5>
                            <p class="text-muted mb-0">Join thousands who found their perfect career match</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Featured Jobs Section -->
    <div class="container py-5">
        <div class="row mb-4">
            <div class="col-12">
                <h2 class="fw-bold">Featured Jobs</h2>
                <p class="text-muted">Explore our handpicked selection of top opportunities</p>
            </div>
        </div>
        <div class="row g-4">
            @if ($featuredJobs->count() > 0)
                @foreach ($featuredJobs as $job)
                    <div class="col-md-6 col-lg-3">
                        <div class="job-card h-100 shadow-sm">
                            <div class="card-accent"></div>
                            <a href="{{ route('jobs.show', $job->id) }}" class="text-decoration-none">
                                <div class="p-4">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="flex-shrink-0">
                                            @if ($job->organization->logo)
                                                <img src="{{ asset('uploads/' . $job->organization->logo) }}"
                                                    class="rounded-circle border" width="50" height="50"
                                                    alt="{{ $job->organization->name }}" style="object-fit: cover;">
                                            @else
                                                <div class="rounded-circle bg-light d-flex align-items-center justify-content-center"
                                                    style="width: 50px; height: 50px;">
                                                    <i class="fas fa-building text-secondary"></i>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <h5 class="mb-0 text-dark">{{ $job->title }}</h5>
                                            <span class="text-muted">{{ $job->organization->name }}</span>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <span class="badge bg-light text-dark me-1"><i
                                                class="fas fa-map-marker-alt me-1"></i>{{ $job->location }}</span>
                                        <span class="badge bg-light text-dark"><i
                                                class="fas fa-clock me-1"></i>{{ ucfirst(str_replace('_', ' ', $job->employment_type)) }}</span>
                                    </div>
                                    <p class="card-text small text-muted">{{ Str::limit($job->description, 80) }}</p>
                                    <div class="mt-auto d-flex justify-content-between align-items-center">
                                        <span class="badge bg-primary"><i class="fas fa-star me-1"></i>Featured</span>
                                        <small class="text-muted">{{ $job->created_at->diffForHumans() }}</small>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="col-12">
                    <div class="alert alert-info rounded-lg">
                        No featured jobs available at the moment. Check back soon for new opportunities!
                    </div>
                </div>
            @endif
        </div>
        <div class="row mt-4">
            <div class="col-12 text-center">
                <a href="{{ route('jobs.index') }}" class="btn btn-primary px-4 py-2 rounded-pill">View All Jobs <i class="fas fa-arrow-right ms-2"></i></a>
            </div>
        </div>
    </div>

    <!-- Job Categories Section -->
    <div class="bg-light py-5">
        <div class="container">
            <div class="row mb-4">
                <div class="col-12 text-center">
                    <h2 class="fw-bold">Job Categories</h2>
                    <p class="text-muted">Explore opportunities by category</p>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-8">
                    <div class="row g-4">
                        @if ($categories->count() > 0)
                            @foreach ($categories as $category)
                                <div class="col-md-6 mb-3">
                                    <a href="{{ route('jobs.index', ['category_id' => $category->id]) }}"
                                        class="text-decoration-none">
                                        <div class="category-item d-flex align-items-center bg-white rounded-lg p-3">
                                            <div class="flex-shrink-0 me-3">
                                                <div class="category-circle">
                                                    <i class="fas fa-th text-primary"></i>
                                                </div>
                                            </div>
                                            <div>
                                                <h5 class="mb-0 text-dark">{{ $category->name }}
                                                    <span class="badge bg-light text-primary ms-2">{{ $category->jobs_count }}</span>
                                                </h5>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        @else
                            <div class="col-12">
                                <div class="alert alert-info rounded-lg">
                                    No job categories available at the moment.
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="bg-white rounded-lg shadow-sm p-4">
                        <h5 class="fw-bold mb-3">Employment Types</h5>
                        <ul class="list-unstyled">
                            <li class="mb-3 border-bottom pb-2">
                                <a href="{{ route('jobs.index', ['employment_type' => 'full_time']) }}"
                                    class="text-decoration-none text-dark d-flex justify-content-between align-items-center">
                                    <span><i class="fas fa-briefcase me-2 text-primary"></i>Full time</span>
                                    <span class="badge bg-light text-primary">{{ $employmentTypes['full_time'] }}</span>
                                </a>
                            </li>
                            <li class="mb-3 border-bottom pb-2">
                                <a href="{{ route('jobs.index', ['employment_type' => 'part_time']) }}"
                                    class="text-decoration-none text-dark d-flex justify-content-between align-items-center">
                                    <span><i class="fas fa-clock me-2 text-primary"></i>Part time</span>
                                    <span class="badge bg-light text-primary">{{ $employmentTypes['part_time'] }}</span>
                                </a>
                            </li>
                            <li class="mb-3 border-bottom pb-2">
                                <a href="{{ route('jobs.index', ['employment_type' => 'contract']) }}"
                                    class="text-decoration-none text-dark d-flex justify-content-between align-items-center">
                                    <span><i class="fas fa-file-signature me-2 text-primary"></i>Contract</span>
                                    <span class="badge bg-light text-primary">{{ $employmentTypes['contract'] }}</span>
                                </a>
                            </li>
                            <li class="mb-3">
                                <a href="{{ route('jobs.index', ['employment_type' => 'internship']) }}"
                                    class="text-decoration-none text-dark d-flex justify-content-between align-items-center">
                                    <span><i class="fas fa-graduation-cap me-2 text-primary"></i>Internship</span>
                                    <span class="badge bg-light text-primary">{{ $employmentTypes['internship'] }}</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Jobs -->
    <section class="py-5">
        <div class="container">
            <div class="row mb-4">
                <div class="col-12 text-center">
                    <h2 class="fw-bold">Recently Posted Jobs</h2>
                    <p class="text-muted mb-4">Be the first to apply to freshly posted opportunities</p>
                </div>
            </div>
            <div class="row g-4">
                @foreach ($recentJobs as $job)
                    <div class="col-md-6">
                        <a href="{{ route('jobs.show', $job->id) }}" class="text-decoration-none">
                            <div class="job-card p-4 shadow-sm h-100">
                                {{-- <div class="card-accent"></div> --}}
                                <div class="d-flex align-items-center mb-3">
                                    <div class="flex-shrink-0">
                                        @if ($job->organization->logo)
                                            <img src="{{ asset('uploads/' . $job->organization->logo) }}"
                                                class="rounded-circle border" width="50" height="50" alt="Logo"
                                                style="object-fit: cover;">
                                        @else
                                            <div class="rounded-circle bg-light d-flex align-items-center justify-content-center"
                                                style="width: 50px; height: 50px;">
                                                <i class="fas fa-building text-secondary"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h5 class="mb-0 text-dark">{{ $job->title }}</h5>
                                        <small class="text-muted">{{ $job->organization->name }}</small>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <span class="badge bg-light text-dark me-1"><i class="fas fa-map-marker-alt me-1"></i>
                                        {{ $job->location }}</span>
                                    <span class="badge bg-light text-dark me-1"><i class="fas fa-clock me-1"></i>
                                        {{ ucfirst(str_replace('_', ' ', $job->employment_type)) }}</span>
                                    @if ($job->salary_range)
                                        <span class="badge bg-light text-dark"><i class="fas fa-money-bill me-1"></i>
                                            {{ $job->salary_range }}</span>
                                    @endif
                                </div>
                                <p class="small text-muted">{{ Str::limit($job->description, 100) }}</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span
                                        class="badge {{ $job->is_featured ? 'bg-primary' : 'bg-success' }}">{{ $job->is_featured ? 'Featured' : 'New' }}</span>
                                    <small class="text-muted">{{ $job->created_at->diffForHumans() }}</small>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    
    <!-- CTA Section -->
    <div class="bg-gradient-primary text-white py-5 position-relative overflow-hidden">
        <!-- Background elements -->
        <div class="position-absolute"
            style="top: -30px; right: -30px; width: 200px; height: 200px; background: rgba(255,255,255,0.1); border-radius: 50%; z-index: 0;">
        </div>
        <div class="position-absolute"
            style="bottom: -50px; left: -50px; width: 300px; height: 300px; background: rgba(255,255,255,0.05); border-radius: 50%; z-index: 0;">
        </div>

        <div class="container py-5 position-relative" style="z-index: 1;">
            <div class="row align-items-center">
                <div class="col-lg-8 mb-4 mb-lg-0">
                    <span class="badge bg-white text-primary mb-3 px-3 py-2 rounded-pill">Join Our Community</span>
                    <h2 class="fw-bold display-5 mb-4">Ready to advance your career?</h2>
                    <p class="lead mb-0">Join our platform to find your dream job or post vacancies for your
                        organization.</p>
                </div>
                <div class="col-lg-4 text-lg-end">
                    <div class="d-inline-block position-relative">
                        <div class="position-absolute bg-white opacity-10 rounded-pill" style="inset: -3px; z-index: 0;">
                        </div>
                        <a href="{{ route('register') }}"
                            class="btn btn-light btn-lg px-5 py-3 rounded-pill fw-bold position-relative">
                            Get Started <i class="fas fa-arrow-right ms-2"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- FAQ Section -->
    <section class="py-5 position-relative overflow-hidden">
        <!-- Background elements for visual interest -->
        <div class="position-absolute opacity-10" style="top: -100px; left: -100px; width: 300px; height: 300px; background: var(--primary-color); border-radius: 50%; z-index: 0;"></div>
        <div class="position-absolute opacity-10" style="bottom: -50px; right: -50px; width: 200px; height: 200px; background: var(--primary-color); border-radius: 50%; z-index: 0;"></div>
        
        <div class="container position-relative" style="z-index: 1;">
            <div class="text-center mb-5">
                <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill mb-2">Help Center</span>
                <h2 class="fw-bold mb-4">Frequently Asked Questions</h2>
                <p class="text-muted mx-auto" style="max-width: 600px;">Find answers to common questions about using our platform and job search process</p>
            </div>
            
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="accordion" id="faqAccordion">
                        @foreach ($faqs as $i => $faq)
                            <div class="accordion-item mb-4">
                                <h2 class="accordion-header" id="heading{{ $i }}">
                                    <button class="accordion-button collapsed py-4"
                                        type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $i }}"
                                        aria-expanded="false" aria-controls="collapse{{ $i }}">
                                        <i class="fas fa-question-circle text-primary me-3"></i>
                                        <strong>{{ $faq->question }}</strong>
                                    </button>
                                </h2>
                                <div id="collapse{{ $i }}"
                                    class="accordion-collapse collapse"
                                    aria-labelledby="heading{{ $i }}" data-bs-parent="#faqAccordion">
                                    <div class="accordion-body bg-light p-4">{!! $faq->answer !!}</div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>    <!-- Hero Section JavaScript -->
    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize the carousel with an 8-second interval as requested
            var heroBannerCarousel = new bootstrap.Carousel(document.getElementById('heroBannerCarousel'), {
                interval: 8000,
                wrap: true
            });
            
            // Pause carousel on hover
            document.getElementById('heroBannerCarousel').addEventListener('mouseenter', function() {
                heroBannerCarousel.pause();
            });
            
            // Resume carousel on mouse leave
            document.getElementById('heroBannerCarousel').addEventListener('mouseleave', function() {
                heroBannerCarousel.cycle();
            });
        });
    </script>
    @endpush
@endsection
