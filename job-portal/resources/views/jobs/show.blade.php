@extends('layouts.master')

@section('title', $job->title)

@push('styles')
    <style>
        .job-header {
            background: linear-gradient(135deg, var(--secondary-color) 0%, var(--primary-color) 100%);
            border-radius: 10px;
            padding: 2rem;
            margin-bottom: 2rem;
            position: relative;
            overflow: hidden;
            box-shadow: var(--box-shadow);
        }
        
        .job-header::before {
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
        
        .job-header::after {
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

        .job-title {
            font-weight: 700;
            color: #fff;
            margin-bottom: 0.5rem;
            position: relative;
            z-index: 1;
        }

        .job-company {
            color: rgba(255, 255, 255, 0.9);
            font-weight: 500;
            margin-bottom: 1.5rem;
            position: relative;
            z-index: 1;
        }

        .job-meta {
            position: relative;
            z-index: 1;
        }

        .job-card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            overflow: hidden;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .job-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
        }

        .job-section-title {
            color: var(--secondary-color);
            font-weight: 600;
            margin-bottom: 1.5rem;
            padding-left: 1rem;
            border-left: 4px solid var(--primary-color);
        }

        .job-icon {
            width: 45px;
            height: 45px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
            margin-right: 1rem;
            flex-shrink: 0;
        }

        .job-company-logo {
            width: 120px;
            height: 120px;
            object-fit: contain;
            background: #fff;
            padding: 1rem;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .job-sidebar-card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            overflow: hidden;
            margin-bottom: 1.5rem;
        }

        .job-sidebar-card .card-header {
            background: #fff;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            padding: 1.25rem 1.5rem;
        }

        .job-sidebar-card .card-header h5 {
            margin: 0;
            color: var(--secondary-color);
            font-weight: 600;
        }

        .job-sidebar-card .card-footer {
            background: #fff;
            border-top: 1px solid rgba(0, 0, 0, 0.05);
            padding: 1.25rem 1.5rem;
        }

        .related-job-item {
            padding: 1rem;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            transition: background-color 0.2s;
        }

        .related-job-item:hover {
            background-color: rgba(0, 86, 179, 0.03);
        }

        .related-job-item:last-child {
            border-bottom: none;
        }

        .badge-info-outline {
            background-color: rgba(0, 86, 179, 0.1);
            color: var(--primary-color);
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 50px;
            font-weight: 500;
        }

        .share-btn {
            width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background-color: #f8f9fa;
            color: #6c757d;
            margin: 0 0.25rem;
            transition: all 0.2s;
        }

        .share-btn:hover {
            transform: translateY(-2px);
        }

        .share-btn-facebook:hover {
            background-color: #3b5998;
            color: white;
        }

        .share-btn-twitter:hover {
            background-color: #1da1f2;
            color: white;
        }

        .share-btn-linkedin:hover {
            background-color: #0077b5;
            color: white;
        }

        .share-btn-email:hover {
            background-color: #28a745;
            color: white;
        }

        .job-action-btn {
            padding: 0.75rem 2rem;
            border-radius: 50px;
            font-weight: 500;
        }
    </style>
@endpush

@section('content')
    <!-- Job Header -->
    <div class="job-header text-white mb-4">
        <div class="container position-relative" style="z-index: 1;">
            <div class="d-flex align-items-center mb-2">
                @if ($job->is_featured)
                    <span class="badge bg-warning px-3 py-2 me-2">
                        <i class="fas fa-star me-1"></i> Featured
                    </span>
                @endif
                <span class="badge badge-info-outline bg-white text-primary px-3 py-2">
                    <i class="far fa-calendar-alt me-1"></i>
                    Posted {{ $job->created_at->format('M d, Y') }}
                </span>
            </div>
            
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h1 class="job-title">{{ $job->title }}</h1>
                    <h5 class="job-company d-flex align-items-center">
                        <i class="fas fa-building me-2"></i>
                        {{ $job->organization->name ?? 'Organization' }}
                    </h5>
                    
                    <div class="job-meta d-flex flex-wrap gap-2 mb-4">
                        <span class="badge bg-white text-dark py-2 px-3">
                            <i class="fas fa-map-marker-alt text-primary me-1"></i>
                            {{ $job->location }}
                        </span>
                        <span class="badge bg-white text-dark py-2 px-3">
                            <i class="fas fa-clock text-primary me-1"></i>
                            {{ ucfirst(str_replace('_', ' ', $job->employment_type)) }}
                        </span>
                        @if ($job->category)
                            <span class="badge bg-white text-dark py-2 px-3">
                                <i class="fas fa-tag text-primary me-1"></i>
                                {{ $job->category->name }}
                            </span>
                        @endif
                        @if ($job->salary_min || $job->salary_max)
                            <span class="badge bg-white text-dark py-2 px-3">
                                <i class="fas fa-money-bill-wave text-primary me-1"></i>
                                @if ($job->salary_min && $job->salary_max)
                                    ${{ number_format($job->salary_min) }} - ${{ number_format($job->salary_max) }}
                                @elseif($job->salary_min)
                                    ${{ number_format($job->salary_min) }}+
                                @elseif($job->salary_max)
                                    Up to ${{ number_format($job->salary_max) }}
                                @endif
                            </span>
                        @endif
                    </div>
                    
                    @auth
                        @if (auth()->user()->hasRole('Candidate') && session('active_role', 'Candidate') === 'Candidate')
                            @if (!$hasApplied)
                                @if (auth()->user()->candidateProfile->is_complete)
                                    <form action="{{ route('jobs.apply', $job->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-light job-action-btn shadow-sm">
                                            <i class="fas fa-paper-plane me-2"></i>Apply Now
                                        </button>
                                    </form>
                                @else
                                    <a href="{{ route('profile.edit') }}" class="btn btn-warning job-action-btn shadow-sm">
                                        <i class="fas fa-user-edit me-2"></i>Complete Profile to Apply
                                    </a>
                                @endif
                            @else
                                <span class="badge bg-success px-4 py-3 rounded-pill shadow-sm">
                                    <i class="fas fa-check-circle me-2"></i>Applied
                                </span>
                            @endif
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="btn btn-light job-action-btn shadow-sm">
                            <i class="fas fa-sign-in-alt me-2"></i>Login to Apply
                        </a>
                    @endauth
                </div>
                <div class="col-lg-4 d-none d-lg-flex justify-content-end">
                    <div class="text-center">
                        @if ($job->organization->logo)
                            <img src="{{ asset('uploads/' . $job->organization->logo) }}"
                                alt="{{ $job->organization->name }}" class="job-company-logo">
                        @else
                            <div class="job-company-logo d-flex align-items-center justify-content-center">
                                <i class="fas fa-building fa-3x text-secondary"></i>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container mb-5">
        <div class="row">
            <!-- Main Content -->
            <div class="col-lg-8">
                <!-- Navigation breadcrumb -->
                <nav aria-label="breadcrumb" class="mb-4">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('home') }}" class="text-decoration-none">
                                <i class="fas fa-home text-primary me-1"></i> Home
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('jobs.index') }}" class="text-decoration-none">
                                <i class="fas fa-briefcase text-primary me-1"></i> Jobs
                            </a>
                        </li>
                        <li class="breadcrumb-item active fw-bold" aria-current="page">
                            {{ Str::limit($job->title, 40) }}
                        </li>
                    </ol>
                </nav>

                <!-- Job Description -->
                <div class="job-card mb-4">
                    <div class="card-body p-4">
                        <h4 class="job-section-title">
                            <i class="fas fa-align-left text-primary me-2"></i>
                            Job Description
                        </h4>
                        <div class="mb-4">
                            {!! nl2br(e($job->description)) !!}
                        </div>                        <h4 class="job-section-title mt-5">
                            <i class="fas fa-clipboard-list text-primary me-2"></i>
                            Requirements
                        </h4>
                        <ul class="list-group list-group-flush bg-transparent ps-0">
                            @foreach ($job->requirements as $requirement)
                                @if(!empty(trim($requirement)))
                                <li class="list-group-item bg-transparent ps-0 d-flex py-2">
                                    <i class="fas fa-check-circle text-primary me-2 mt-1"></i>
                                    <span>{{ trim($requirement) }}</span>
                                </li>
                                @endif
                            @endforeach
                        </ul>
                        
                        <div class="alert alert-info mt-5 d-flex align-items-center">
                            <div class="bg-primary rounded-circle p-3 me-3 text-white">
                                <i class="fas fa-hourglass-half fa-lg"></i>
                            </div>
                            <div>
                                <h5 class="mb-1">Application Deadline</h5>
                                <p class="mb-0 fw-bold">
                                    @if ($job->application_deadline)
                                        {{ \Carbon\Carbon::parse($job->application_deadline)->format('F d, Y') }}
                                        <span class="badge bg-info text-white ms-2">
                                            {{ \Carbon\Carbon::parse($job->application_deadline)->diffForHumans() }}
                                        </span>
                                    @else
                                        No deadline set
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-white d-flex justify-content-between align-items-center py-3 px-4">
                        <a href="{{ route('jobs.index') }}" class="btn btn-outline-primary rounded-pill px-3">
                            <i class="fas fa-arrow-left me-2"></i>Back to Jobs
                        </a>

                        <!-- Social Sharing -->
                        <div class="d-flex align-items-center">
                            <span class="me-2 text-muted">Share:</span>
                            <div class="d-flex">
                                <a href="#" class="share-btn share-btn-facebook" title="Share on Facebook">
                                    <i class="fab fa-facebook"></i>
                                </a>
                                <a href="#" class="share-btn share-btn-twitter" title="Share on Twitter">
                                    <i class="fab fa-twitter"></i>
                                </a>
                                <a href="#" class="share-btn share-btn-linkedin" title="Share on LinkedIn">
                                    <i class="fab fa-linkedin"></i>
                                </a>
                                <a href="#" class="share-btn share-btn-email" title="Share via Email">
                                    <i class="fas fa-envelope"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Organization Information -->
                <div class="job-sidebar-card">
                    <div class="card-header">
                        <h5>
                            <i class="fas fa-building text-primary me-2"></i>
                            Company Information
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-4">
                            <div class="me-3">
                                @if ($job->organization->logo)
                                    <img src="{{ asset('uploads/' . $job->organization->logo) }}"
                                        alt="{{ $job->organization->name }}"
                                        class="rounded-circle border" style="width: 60px; height: 60px; object-fit: contain;">
                                @else
                                    <div class="bg-light rounded-circle d-flex align-items-center justify-content-center"
                                        style="width: 60px; height: 60px;">
                                        <i class="fas fa-building fa-2x text-secondary"></i>
                                    </div>
                                @endif
                            </div>
                            <div>
                                @auth
                                    <a href="{{ route('organization.profile', ['id' => $job->organization->id]) }}" class="text-decoration-none text-primary fw-bold">
                                        {{ $job->organization->name }}
                                    </a>
                                @else
                                    <h6 class="mb-0 fw-bold">{{ $job->organization->name ?? 'Organization Name' }}</h6>
                                @endauth
                                <span class="text-muted small">{{ $job->organization->industry ?? 'Industry' }}</span>
                            </div>
                        </div>
                        
                        @if (isset($job->organization->description))
                            <p class="text-muted small mb-4">{{ Str::limit($job->organization->description, 150) }}</p>
                        @endif
                        
                        <div class="d-flex align-items-center mb-3">
                            <div class="job-icon bg-light">
                                <i class="fas fa-map-marker-alt text-primary"></i>
                            </div>
                            <div>
                                <span class="text-muted small d-block">Location</span>
                                <p class="mb-0 fw-medium">{{ $job->organization->location ?? 'Location not specified' }}</p>
                            </div>
                        </div>
                        
                        @if (isset($job->organization->website))
                            <div class="d-flex align-items-center mb-3">
                                <div class="job-icon bg-light">
                                    <i class="fas fa-globe text-primary"></i>
                                </div>
                                <div>
                                    <span class="text-muted small d-block">Website</span>
                                    <a href="{{ $job->organization->website }}" target="_blank"
                                        rel="noopener noreferrer" class="text-primary fw-medium">
                                        {{ parse_url($job->organization->website, PHP_URL_HOST) }}
                                    </a>
                                </div>
                            </div>
                        @endif
                        
                        <div class="d-flex align-items-center">
                            <div class="job-icon bg-light">
                                <i class="fas fa-briefcase text-primary"></i>
                            </div>
                            <div>
                                <span class="text-muted small d-block">Open Positions</span>
                                <p class="mb-0 fw-bold">
                                    {{ App\Models\Job::where('organization_id', $job->organization_id)->where('status', 'open')->count() }}
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-center">
                        <a href="{{ route('organization.profile', ['id' => $job->organization->id]) }}" class="btn btn-outline-primary rounded-pill">
                            <i class="fas fa-building me-2"></i>View Company Profile
                        </a>
                    </div>
                </div>
                
                <!-- Related Jobs -->
                <div class="job-sidebar-card">
                    <div class="card-header">
                        <h5>
                            <i class="fas fa-briefcase text-primary me-2"></i>
                            Similar Jobs
                        </h5>
                    </div>
                    <div class="card-body p-0">
                        @if ($relatedJobs->count() > 0)
                            <div class="list-group list-group-flush">
                                @foreach ($relatedJobs as $relatedJob)
                                    <a href="{{ route('jobs.show', $relatedJob->id) }}" 
                                       class="list-group-item list-group-item-action related-job-item">
                                        <div class="d-flex align-items-center mb-2">
                                            @if ($relatedJob->organization->logo)
                                                <img src="{{ asset('uploads/' . $relatedJob->organization->logo) }}"
                                                    class="rounded-circle me-2" width="36" height="36"
                                                    alt="{{ $relatedJob->organization->name }}">
                                            @else
                                                <div class="rounded-circle bg-light d-flex align-items-center justify-content-center me-2"
                                                    style="width: 36px; height: 36px;">
                                                    <i class="fas fa-building text-secondary"></i>
                                                </div>
                                            @endif
                                            <div>
                                                <h6 class="mb-0">{{ $relatedJob->title }}</h6>
                                                <span class="small text-muted">{{ $relatedJob->organization->name }}</span>
                                            </div>
                                        </div>
                                        <div class="d-flex flex-wrap gap-1 mt-2">
                                            <span class="badge bg-light text-dark small">
                                                <i class="fas fa-map-marker-alt text-primary me-1"></i>
                                                {{ $relatedJob->location }}
                                            </span>
                                            <span class="badge bg-light text-dark small">
                                                <i class="fas fa-clock text-primary me-1"></i>
                                                {{ ucfirst(str_replace('_', ' ', $relatedJob->employment_type)) }}
                                            </span>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-5">
                                <div class="bg-light rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center"
                                    style="width: 80px; height: 80px;">
                                    <i class="fas fa-search text-secondary fa-2x"></i>
                                </div>
                                <p class="text-muted mb-0">No similar jobs found</p>
                            </div>
                        @endif
                    </div>
                    <div class="card-footer text-center">
                        <a href="{{ route('jobs.index') }}" class="btn btn-primary rounded-pill">
                            <i class="fas fa-search me-2"></i>Browse All Jobs
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
