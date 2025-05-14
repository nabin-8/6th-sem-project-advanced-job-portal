@extends('layouts.master')

@section('title', $job->title)

@section('content')
    <!-- Job Header -->
    <div class="row mb-4">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('jobs.index') }}">Jobs</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ Str::limit($job->title, 40) }}</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row">
        <!-- Main Content -->
        <div class="col-lg-8">
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <!-- Job Title and Actions -->
                    <div class="d-flex justify-content-between align-items-start mb-4">
                        <div>
                            <h1 class="card-title h3 mb-2">{{ $job->title }}</h1>
                            <h6 class="card-subtitle text-muted mb-3">
                                <i class="fas fa-building me-2"></i>{{ $job->organization->name ?? 'Organization' }}
                            </h6>
                            <div class="mb-2">
                                <span class="badge bg-light text-dark me-2">
                                    <i class="fas fa-map-marker-alt me-1"></i>{{ $job->location }}
                                </span>
                                <span class="badge bg-light text-dark me-2">
                                    <i class="fas fa-clock me-1"></i>{{ ucfirst($job->employment_type) }}
                                </span>
                                @if($job->salary_min || $job->salary_max)
                                    <span class="badge bg-light text-dark me-2">
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
                                <span class="badge bg-light text-dark">
                                    <i class="far fa-calendar-alt me-1"></i>
                                    Posted {{ $job->created_at->format('M d, Y') }}
                                </span>
                            </div>
                        </div>
                        @auth
                            @if(auth()->user()->hasRole('Candidate') && session('active_role', 'Candidate') === 'Candidate')
                                @if(!$hasApplied)
                                    @if(auth()->user()->candidateProfile->is_complete)
                                        <form action="{{ route('jobs.apply', $job->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fas fa-paper-plane me-2"></i>Apply Now
                                            </button>
                                        </form>
                                    @else
                                        <a href="{{ route('profile.edit') }}" class="btn btn-warning">
                                            <i class="fas fa-user-edit me-2"></i>Complete Profile to Apply
                                        </a>
                                    @endif
                                @else
                                    <span class="badge bg-success p-2">
                                        <i class="fas fa-check-circle me-2"></i>Applied
                                    </span>
                                @endif
                            @endif
                        @else
                            <a href="{{ route('login') }}" class="btn btn-outline-primary">
                                <i class="fas fa-sign-in-alt me-2"></i>Login to Apply
                            </a>
                        @endauth
                    </div>

                    <!-- Job Description -->
                    <div class="mb-4">
                        <h4>Job Description</h4>
                        <div class="text-justify">
                            {!! nl2br(e($job->description)) !!}
                        </div>
                    </div>

                    <!-- Job Requirements -->
                    <div class="mb-4">
                        <h4>Requirements</h4>
                        <div class="text-justify">
                            {{-- {!! nl2br(e($job->requirements)) !!} --}}
                        </div>
                    </div>

                    <!-- Application Deadline -->                    <div class="alert alert-info d-flex align-items-center">
                        <i class="fas fa-hourglass-half me-3 fa-lg"></i>
                        <div>
                            <strong>Application Deadline:</strong> 
                            @if($job->application_deadline)
                                {{ \Carbon\Carbon::parse($job->application_deadline)->format('F d, Y') }}
                                ({{ \Carbon\Carbon::parse($job->application_deadline)->diffForHumans() }})
                            @else
                                No deadline set
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-white d-flex justify-content-between align-items-center">
                    <div>
                        <a href="{{ route('jobs.index') }}" class="btn btn-outline-secondary btn-sm">
                            <i class="fas fa-arrow-left me-2"></i>Back to Jobs
                        </a>
                    </div>
                    
                    <!-- Social Sharing -->
                    <div class="d-flex align-items-center">
                        <span class="me-2">Share:</span>
                        <a href="#" class="text-primary me-2" title="Share on Facebook">
                            <i class="fab fa-facebook-square fa-lg"></i>
                        </a>
                        <a href="#" class="text-info me-2" title="Share on Twitter">
                            <i class="fab fa-twitter-square fa-lg"></i>
                        </a>
                        <a href="#" class="text-primary me-2" title="Share on LinkedIn">
                            <i class="fab fa-linkedin fa-lg"></i>
                        </a>
                        <a href="#" class="text-success" title="Share via Email">
                            <i class="fas fa-envelope-square fa-lg"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Organization Information -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Organization Information</h5>
                </div>
                <div class="card-body">
                    <div class="text-center mb-3">
                        <div class="bg-light rounded-circle mx-auto mb-3" style="width: 80px; height: 80px; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-building fa-3x text-secondary"></i>
                        </div>
                        <h5>{{ $job->organization->name ?? 'Organization Name' }}</h5>
                    </div>
                    @if(isset($job->organization->description))
                        <p class="text-muted">{{ Str::limit($job->organization->description, 150) }}</p>
                    @endif
                    <hr>
                    <div class="mb-2">
                        <i class="fas fa-map-marker-alt text-secondary me-2"></i>
                        {{ $job->organization->location ?? 'Location not specified' }}
                    </div>
                    @if(isset($job->organization->website))
                        <div class="mb-2">
                            <i class="fas fa-globe text-secondary me-2"></i>
                            <a href="{{ $job->organization->website }}" target="_blank" rel="noopener noreferrer">
                                {{ $job->organization->website }}
                            </a>
                        </div>
                    @endif
                    <div class="mb-2">
                        <i class="fas fa-briefcase text-secondary me-2"></i>
                        {{ App\Models\Job::where('organization_id', $job->organization_id)->where('status', 'open')->count() }} open positions
                    </div>
                </div>
            </div>

            <!-- Related Jobs -->
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Related Jobs</h5>
                </div>
                <div class="card-body">
                    @if($relatedJobs->count() > 0)
                        <ul class="list-group list-group-flush">
                            @foreach($relatedJobs as $relatedJob)
                                <li class="list-group-item px-0">
                                    <h6 class="mb-1">
                                        <a href="{{ route('jobs.show', $relatedJob->id) }}" class="text-decoration-none">
                                            {{ $relatedJob->title }}
                                        </a>
                                    </h6>
                                    <p class="small text-muted mb-0">
                                        <i class="fas fa-building me-1"></i>{{ $relatedJob->organization->name ?? 'Organization' }} |
                                        <i class="fas fa-map-marker-alt me-1"></i>{{ $relatedJob->location }} |
                                        <i class="fas fa-clock me-1"></i>{{ ucfirst($relatedJob->employment_type) }}
                                    </p>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-muted text-center my-3">No related jobs found</p>
                    @endif
                </div>
                <div class="card-footer bg-white text-center">
                    <a href="{{ route('jobs.index') }}" class="btn btn-outline-primary btn-sm">
                        <i class="fas fa-search me-1"></i>Browse All Jobs
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection