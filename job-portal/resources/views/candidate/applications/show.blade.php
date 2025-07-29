@extends('layouts.master')

@section('title', 'Application Details')

@section('page-header')
    <div class="row mb-4">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('candidate.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('applications.index') }}">My Applications</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Application Details</li>
                </ol>
            </nav>
            <h1 class="h3 mb-0 text-primary">Application Details</h1>
            <p class="text-muted">View details about your job application</p>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-8">
            <!-- Application Status -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white">
                    <h5 class="card-title mb-0">Application Status</h5>
                </div>
                <div class="card-body">
                    <div class="application-timeline">
                        <div class="d-flex flex-column flex-md-row justify-content-between mb-3">
                            <div class="timeline-step">
                                <div class="timeline-step-icon {{ in_array($application->status, ['pending', 'reviewing', 'interview', 'offered']) ? 'active' : '' }}">
                                    <i class="fas fa-paper-plane"></i>
                                </div>
                                <div class="timeline-step-label">
                                    <h6>Applied</h6>
                                    <p class="text-muted mb-0 small">{{ $application->created_at->format('M d, Y') }}</p>
                                </div>
                            </div>
                            <div class="timeline-step">
                                <div class="timeline-step-icon {{ in_array($application->status, ['reviewing', 'interview', 'offered']) ? 'active' : '' }}">
                                    <i class="fas fa-search"></i>
                                </div>
                                <div class="timeline-step-label">
                                    <h6>Under Review</h6>
                                    <p class="text-muted mb-0 small">{{ $application->status == 'pending' ? 'Pending' : 'In Progress' }}</p>
                                </div>
                            </div>
                            <div class="timeline-step">
                                <div class="timeline-step-icon {{ in_array($application->status, ['interview', 'offered']) ? 'active' : '' }}">
                                    <i class="fas fa-user-tie"></i>
                                </div>
                                <div class="timeline-step-label">
                                    <h6>Interview</h6>
                                    <p class="text-muted mb-0 small">{{ $application->status == 'interview' ? 'Scheduled' : 'Not Yet' }}</p>
                                </div>
                            </div>
                            <div class="timeline-step">
                                <div class="timeline-step-icon {{ $application->status == 'offered' ? 'active' : '' }}">
                                    <i class="fas fa-check-circle"></i>
                                </div>
                                <div class="timeline-step-label">
                                    <h6>Decision</h6>
                                    <p class="text-muted mb-0 small">
                                        @if($application->status == 'offered')
                                            Job Offered
                                        @elseif($application->status == 'rejected')
                                            Not Selected
                                        @else
                                            Pending
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Current Status -->
                        <div class="text-center p-3 rounded 
                            @if($application->status == 'pending')
                                bg-warning bg-opacity-10 border border-warning
                            @elseif($application->status == 'reviewing')
                                bg-info bg-opacity-10 border border-info
                            @elseif($application->status == 'interview')
                                bg-primary bg-opacity-10 border border-primary
                            @elseif($application->status == 'offered')
                                bg-success bg-opacity-10 border border-success
                            @elseif($application->status == 'rejected')
                                bg-danger bg-opacity-10 border border-danger
                            @elseif($application->status == 'withdrawn')
                                bg-secondary bg-opacity-10 border border-secondary
                            @endif">
                            <h5 class="mb-0">
                                Current Status: 
                                @if($application->status == 'pending')
                                    <span class="text-warning">Pending Review</span>
                                @elseif($application->status == 'reviewing')
                                    <span class="text-info">Under Review</span>
                                @elseif($application->status == 'interview')
                                    <span class="text-primary">Interview Stage</span>
                                @elseif($application->status == 'offered')
                                    <span class="text-success">Job Offered</span>
                                @elseif($application->status == 'rejected')
                                    <span class="text-danger">Not Selected</span>
                                @elseif($application->status == 'withdrawn')
                                    <span class="text-secondary">Application Withdrawn</span>
                                @endif
                            </h5>
                            <p class="text-muted mb-0 mt-2">
                                @if($application->status == 'pending')
                                    Your application has been received and is waiting to be reviewed by the employer.
                                @elseif($application->status == 'reviewing')
                                    Your application is currently being reviewed by the hiring team.
                                @elseif($application->status == 'interview')
                                    Congratulations! You've been selected for an interview. The employer should contact you soon with details.
                                @elseif($application->status == 'offered')
                                    Congratulations! You've been offered this position. The employer will contact you with next steps.
                                @elseif($application->status == 'rejected')
                                    Thank you for your interest, but the employer has decided to pursue other candidates.
                                @elseif($application->status == 'withdrawn')
                                    You have withdrawn this application on {{ $application->updated_at->format('M d, Y') }}.
                                @endif
                            </p>
                        </div>
                        
                        @if(in_array($application->status, ['pending', 'reviewing', 'interview']))
                            <div class="mt-3 text-center">
                                <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#withdrawModal">
                                    <i class="fas fa-times-circle me-2"></i>Withdraw Application
                                </button>
                                
                                <!-- Withdraw Application Modal -->
                                <div class="modal fade" id="withdrawModal" tabindex="-1" aria-labelledby="withdrawModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="withdrawModalLabel">Withdraw Application</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p>Are you sure you want to withdraw your application for <strong>{{ $application->job->title }}</strong>?</p>
                                                <p class="text-danger">This action cannot be undone.</p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>                                                <form action="{{ route('applications.withdraw', $application->id) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="btn btn-danger">Withdraw Application</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            
            <!-- Job Details -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Job Details</h5>
                    <a href="{{ route('jobs.show', $application->job->id) }}" class="btn btn-sm btn-outline-primary" target="_blank">
                        <i class="fas fa-external-link-alt me-1"></i>View Job
                    </a>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <h4>{{ $application->job->title }}</h4>
                        <h6 class="text-muted">{{ $application->job->organization->name ?? 'Organization' }}</h6>
                        <div class="mb-3">
                            <span class="badge bg-light text-dark me-2">
                                <i class="fas fa-map-marker-alt me-1"></i>{{ $application->job->location }}
                            </span>
                            <span class="badge bg-light text-dark me-2">
                                <i class="fas fa-clock me-1"></i>{{ ucfirst($application->job->employment_type) }}
                            </span>
                            @if($application->job->salary_min || $application->job->salary_max)
                                <span class="badge bg-light text-dark">
                                    <i class="fas fa-money-bill-wave me-1"></i>
                                    @if($application->job->salary_min && $application->job->salary_max)
                                        ${{ number_format($application->job->salary_min) }} - ${{ number_format($application->job->salary_max) }}
                                    @elseif($application->job->salary_min)
                                        ${{ number_format($application->job->salary_min) }}+
                                    @elseif($application->job->salary_max)
                                        Up to ${{ number_format($application->job->salary_max) }}
                                    @endif
                                </span>
                            @endif
                        </div>
                        
                        <div class="mb-3">
                            <h6>Job Description</h6>
                            <div class="text-justify">
                                {!! nl2br(e(Str::limit($application->job->description, 300))) !!}
                                @if(strlen($application->job->description) > 300)
                                    <a href="{{ route('jobs.show', $application->job->id) }}" target="_blank">Read more</a>
                                @endif
                            </div>
                        </div>
                        
                        <div>
                            <h6>Application Deadline</h6>
                            <p class="mb-0">
                                <i class="far fa-calendar-alt me-1"></i>
                                {{ \Carbon\Carbon::parse($application->job->application_deadline)->format('F d, Y') }}
                                @if(\Carbon\Carbon::parse($application->job->application_deadline)->isPast())
                                    <span class="badge bg-danger ms-2">Expired</span>
                                @elseif(\Carbon\Carbon::parse($application->job->application_deadline)->diffInDays() < 7)
                                    <span class="badge bg-warning ms-2">Closing Soon</span>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Your Application -->
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="card-title mb-0">Your Application</h5>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <h6>Application Date</h6>
                        <p><i class="far fa-calendar-alt me-2"></i>{{ $application->created_at->format('F d, Y') }}</p>
                    </div>
                    
                    @if($application->cover_letter)
                        <div class="mb-4">
                            <h6>Cover Letter</h6>
                            <div class="border rounded p-3 bg-light">
                                {!! nl2br(e($application->cover_letter)) !!}
                            </div>
                        </div>
                    @endif
                    
                    <div>
                        <h6>Resume</h6>
                        <p>
                            <i class="far fa-file-pdf me-2"></i>
                            Your current resume was sent with this application.
                            @if(auth()->user()->candidateProfile->resume)
                                <a href="{{ asset('uploads/' . auth()->user()->candidateProfile->resume) }}" target="_blank" class="ms-2">View Resume</a>
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            <!-- Application Summary -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white">
                    <h5 class="card-title mb-0">Application Summary</h5>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item px-0 d-flex justify-content-between">
                            <span class="text-muted">Application ID:</span>
                            <span>#{{ $application->id }}</span>
                        </li>
                        <li class="list-group-item px-0 d-flex justify-content-between">
                            <span class="text-muted">Status:</span>
                            <span>
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
                                @elseif($application->status == 'withdrawn')
                                    <span class="badge bg-secondary">Withdrawn</span>
                                @else
                                    <span class="badge bg-secondary">{{ ucfirst($application->status) }}</span>
                                @endif
                            </span>
                        </li>
                        <li class="list-group-item px-0 d-flex justify-content-between">
                            <span class="text-muted">Applied On:</span>
                            <span>{{ $application->created_at->format('M d, Y') }}</span>
                        </li>
                        <li class="list-group-item px-0 d-flex justify-content-between">
                            <span class="text-muted">Last Updated:</span>
                            <span>{{ $application->updated_at->format('M d, Y') }}</span>
                        </li>
                    </ul>
                </div>
            </div>
            
            <!-- Company Information -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white">
                    <h5 class="card-title mb-0">Company Information</h5>
                </div>
                <div class="card-body">
                    <div class="text-center mb-3">
                        <div class="bg-light rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                            @if(isset($application->job->organization->logo))
                                <img src="{{ asset('uploads/' . $application->job->organization->logo) }}" alt="{{ $application->job->organization->name }}" class="rounded-circle" style="width: 70px; height: 70px; object-fit: cover;">
                            @else
                                <i class="fas fa-building fa-3x text-secondary"></i>
                            @endif
                        </div>
                        <h5 class="mb-1">{{ $application->job->organization->name ?? 'Organization' }}</h5>
                        <p class="text-muted small">{{ $application->job->organization->industry ?? '' }}</p>
                    </div>
                    
                    <hr>
                    
                    @if(isset($application->job->organization->description))
                        <div class="mb-3">
                            <h6>About</h6>
                            <p class="small">{{ Str::limit($application->job->organization->description, 150) }}</p>
                        </div>
                    @endif
                    
                    <div>
                        <div class="d-flex align-items-center mb-2">
                            <i class="fas fa-map-marker-alt text-muted me-2"></i>
                            <span>{{ $application->job->organization->location ?? 'Location not specified' }}</span>
                        </div>
                        
                        @if(isset($application->job->organization->website))
                            <div class="d-flex align-items-center mb-2">
                                <i class="fas fa-globe text-muted me-2"></i>
                                <a href="{{ $application->job->organization->website }}" target="_blank" rel="noopener noreferrer">
                                    {{ $application->job->organization->website }}
                                </a>
                            </div>
                        @endif
                        
                        <div class="d-flex align-items-center">
                            <i class="fas fa-briefcase text-muted me-2"></i>
                            <span>{{ App\Models\Job::where('organization_id', $application->job->organization_id)->where('status', 'open')->count() }} open positions</span>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-white text-center">
                    <a href="{{ route('jobs.index', ['organization_id' => $application->job->organization_id]) }}" class="btn btn-sm btn-outline-primary">
                        <i class="fas fa-search me-1"></i>View All Jobs
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
<style>
    .application-timeline {
        position: relative;
    }
    
    .timeline-step {
        text-align: center;
        position: relative;
        margin-bottom: 20px;
    }
    
    .timeline-step-icon {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background-color: #e9ecef;
        color: #6c757d;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 10px;
        font-size: 20px;
        border: 2px solid transparent;
    }
    
    .timeline-step-icon.active {
        background-color: #e8f4ff;
        color: #0d6efd;
        border-color: #0d6efd;
    }
    
    @media (min-width: 768px) {
        .timeline-step {
            margin-bottom: 0;
        }
        
        .application-timeline:before {
            content: '';
            position: absolute;
            width: 75%;
            height: 3px;
            background-color: #e9ecef;
            top: 25px;
            left: 12.5%;
            z-index: 0;
        }
    }
</style>
@endpush