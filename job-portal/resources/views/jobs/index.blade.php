@extends('layouts.master')

@section('title', 'Browse Jobs')

@section('page-header')
    <div class="row mb-4">
        <div class="col-12">
            <div class="bg-gradient-primary text-white p-4 rounded-lg shadow-sm position-relative overflow-hidden">
                <div class="position-absolute rounded-circle bg-white opacity-10" style="width: 200px; height: 200px; top: -100px; right: -50px;"></div>
                <div class="position-absolute rounded-circle bg-white opacity-10" style="width: 150px; height: 150px; bottom: -50px; left: 60px;"></div>
                <div class="position-relative z-index-1">
                    <h1 class="fw-bold mb-2">Browse Jobs</h1>
                    <p class="lead mb-0 opacity-75">Find the perfect opportunity that matches your skills and experience</p>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">        <!-- Search and Filters -->
        <div class="col-lg-3 mb-4">
            <div class="card shadow-sm rounded-lg">
                <div class="card-header bg-white border-bottom border-light">
                    <div class="d-flex align-items-center">
                        <span class="bg-primary bg-opacity-10 p-2 rounded-circle me-2">
                            <i class="fas fa-filter text-primary"></i>
                        </span>
                        <h5 class="mb-0 fw-semibold">Search & Filters</h5>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('jobs.index') }}" method="GET" id="jobFilterForm">
                        <!-- Keyword Search -->
                        <div class="mb-3">
                            <label for="keyword" class="form-label small fw-medium text-secondary">Keyword</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="fas fa-search text-primary"></i>
                                </span>
                                <input type="text" class="form-control border-start-0" id="keyword" name="keyword"
                                    placeholder="Job title, skills, or keywords" value="{{ request('keyword') }}">
                            </div>
                        </div>

                        <!-- Location Filter -->
                        <div class="mb-3">
                            <label for="location" class="form-label small fw-medium text-secondary">Location</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="fas fa-map-marker-alt text-primary"></i>
                                </span>
                                <input type="text" class="form-control border-start-0" id="location" name="location"
                                    placeholder="City, state, or remote" value="{{ request('location') }}">
                            </div>
                        </div>
                        
                        <!-- Employment Type Filter -->
                        <div class="mb-3">
                            <label for="employment_type" class="form-label small fw-medium text-secondary">Employment Type</label>
                            <select class="form-select" id="employment_type" name="employment_type">
                                <option value="">All Types</option>
                                @foreach ($employmentTypes as $type)
                                    <option value="{{ $type }}"
                                        {{ request('employment_type') == $type ? 'selected' : '' }}>
                                        {{ str_replace('_', ' ', ucfirst($type)) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Category Filter -->
                        <div class="mb-3">
                            <label for="category_id" class="form-label small fw-medium text-secondary">Job Category</label>
                            <select class="form-select" id="category_id" name="category_id">
                                <option value="">All Categories</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Salary Range Filter -->
                        <div class="mb-4">
                            <label class="form-label small fw-medium text-secondary">Salary Range</label>
                            <div class="row g-2">
                                <div class="col-6">
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0">$</span>
                                        <input type="number" class="form-control border-start-0" name="salary_min" placeholder="Min"
                                            value="{{ request('salary_min') }}">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0">$</span>
                                        <input type="number" class="form-control border-start-0" name="salary_max" placeholder="Max"
                                            value="{{ request('salary_max') }}">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary py-2">
                                <i class="fas fa-search me-2"></i>Search Jobs
                            </button>
                            <a href="{{ route('jobs.index') }}" class="btn btn-outline-secondary py-2">
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
                    @if (request('keyword') ||
                            request('location') ||
                            request('employment_type') ||
                            request('salary_min') ||
                            request('salary_max'))
                        <p class="text-muted">
                            Filtered results
                            @if (request('keyword'))
                                for "<strong>{{ request('keyword') }}</strong>"
                            @endif
                            @if (request('location'))
                                in "<strong>{{ request('location') }}</strong>"
                            @endif
                        </p>
                    @endif
                </div>
                <div>
                    <div class="btn-group">
                        <button type="button" class="btn btn-outline-primary dropdown-toggle" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            Sort By
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item"
                                    href="{{ request()->fullUrlWithQuery(['sort' => 'newest']) }}">Newest First</a></li>
                            <li><a class="dropdown-item"
                                    href="{{ request()->fullUrlWithQuery(['sort' => 'oldest']) }}">Oldest First</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            @if ($jobs->count() > 0)
                <div class="row g-4">
                    @foreach ($jobs as $job)
                        <div class="col-md-6">
                            <a href="{{ route('jobs.show', $job->id) }}" class="text-decoration-none">
                                <div class="card job-card shadow-sm h-100 hover-shadow transition-all rounded-lg">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center mb-3">                                            <span class="badge {{ $job->is_featured ? 'bg-primary' : 'bg-secondary' }} rounded-pill px-3 py-2">
                                                <i class="fas {{ $job->is_featured ? 'fa-star' : 'fa-certificate' }} me-1"></i>
                                                {{ $job->is_featured ? 'Featured' : 'New' }}
                                            </span>
                                            <small class="text-muted">Posted
                                                {{ $job->created_at->diffForHumans() }}</small>
                                        </div>
                                        <div class="d-flex align-items-center mb-3">
                                            <div class="flex-shrink-0 me-3">
                                                @if ($job->organization->logo)
                                                    <img src="{{ asset('uploads/' . $job->organization->logo) }}"
                                                        class="rounded-circle shadow-sm" width="45" height="45"
                                                        alt="{{ $job->organization->name }}">
                                                @else
                                                    <div class="rounded-circle bg-light d-flex align-items-center justify-content-center shadow-sm"
                                                        style="width: 45px; height: 45px;">
                                                        <i class="fas fa-building text-secondary"></i>
                                                    </div>
                                                @endif
                                            </div>
                                            <div>
                                                <h4 class="card-title mb-0">{{ $job->title }}</h4>
                                                <h6 class="card-subtitle text-muted mt-1">
                                                    {{ $job->organization->name ?? 'Organization' }}</h6>
                                            </div>
                                        </div>                                        <div class="mb-3">
                                            <span class="badge bg-light text-dark me-1 py-2 px-3 rounded-pill shadow-sm">
                                                <i class="fas fa-map-marker-alt me-1 text-primary"></i>{{ $job->location }}
                                            </span>
                                            <span class="badge bg-light text-dark me-1 py-2 px-3 rounded-pill shadow-sm">
                                                <i class="fas fa-clock me-1 text-primary"></i>{{ ucfirst($job->employment_type) }}
                                            </span>
                                            @if ($job->category)
                                                <span class="badge bg-light text-dark me-1 py-2 px-3 rounded-pill shadow-sm">
                                                    <i class="fas fa-tag me-1 text-primary"></i>{{ $job->category->name }}
                                                </span>
                                            @endif
                                            @if ($job->salary_min || $job->salary_max)
                                                <span class="badge bg-light text-dark py-2 px-3 rounded-pill shadow-sm">
                                                    <i class="fas fa-money-bill-wave me-1 text-primary"></i>
                                                    @if ($job->salary_min && $job->salary_max)
                                                        ${{ number_format($job->salary_min) }} -
                                                        ${{ number_format($job->salary_max) }}
                                                    @elseif($job->salary_min)
                                                        ${{ number_format($job->salary_min) }}+
                                                    @elseif($job->salary_max)
                                                        Up to ${{ number_format($job->salary_max) }}
                                                    @endif
                                                </span>
                                            @endif
                                        </div>
                                        <p class="card-text text-muted mt-2">{{ Str::limit($job->description, 120) }}</p>
                                    </div>                                    <div class="card-footer bg-white border-top-0">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="text-muted small">
                                                <i class="far fa-calendar-alt me-1 text-primary"></i>
                                                <span class="fw-bold">Deadline:</span>
                                                {{ $job->application_deadline ? \Carbon\Carbon::parse($job->application_deadline)->format('M d, Y') : 'No deadline set' }}
                                            </span>
                                            <span class="badge bg-light text-primary rounded-pill">
                                                <i class="fas fa-chevron-right"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </a>
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
