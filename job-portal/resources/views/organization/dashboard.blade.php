@extends('layouts.master')

@section('title', 'Organization Dashboard')

@section('page-header')
    <div class="row align-items-center mb-4">
        <div class="col">
            <h1 class="h3 mb-0 text-primary">Organization Dashboard</h1>
            <p class="text-muted small">Welcome back, {{ $organizationProfile->name }}</p>
        </div>
        <div class="col-auto">
            <span class="badge bg-secondary">Organization Account</span>
        </div>
    </div>
@endsection

@section('content')
    <!-- Profile Completion Alert -->
    @if($profileCompletionPercentage < 100)
        <div class="alert alert-warning alert-dismissible fade show mb-4" role="alert">
            <div class="d-md-flex align-items-center justify-content-between">
                <div class="mb-3 mb-md-0">
                    <h4 class="alert-heading h5">Complete Your Organization Profile</h4>
                    <p class="mb-0">Your organization profile is {{ $profileCompletionPercentage }}% complete. Complete your profile to attract more qualified candidates.</p>
                </div>
                <div>
                    <a href="{{ route('profile.edit') }}" class="btn btn-warning">
                        <i class="fas fa-building me-2"></i>Complete Profile
                    </a>
                </div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Stats Cards -->
    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100 dashboard-stats">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="stats-icon bg-light rounded-circle p-3 me-3">
                            <i class="fas fa-briefcase text-primary"></i>
                        </div>
                        <div>
                            <h6 class="card-title text-muted mb-0">Total Jobs Posted</h6>
                            <h2 class="mt-2 mb-0">{{ $totalJobs }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100 dashboard-stats">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="stats-icon bg-light rounded-circle p-3 me-3">
                            <i class="fas fa-bullhorn text-success"></i>
                        </div>
                        <div>
                            <h6 class="card-title text-muted mb-0">Active Jobs</h6>
                            <h2 class="mt-2 mb-0">{{ $activeJobs }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100 dashboard-stats">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="stats-icon bg-light rounded-circle p-3 me-3">
                            <i class="fas fa-users text-info"></i>
                        </div>
                        <div>
                            <h6 class="card-title text-muted mb-0">Total Applications</h6>
                            <h2 class="mt-2 mb-0">{{ $totalApplications }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Organization Profile Overview -->
        <div class="col-lg-4 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-white">
                    <div class="d-flex align-items-center justify-content-between">
                        <h5 class="card-title mb-0">Organization Overview</h5>
                        <a href="{{ route('profile.show') }}" class="btn btn-sm btn-outline-primary">View Profile</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="text-center mb-4">
                        <div class="bg-light rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 100px; height: 100px;">
                            @if($organizationProfile->logo)
                                <img src="{{ asset('storage/' . $organizationProfile->logo) }}" alt="{{ $organizationProfile->name }}" class="rounded-circle" style="width: 90px; height: 90px; object-fit: cover;">
                            @else
                                <i class="fas fa-building fa-4x text-secondary"></i>
                            @endif
                        </div>
                        <h5>{{ $organizationProfile->name }}</h5>
                        <p class="text-muted mb-2">{{ $organizationProfile->industry ?? 'Add your industry' }}</p>
                        <p class="mb-0"><i class="fas fa-map-marker-alt me-2"></i>{{ $organizationProfile->location ?? 'Add your location' }}</p>
                    </div>

                    <!-- Profile Completion -->
                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <span>Profile Completion</span>
                            <span class="text-primary">{{ $profileCompletionPercentage }}%</span>
                        </div>
                        <div class="progress" style="height: 10px;">
                            <div class="progress-bar bg-primary" role="progressbar" style="width: {{ $profileCompletionPercentage }}%" aria-valuenow="{{ $profileCompletionPercentage }}" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>

                    <div class="d-grid gap-2">
                        @if($profileCompletionPercentage < 100)
                            <a href="{{ route('profile.edit') }}" class="btn btn-outline-primary">
                                <i class="fas fa-building me-2"></i>Complete Organization Profile
                            </a>
                        @else
                            <a href="{{ route('profile.edit') }}" class="btn btn-outline-primary">
                                <i class="fas fa-edit me-2"></i>Update Organization Profile
                            </a>
                        @endif
                        <a href="{{ route('jobs.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus-circle me-2"></i>Post a New Job
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Applications -->
        <div class="col-lg-8 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-white">
                    <div class="d-flex align-items-center justify-content-between">
                        <h5 class="card-title mb-0">Recent Applications</h5>
                        <a href="{{ route('jobs.manage') }}" class="btn btn-sm btn-outline-primary">View All Jobs</a>
                    </div>
                </div>
                <div class="card-body p-0">
                    @if($recentApplications->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Candidate</th>
                                        <th>Job Title</th>
                                        <th>Status</th>
                                        <th>Applied Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentApplications as $application)
                                        <tr>
                                            <td>
                                                {{ $application->candidate->user->name }}
                                            </td>
                                            <td>
                                                <a href="{{ route('jobs.show', $application->job->id) }}" class="text-decoration-none">
                                                    {{ $application->job->title }}
                                                </a>
                                            </td>
                                            <td>
                                                @if($application->status == 'pending')
                                                    <span class="badge bg-warning">Pending</span>
                                                @elseif($application->status == 'reviewing')
                                                    <span class="badge bg-info">Reviewing</span>
                                                @elseif($application->status == 'interview')
                                                    <span class="badge bg-primary">Interview</span>
                                                @elseif($application->status == 'offered')
                                                    <span class="badge bg-success">Offered</span>
                                                @elseif($application->status == 'rejected')
                                                    <span class="badge bg-danger">Rejected</span>
                                                @else
                                                    <span class="badge bg-secondary">{{ ucfirst($application->status) }}</span>
                                                @endif
                                            </td>
                                            <td>{{ $application->created_at->format('M d, Y') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <div class="mb-3">
                                <i class="fas fa-users fa-3x text-muted"></i>
                            </div>
                            <h5>No Applications Yet</h5>
                            <p class="text-muted">You haven't received any applications yet.</p>
                            <a href="{{ route('jobs.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus-circle me-2"></i>Post a New Job
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Active Jobs Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <div class="d-flex align-items-center justify-content-between">
                        <h5 class="card-title mb-0">Active Job Listings</h5>
                        <a href="{{ route('jobs.create') }}" class="btn btn-sm btn-primary">
                            <i class="fas fa-plus-circle me-1"></i>Post New Job
                        </a>
                    </div>
                </div>
                <div class="card-body p-0">
                    @if($recentJobs->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Job Title</th>
                                        <th>Location</th>
                                        <th>Applications</th>
                                        <th>Status</th>
                                        <th>Expires</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentJobs as $job)
                                        <tr>
                                            <td>
                                                <a href="{{ route('jobs.show', $job->id) }}" class="text-decoration-none fw-bold">
                                                    {{ $job->title }}
                                                </a>
                                            </td>
                                            <td>{{ $job->location }}</td>
                                            <td>
                                                {{ $job->applications_count ?? 0 }}
                                                <a href="{{ route('jobs.applications', $job->id) }}" class="btn btn-sm btn-link p-0 ms-1">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </td>
                                            <td>
                                                @if($job->status == 'open')
                                                    <span class="badge bg-success">Open</span>
                                                @else
                                                    <span class="badge bg-secondary">Closed</span>
                                                @endif
                                            </td>
                                            <td>{{ \Carbon\Carbon::parse($job->application_deadline)->format('M d, Y') }}</td>
                                            <td>
                                                <div class="btn-group">
                                                    <a href="{{ route('jobs.edit', $job->id) }}" class="btn btn-sm btn-outline-primary">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form action="{{ route('jobs.toggle-status', $job->id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('PUT')
                                                        <button type="submit" class="btn btn-sm btn-outline-{{ $job->status == 'open' ? 'warning' : 'success' }}">
                                                            <i class="fas fa-{{ $job->status == 'open' ? 'pause' : 'play' }}"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <div class="mb-3">
                                <i class="fas fa-briefcase fa-3x text-muted"></i>
                            </div>
                            <h5>No Active Jobs</h5>
                            <p class="text-muted">You haven't posted any jobs yet.</p>
                            <a href="{{ route('jobs.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus-circle me-2"></i>Post Your First Job
                            </a>
                        </div>
                    @endif
                </div>
                @if($recentJobs->count() > 0)
                    <div class="card-footer bg-white text-center">
                        <a href="{{ route('jobs.manage') }}" class="btn btn-primary">Manage All Jobs</a>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection