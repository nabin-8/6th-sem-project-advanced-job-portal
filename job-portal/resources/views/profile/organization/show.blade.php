@extends('layouts.master')

@section('title', 'Organization Profile')

@section('page-header')
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="h3 mb-0 text-primary">Organization Profile</h1>
            <p class="text-muted">View your organization profile details</p>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <!-- Profile Overview -->
        <div class="col-lg-4">
            <div class="card shadow-sm mb-4">
                <div class="card-body text-center">
                    <div class="mb-3">
                        @if ($profile->logo)
                            <img src="{{ asset('storage/' . $profile->logo) }}" alt="{{ $profile->name }}" class="img-thumbnail" style="max-width: 150px; max-height: 150px;">
                        @else
                            <div class="bg-light rounded d-flex align-items-center justify-content-center mx-auto" style="width: 150px; height: 150px;">
                                <i class="fas fa-building fa-4x text-secondary"></i>
                            </div>
                        @endif
                    </div>
                    <h5 class="card-title">{{ $profile->name }}</h5>
                    <p class="text-muted mb-1">{{ $profile->industry ?? 'Industry not specified' }}</p>
                    <p class="mb-2">
                        <i class="fas fa-map-marker-alt me-1"></i>
                        {{ $profile->location ?? 'Location not specified' }}
                    </p>
                </div>
                <ul class="list-group list-group-flush">
                    @if($profile->founded_year)
                        <li class="list-group-item d-flex justify-content-between">
                            <span><i class="fas fa-calendar me-2"></i>Founded</span>
                            <span>{{ $profile->founded_year }}</span>
                        </li>
                    @endif
                    @if($profile->company_size)
                        <li class="list-group-item d-flex justify-content-between">
                            <span><i class="fas fa-users me-2"></i>Company Size</span>
                            <span>{{ $profile->company_size }}</span>
                        </li>
                    @endif
                    @if($profile->website)
                        <li class="list-group-item d-flex justify-content-between">
                            <span><i class="fas fa-globe me-2"></i>Website</span>
                            <a href="{{ $profile->website }}" target="_blank">Visit</a>
                        </li>
                    @endif
                    @if($profile->email)
                        <li class="list-group-item d-flex justify-content-between">
                            <span><i class="fas fa-envelope me-2"></i>Email</span>
                            <a href="mailto:{{ $profile->email }}">{{ $profile->email }}</a>
                        </li>
                    @endif
                    @if($profile->phone)
                        <li class="list-group-item d-flex justify-content-between">
                            <span><i class="fas fa-phone me-2"></i>Phone</span>
                            <span>{{ $profile->phone }}</span>
                        </li>
                    @endif
                </ul>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('profile.edit') }}" class="btn btn-primary">
                            <i class="fas fa-edit me-2"></i>Edit Profile
                        </a>
                        <a href="{{ route('jobs.manage') }}" class="btn btn-outline-primary">
                            <i class="fas fa-briefcase me-2"></i>Manage Jobs
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Profile Status -->
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Profile Status</h5>
                    
                    @if($profile->is_complete)
                        <div class="alert alert-success mb-0">
                            <i class="fas fa-check-circle me-2"></i>
                            Your profile is complete and visible to job seekers.
                        </div>
                    @else
                        <div class="alert alert-warning mb-3">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            Your profile is incomplete. Please complete your profile to improve visibility.
                        </div>
                        <a href="{{ route('profile.edit') }}" class="btn btn-warning btn-sm">
                            Complete Profile
                        </a>
                    @endif
                </div>
            </div>
        </div>
        
        <!-- Company Details -->
        <div class="col-lg-8">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0">About {{ $profile->name }}</h5>
                </div>
                <div class="card-body">
                    @if($profile->description)
                        <p>{{ $profile->description }}</p>
                    @else
                        <p class="text-muted">No company description provided.</p>
                    @endif
                </div>
            </div>
            
            <!-- Recent Job Postings -->
            <div class="card shadow-sm">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Recent Job Postings</h5>
                    <a href="{{ route('jobs.create') }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-plus me-1"></i>Post New Job
                    </a>
                </div>
                <div class="card-body">
                    @if(isset($recentJobs) && $recentJobs->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Job Title</th>
                                        <th>Location</th>
                                        <th>Type</th>
                                        <th>Posted</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentJobs as $job)
                                        <tr>
                                            <td>
                                                <a href="{{ route('jobs.show', $job->id) }}">{{ $job->title }}</a>
                                                @if($job->is_featured)
                                                    <span class="badge bg-primary ms-1">Featured</span>
                                                @endif
                                            </td>
                                            <td>{{ $job->location }}</td>
                                            <td>{{ ucfirst($job->employment_type) }}</td>
                                            <td>{{ $job->created_at->diffForHumans() }}</td>
                                            <td>
                                                <a href="{{ route('jobs.applications', $job->id) }}" class="btn btn-sm btn-outline-primary" title="View Applications">
                                                    <i class="fas fa-users"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-briefcase fa-3x text-muted mb-3"></i>
                            <h5>No Jobs Posted Yet</h5>
                            <p class="text-muted">Start posting jobs to attract qualified candidates.</p>
                            <a href="{{ route('jobs.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus me-1"></i>Post Your First Job
                            </a>
                        </div>
                    @endif
                </div>
                <div class="card-footer bg-white text-end">
                    <a href="{{ route('jobs.manage') }}" class="btn btn-link">View All Jobs</a>
                </div>
            </div>
        </div>
    </div>
@endsection