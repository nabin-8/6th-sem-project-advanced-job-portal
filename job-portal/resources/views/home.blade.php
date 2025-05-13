@extends('layouts.master')

@section('title', 'Home')

@section('content')
    <!-- Hero Section -->
    <div class="container-fluid px-0">
        <div class="row g-0">
            <div class="col-12">
                <div class="bg-dark text-white py-5" style="background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url('https://images.unsplash.com/photo-1521737604893-d14cc237f11d?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1784&q=80') center center; background-size: cover;">
                    <div class="container py-5">
                        <div class="row py-5">
                            <div class="col-lg-8 mx-auto text-center">
                                <h1 class="display-4 fw-bold mb-4">Find Your Dream Job Today</h1>
                                <p class="lead mb-4">Discover thousands of job opportunities with top employers to find your next career.</p>
                                <div class="d-flex justify-content-center gap-3">
                                    <a href="{{ route('jobs.index') }}" class="btn btn-primary btn-lg px-4">Browse Jobs</a>
                                    <a href="{{ route('register') }}" class="btn btn-outline-light btn-lg px-4">Sign Up</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Section -->
    <div class="container py-5">
        <div class="row g-4 text-center">
            <div class="col-md-4">
                <div class="bg-white rounded shadow p-4">
                    <div class="display-5 text-primary mb-2">
                        <i class="fas fa-briefcase"></i>
                    </div>
                    <h4 class="fw-bold">{{ $totalJobs }}+</h4>
                    <h5>Job Opportunities</h5>
                    <p class="text-muted">Find exciting career opportunities across various industries</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="bg-white rounded shadow p-4">
                    <div class="display-5 text-primary mb-2">
                        <i class="fas fa-building"></i>
                    </div>
                    <h4 class="fw-bold">500+</h4>
                    <h5>Leading Companies</h5>
                    <p class="text-muted">Connect with top employers looking for talent like you</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="bg-white rounded shadow p-4">
                    <div class="display-5 text-primary mb-2">
                        <i class="fas fa-users"></i>
                    </div>
                    <h4 class="fw-bold">10,000+</h4>
                    <h5>Successful Placements</h5>
                    <p class="text-muted">Join thousands who found their perfect career match</p>
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
            @if($featuredJobs->count() > 0)
                @foreach($featuredJobs as $job)
                    <div class="col-md-6 col-lg-4">
                        <div class="card job-card shadow-sm h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <span class="badge bg-primary">Featured</span>
                                    <small class="text-muted">Posted {{ $job->created_at->diffForHumans() }}</small>
                                </div>
                                <h5 class="card-title">{{ $job->title }}</h5>
                                <h6 class="card-subtitle mb-2 text-muted">{{ $job->organization->name }}</h6>
                                <div class="mb-3">
                                    <span class="badge bg-light text-dark me-1"><i class="fas fa-map-marker-alt me-1"></i>{{ $job->location }}</span>
                                    <span class="badge bg-light text-dark"><i class="fas fa-clock me-1"></i>{{ ucfirst($job->employment_type) }}</span>
                                </div>
                                <p class="card-text">{{ Str::limit($job->description, 100) }}</p>
                            </div>
                            <div class="card-footer bg-white border-top-0">
                                <a href="{{ route('jobs.show', $job->id) }}" class="btn btn-sm btn-outline-primary">View Details</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="col-12">
                    <div class="alert alert-info">
                        No featured jobs available at the moment. Check back soon for new opportunities!
                    </div>
                </div>
            @endif
        </div>
        <div class="row mt-4">
            <div class="col-12 text-center">
                <a href="{{ route('jobs.index') }}" class="btn btn-primary px-4">View All Jobs</a>
            </div>
        </div>
    </div>

    <!-- Job Categories Section -->
    <div class="bg-light py-5">
        <div class="container">
            <div class="row mb-4">
                <div class="col-12">
                    <h2 class="fw-bold">Popular Job Categories</h2>
                    <p class="text-muted">Browse jobs by category</p>
                </div>
            </div>
            <div class="row g-4">
                <div class="col-md-3 col-sm-6">
                    <div class="bg-white rounded shadow-sm p-4 text-center h-100">
                        <div class="display-6 text-primary mb-3">
                            <i class="fas fa-laptop-code"></i>
                        </div>
                        <h5>Technology</h5>
                        <p class="text-muted small">Software development, IT, data science</p>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="bg-white rounded shadow-sm p-4 text-center h-100">
                        <div class="display-6 text-primary mb-3">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <h5>Finance</h5>
                        <p class="text-muted small">Accounting, banking, investment</p>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="bg-white rounded shadow-sm p-4 text-center h-100">
                        <div class="display-6 text-primary mb-3">
                            <i class="fas fa-stethoscope"></i>
                        </div>
                        <h5>Healthcare</h5>
                        <p class="text-muted small">Medical, nursing, pharmacy</p>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="bg-white rounded shadow-sm p-4 text-center h-100">
                        <div class="display-6 text-primary mb-3">
                            <i class="fas fa-bullhorn"></i>
                        </div>
                        <h5>Marketing</h5>
                        <p class="text-muted small">Digital marketing, PR, advertising</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Jobs Section -->
    <div class="container py-5">
        <div class="row mb-4">
            <div class="col-12">
                <h2 class="fw-bold">Recently Posted Jobs</h2>
                <p class="text-muted">The latest opportunities from top employers</p>
            </div>
        </div>
        <div class="row g-4">
            @if($recentJobs->count() > 0)
                @foreach($recentJobs as $job)
                    <div class="col-md-6">
                        <div class="card job-card shadow-sm h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    @if($job->is_featured)
                                        <span class="badge bg-primary">Featured</span>
                                    @else
                                        <span class="badge bg-secondary">New</span>
                                    @endif
                                    <small class="text-muted">Posted {{ $job->created_at->diffForHumans() }}</small>
                                </div>
                                <h5 class="card-title">{{ $job->title }}</h5>
                                <h6 class="card-subtitle mb-2 text-muted">{{ $job->organization->name }}</h6>
                                <div class="mb-3">
                                    <span class="badge bg-light text-dark me-1"><i class="fas fa-map-marker-alt me-1"></i>{{ $job->location }}</span>
                                    <span class="badge bg-light text-dark me-1"><i class="fas fa-clock me-1"></i>{{ ucfirst($job->employment_type) }}</span>
                                    @if($job->salary_range)
                                        <span class="badge bg-light text-dark"><i class="fas fa-money-bill-wave me-1"></i>{{ $job->salary_range }}</span>
                                    @endif
                                </div>
                                <p class="card-text">{{ Str::limit($job->description, 100) }}</p>
                            </div>
                            <div class="card-footer bg-white border-top-0">
                                <a href="{{ route('jobs.show', $job->id) }}" class="btn btn-sm btn-outline-primary">View Details</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="col-12">
                    <div class="alert alert-info">
                        No jobs available at the moment. Check back soon for new opportunities!
                    </div>
                </div>
            @endif
        </div>
        <div class="row mt-4">
            <div class="col-12 text-center">
                <a href="{{ route('jobs.index') }}" class="btn btn-primary px-4">Browse All Jobs</a>
            </div>
        </div>
    </div>

    <!-- CTA Section -->
    <div class="bg-primary text-white py-5">
        <div class="container py-3">
            <div class="row align-items-center">
                <div class="col-lg-8 mb-4 mb-lg-0">
                    <h2 class="fw-bold">Ready to advance your career?</h2>
                    <p class="lead mb-0">Join our platform to find your dream job or post vacancies for your organization.</p>
                </div>
                <div class="col-lg-4 text-lg-end">
                    <a href="{{ route('register') }}" class="btn btn-light btn-lg px-4">Get Started</a>
                </div>
            </div>
        </div>
    </div>
@endsection