@extends('layouts.master')

@section('title', 'Browse Jobs')

@section('page-header')
    <div class="row mb-4">
        <div class="col-12 text-center">
            <h1 class="display-5 fw-bold text-primary">Browse Jobs</h1>
            <p class="lead">Find the perfect opportunity that matches your skills and experience</p>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <!-- Search and Filters -->
        <div class="col-lg-3 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Search & Filters</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('jobs.index') }}" method="GET">
                        <!-- Keyword Search -->
                        <div class="mb-3">
                            <label for="keyword" class="form-label">Keyword</label>
                            <input type="text" class="form-control" id="keyword" name="keyword" placeholder="Job title, skills, or keywords" value="{{ request('keyword') }}">
                        </div>
                        
                        <!-- Location Filter -->
                        <div class="mb-3">
                            <label for="location" class="form-label">Location</label>
                            <input type="text" class="form-control" id="location" name="location" placeholder="City, state, or remote" value="{{ request('location') }}">
                        </div>
                        
                        <!-- Employment Type Filter -->
                        <div class="mb-3">
                            <label for="employment_type" class="form-label">Employment Type</label>
                            <select class="form-select" id="employment_type" name="employment_type">
                                <option value="">All Types</option>
                                @foreach($employmentTypes as $type)
                                    <option value="{{ $type }}" {{ request('employment_type') == $type ? 'selected' : '' }}>
                                        {{ ucfirst($type) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <!-- Salary Range Filter -->
                        <div class="mb-3">
                            <label class="form-label">Salary Range</label>
                            <div class="row g-2">
                                <div class="col-6">
                                    <input type="number" class="form-control" name="salary_min" placeholder="Min" value="{{ request('salary_min') }}">
                                </div>
                                <div class="col-6">
                                    <input type="number" class="form-control" name="salary_max" placeholder="Max" value="{{ request('salary_max') }}">
                                </div>
                            </div>
                        </div>
                        
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search me-2"></i>Search
                            </button>
                            <a href="{{ route('jobs.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-redo me-2"></i>Reset Filters
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Job Listings -->
        <div class="col-lg-9">
            <!-- Search Summary -->
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <h3>{{ $jobs->total() }} {{ Str::plural('Job', $jobs->total()) }} Found</h3>
                    @if(request('keyword') || request('location') || request('employment_type') || request('salary_min') || request('salary_max'))
                        <p class="text-muted">
                            Filtered results 
                            @if(request('keyword'))
                                for "<strong>{{ request('keyword') }}</strong>"
                            @endif
                            @if(request('location'))
                                in "<strong>{{ request('location') }}</strong>"
                            @endif
                        </p>
                    @endif
                </div>
                <div>
                    <div class="btn-group">
                        <button type="button" class="btn btn-outline-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                            Sort By
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['sort' => 'newest']) }}">Newest First</a></li>
                            <li><a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['sort' => 'oldest']) }}">Oldest First</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            
            @if($jobs->count() > 0)
                <div class="row g-4">
                    @foreach($jobs as $job)
                        <div class="col-md-6">
                            <div class="card job-card shadow-sm h-100">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <span class="badge {{ $job->is_featured ? 'bg-primary' : 'bg-secondary' }}">
                                            {{ $job->is_featured ? 'Featured' : 'New' }}
                                        </span>
                                        <small class="text-muted">Posted {{ $job->created_at->diffForHumans() }}</small>
                                    </div>
                                    <h4 class="card-title">{{ $job->title }}</h4>
                                    <h6 class="card-subtitle mb-2 text-muted">{{ $job->organization->name ?? 'Organization' }}</h6>
                                    <div class="mb-3">
                                        <span class="badge bg-light text-dark me-1">
                                            <i class="fas fa-map-marker-alt me-1"></i>{{ $job->location }}
                                        </span>
                                        <span class="badge bg-light text-dark me-1">
                                            <i class="fas fa-clock me-1"></i>{{ ucfirst($job->employment_type) }}
                                        </span>
                                        @if($job->salary_min || $job->salary_max)
                                            <span class="badge bg-light text-dark">
                                                <i class="fas fa-money-bill-wave me-1"></i>
                                                @if($job->salary_min && $job->salary_max)
                                                    ${{ number_format($job->salary_min) }} - ${{ number_format($job->salary_max) }}
                                                @elseif($job->salary_min)
                                                    ${{ number_format($job->salary_min) }}+
                                                @elseif($job->salary_max)
                                                    Up to ${{ number_format($job->salary_max) }}
                                                @endif
                                            </span>
                                        @endif
                                    </div>
                                    <p class="card-text">{{ Str::limit($job->description, 150) }}</p>
                                </div>
                                <div class="card-footer bg-white border-top-0">
                                    <div class="d-flex justify-content-between align-items-center">                                        <span class="text-muted small">
                                            <i class="far fa-calendar-alt me-1"></i>
                                            Deadline: {{ $job->application_deadline ? \Carbon\Carbon::parse($job->application_deadline)->format('M d, Y') : 'No deadline set' }}
                                        </span>
                                        <a href="{{ route('jobs.show', $job->id) }}" class="btn btn-outline-primary btn-sm">
                                            View Details
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <!-- Pagination -->
                <div class="mt-4 d-flex justify-content-center">
                    {{ $jobs->links() }}
                </div>
            @else
                <div class="card shadow-sm">
                    <div class="card-body text-center py-5">
                        <i class="fas fa-search fa-3x text-muted mb-3"></i>
                        <h4>No jobs found</h4>
                        <p class="text-muted">We couldn't find any jobs matching your search criteria.</p>
                        <a href="{{ route('jobs.index') }}" class="btn btn-outline-primary">Clear Filters</a>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection