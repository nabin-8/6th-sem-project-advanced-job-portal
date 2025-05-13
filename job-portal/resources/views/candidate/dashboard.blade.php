@extends('layouts.master')

@section('title', 'Candidate Dashboard')

@section('page-header')
    <div class="row align-items-center mb-4">
        <div class="col">
            <h1 class="h3 mb-0 text-primary">Candidate Dashboard</h1>
            <p class="text-muted small">Welcome back, {{ $user->name }}</p>
        </div>
        <div class="col-auto">
            <span class="badge bg-primary">Candidate Account</span>
        </div>
    </div>
@endsection

@section('content')
    <!-- Profile Completion Alert -->
    @if($profileCompletionPercentage < 100)
        <div class="alert alert-warning alert-dismissible fade show mb-4" role="alert">
            <div class="d-md-flex align-items-center justify-content-between">
                <div class="mb-3 mb-md-0">
                    <h4 class="alert-heading h5">Complete Your Profile</h4>
                    <p class="mb-0">Your profile is {{ $profileCompletionPercentage }}% complete. Complete your profile to increase your chances of getting hired.</p>
                </div>
                <div>
                    <a href="{{ route('profile.edit') }}" class="btn btn-warning">
                        <i class="fas fa-user-edit me-2"></i>Complete Profile
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
                            <i class="fas fa-file-alt text-primary"></i>
                        </div>
                        <div>
                            <h6 class="card-title text-muted mb-0">Total Applications</h6>
                            <h2 class="mt-2 mb-0">{{ $totalApplications }}</h2>
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
                            <i class="fas fa-hourglass-half text-warning"></i>
                        </div>
                        <div>
                            <h6 class="card-title text-muted mb-0">Pending Applications</h6>
                            <h2 class="mt-2 mb-0">{{ $pendingApplications }}</h2>
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
                            <i class="fas fa-handshake text-success"></i>
                        </div>
                        <div>
                            <h6 class="card-title text-muted mb-0">Interviews</h6>
                            <h2 class="mt-2 mb-0">{{ $interviewApplications }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Profile Overview -->
        <div class="col-lg-4 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-white">
                    <div class="d-flex align-items-center justify-content-between">
                        <h5 class="card-title mb-0">Profile Overview</h5>
                        <a href="{{ route('profile.show') }}" class="btn btn-sm btn-outline-primary">View Profile</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="text-center mb-4">
                        <div class="bg-light rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 100px; height: 100px;">
                            <i class="fas fa-user-circle fa-4x text-primary"></i>
                        </div>
                        <h5>{{ $user->name }}</h5>
                        <p class="text-muted mb-2">{{ $candidateProfile->headline ?? 'Add a professional headline' }}</p>
                        <p class="mb-0"><i class="fas fa-map-marker-alt me-2"></i>{{ $candidateProfile->location ?? 'Add your location' }}</p>
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
                                <i class="fas fa-user-edit me-2"></i>Complete Your Profile
                            </a>
                        @else
                            <a href="{{ route('profile.edit') }}" class="btn btn-outline-primary">
                                <i class="fas fa-user-edit me-2"></i>Update Profile
                            </a>
                        @endif
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
                        <a href="{{ route('applications.index') }}" class="btn btn-sm btn-outline-primary">View All</a>
                    </div>
                </div>
                <div class="card-body p-0">
                    @if($recentApplications->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Job Title</th>
                                        <th>Company</th>
                                        <th>Status</th>
                                        <th>Applied Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentApplications as $application)
                                        <tr>
                                            <td>
                                                <a href="{{ route('applications.show', $application->id) }}" class="text-decoration-none">
                                                    {{ $application->job->title }}
                                                </a>
                                            </td>
                                            <td>{{ $application->job->organization->name ?? 'Organization' }}</td>
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
                                <i class="fas fa-file-alt fa-3x text-muted"></i>
                            </div>
                            <h5>No Applications Yet</h5>
                            <p class="text-muted">You haven't applied to any jobs yet.</p>
                            <a href="{{ route('jobs.index') }}" class="btn btn-primary">
                                <i class="fas fa-search me-2"></i>Browse Jobs
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Recommended Jobs -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="card-title mb-0">Recommended For You</h5>
                </div>
                <div class="card-body">
                    @if($recommendedJobs->count() > 0)
                        <div class="row g-4">
                            @foreach($recommendedJobs as $job)
                                <div class="col-md-6">
                                    <div class="card job-card shadow-sm h-100">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between">
                                                <span class="badge {{ $job->is_featured ? 'bg-primary' : 'bg-secondary' }}">
                                                    {{ $job->is_featured ? 'Featured' : 'New' }}
                                                </span>
                                                <small class="text-muted">Posted {{ $job->created_at->diffForHumans() }}</small>
                                            </div>
                                            <h5 class="card-title mt-3">{{ $job->title }}</h5>
                                            <h6 class="card-subtitle mb-2 text-muted">{{ $job->organization->name ?? 'Organization' }}</h6>
                                            <div class="mb-3">
                                                <span class="badge bg-light text-dark me-1"><i class="fas fa-map-marker-alt me-1"></i>{{ $job->location }}</span>
                                                <span class="badge bg-light text-dark"><i class="fas fa-clock me-1"></i>{{ ucfirst($job->employment_type) }}</span>
                                            </div>
                                            <p class="card-text small">{{ Str::limit($job->description, 100) }}</p>
                                        </div>
                                        <div class="card-footer bg-white border-top-0">
                                            <div class="d-grid">
                                                <a href="{{ route('jobs.show', $job->id) }}" class="btn btn-sm btn-outline-primary">View Details</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-4">
                            <div class="mb-3">
                                <i class="fas fa-search fa-3x text-muted"></i>
                            </div>
                            <h5>No Recommendations Yet</h5>
                            <p class="text-muted">Complete your profile to get personalized job recommendations.</p>
                            <a href="{{ route('profile.edit') }}" class="btn btn-primary">
                                <i class="fas fa-user-edit me-2"></i>Complete Profile
                            </a>
                        </div>
                    @endif
                </div>
                <div class="card-footer bg-white text-center">
                    <a href="{{ route('jobs.index') }}" class="btn btn-primary">Explore All Jobs</a>
                </div>
            </div>
        </div>
    </div>
@endsection