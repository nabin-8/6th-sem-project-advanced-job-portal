@extends('layouts.master')

@section('title', $profile->name)

@section('page-header')
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="h3 mb-0 text-primary">{{ $profile->name }}</h1>
            <p class="text-muted">{{ $profile->industry ?? 'Organization' }}</p>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <!-- Organization Overview -->
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
            </div>
            
            <!-- Social Media Links -->
            @if($profile->linkedin || $profile->twitter)
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">Connect With Us</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex gap-2">
                            @if($profile->linkedin)
                                <a href="{{ $profile->linkedin }}" target="_blank" class="btn btn-outline-primary">
                                    <i class="fab fa-linkedin me-1"></i> LinkedIn
                                </a>
                            @endif
                            
                            @if($profile->twitter)
                                <a href="{{ $profile->twitter }}" target="_blank" class="btn btn-outline-info">
                                    <i class="fab fa-twitter me-1"></i> Twitter
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            @endif
        </div>
        
        <!-- Organization Details -->
        <div class="col-lg-8">
            <!-- About -->
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
            
            <!-- Mission & Values -->
            @if($profile->mission)
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">Mission & Values</h5>
                    </div>
                    <div class="card-body">
                        <p>{{ $profile->mission }}</p>
                    </div>
                </div>
            @endif
            
            <!-- Benefits -->
            @if($profile->benefits)
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">Employee Benefits</h5>
                    </div>
                    <div class="card-body">
                        <p>{{ $profile->benefits }}</p>
                    </div>
                </div>
            @endif
            
            <!-- Open Positions -->
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Open Positions</h5>
                </div>
                <div class="card-body">
                    @if(isset($profile->jobs) && $profile->jobs->count() > 0)
                        <div class="row g-4">
                            @foreach($profile->jobs as $job)
                                <div class="col-md-6">
                                    <div class="card job-card h-100">
                                        <div class="card-body">
                                            <h5 class="card-title">{{ $job->title }}</h5>
                                            <p class="card-text text-muted mb-3">
                                                <i class="fas fa-map-marker-alt me-1"></i>{{ $job->location }} &bull;
                                                <i class="fas fa-briefcase me-1"></i>{{ ucfirst($job->employment_type) }}
                                            </p>
                                            <p class="card-text">{{ Str::limit($job->description, 100) }}</p>
                                        </div>
                                        <div class="card-footer bg-white border-top-0">
                                            <a href="{{ route('jobs.show', $job->id) }}" class="btn btn-sm btn-outline-primary">View Details</a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                        <div class="text-center mt-4">
                            <a href="{{ route('jobs.index') }}?organization={{ $profile->id }}" class="btn btn-primary">
                                View All Positions
                            </a>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-briefcase fa-3x text-muted mb-3"></i>
                            <h5>No Open Positions</h5>
                            <p class="text-muted">This organization doesn't have any open positions at the moment.</p>
                            <a href="{{ route('jobs.index') }}" class="btn btn-primary">Browse All Jobs</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection