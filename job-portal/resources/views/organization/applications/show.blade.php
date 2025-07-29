@extends('layouts.master')

@section('title', 'Application Details')

@section('page-header')
    <div class="row mb-4">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('organization.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('jobs.manage') }}">Manage Jobs</a></li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('jobs.applications', $job->id) }}">Applications for "{{ $job->title }}"</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $application->candidate->user->name }}</li>
                </ol>
            </nav>
            <h1 class="h3 mb-0 text-primary">Application Details</h1>
            <p class="text-muted">Review candidate application and manage status</p>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-4">
            <!-- Candidate Profile -->
            <div class="card shadow-sm mb-4">
                <div class="card-body text-center">
                    @if(isset($application->candidate->user->profile_photo))
                        <a href="{{ route('candidate.profile', $application->candidate->id) }}">
                            <img src="{{ asset('uploads/' . $application->candidate->user->profile_photo) }}" alt="Profile" 
                                class="rounded-circle img-thumbnail mb-3" style="width: 120px; height: 120px; object-fit: cover;">
                        </a>
                    @else
                        <div class="rounded-circle bg-light d-flex align-items-center justify-content-center mx-auto mb-3"
                             style="width: 120px; height: 120px;">
                            <i class="fas fa-user fa-3x text-secondary"></i>
                        </div>
                    @endif
                    <a href="{{ route('candidate.profile', $application->candidate->id) }}">
                        <h5 class="mb-1">{{ $application->candidate->user->name }}</h5>
                    </a>
                    <p class="text-muted mb-2">{{ $application->candidate->headline ?? 'Candidate' }}</p>
                    
                    <div class="d-flex justify-content-center gap-2 mb-3">
                        @if($application->candidate->linkedin_url)
                            <a href="{{ $application->candidate->linkedin_url }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                <i class="fab fa-linkedin"></i> LinkedIn
                            </a>
                        @endif
                        @if($application->candidate->portfolio_url)
                            <a href="{{ $application->candidate->portfolio_url }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-globe"></i> Portfolio
                            </a>
                        @endif
                    </div>
                    
                    <hr>
                    
                    <div class="text-start">
                        <p class="mb-2">
                            <i class="fas fa-envelope me-2 text-muted"></i> 
                            <a href="mailto:{{ $application->candidate->user->email }}">{{ $application->candidate->user->email }}</a>
                        </p>
                        @if($application->candidate->phone)
                            <p class="mb-2">
                                <i class="fas fa-phone me-2 text-muted"></i> 
                                <a href="tel:{{ $application->candidate->phone }}">{{ $application->candidate->phone }}</a>
                            </p>
                        @endif
                        @if($application->candidate->location)
                            <p class="mb-2">
                                <i class="fas fa-map-marker-alt me-2 text-muted"></i>
                                {{ $application->candidate->location }}
                            </p>
                        @endif
                        @if($application->candidate->experience)
                            <p class="mb-2">
                                <i class="fas fa-briefcase me-2 text-muted"></i>
                                {{ $application->candidate->experience }} years experience
                            </p>
                        @endif
                        @if($application->candidate->education_level)
                            <p class="mb-2">
                                <i class="fas fa-graduation-cap me-2 text-muted"></i>
                                {{ $application->candidate->education_level }}
                            </p>
                        @endif
                    </div>
                </div>
            </div>
            
            <!-- Skills -->
            @if($application->candidate->skills)
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-white">
                        <h5 class="card-title mb-0">Skills</h5>
                    </div>
                    <div class="card-body">
                        @foreach(explode(',', $application->candidate->skills) as $skill)
                            <span class="badge bg-light text-dark mb-2 me-1 py-2 px-3">{{ trim($skill) }}</span>
                        @endforeach
                    </div>
                </div>
            @endif
            
            <!-- Application Status -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white">
                    <h5 class="card-title mb-0">Application Status</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <p class="mb-1 fw-bold">Current Status</p>
                        <span class="badge p-2
                            @if($application->status == 'pending')
                                bg-warning
                            @elseif($application->status == 'reviewing')
                                bg-info
                            @elseif($application->status == 'interview')
                                bg-primary
                            @elseif($application->status == 'offered')
                                bg-success
                            @elseif($application->status == 'rejected')
                                bg-danger
                            @elseif($application->status == 'withdrawn')
                                bg-secondary
                            @endif">
                            {{ ucfirst($application->status) }}
                        </span>
                    </div>
                    
                    <form action="{{ route('jobs.applications.update-status', [$job->id, $application->id]) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label for="status" class="form-label">Update Status</label>                            <select class="form-select" id="status" name="status">
                                <option value="pending" {{ $application->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="reviewing" {{ $application->status == 'reviewing' ? 'selected' : '' }}>Reviewing</option>
                                <option value="interview" {{ $application->status == 'interview' ? 'selected' : '' }}>Interview</option>
                                <option value="offered" {{ $application->status == 'offered' ? 'selected' : '' }}>Offered</option>
                                <option value="rejected" {{ $application->status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                {{-- <option value="withdrawn" {{ $application->status == 'withdrawn' ? 'selected' : '' }}>Withdrawn</option> --}}
                            </select>
                        </div>
                          <div class="mb-3">
                            <label for="notes" class="form-label">Internal Notes (not visible to candidate)</label>
                            <textarea class="form-control" id="notes" name="notes" rows="3">{{ $application->admin_notes }}</textarea>
                        </div>
                        
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i> Update
                        </button>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-md-8">
            <!-- Cover Letter -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white">
                    <h5 class="card-title mb-0">Cover Letter</h5>
                </div>
                <div class="card-body">
                    @if($application->cover_letter)
                        <div class="cover-letter-content">
                            {!! nl2br(e($application->cover_letter)) !!}
                        </div>
                    @else
                        <p class="text-muted">No cover letter provided.</p>
                    @endif
                </div>
            </div>
              <!-- Resume -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white d-flex align-items-center justify-content-between">
                    <h5 class="card-title mb-0">Resume</h5>
                    @if($application->candidate->resume ?? $application->candidate->resume_path)
                        <a href="{{ asset('uploads/' . ($application->candidate->resume ?? $application->candidate->resume_path)) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                            <i class="fas fa-download me-1"></i> Download Resume
                        </a>
                    @endif
                </div>
                <div class="card-body">
                    @if($application->candidate->resume ?? $application->candidate->resume_path)
                        <div class="embed-responsive">
                            <iframe src="{{ asset('uploads/' . ($application->candidate->resume ?? $application->candidate->resume_path)) }}" width="100%" height="600px"></iframe>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-file-alt fa-3x mb-3 text-muted"></i>
                            <p>No resume file was uploaded.</p>
                        </div>
                    @endif
                </div>
            </div>
            
            <!-- Candidate Experience -->
            @if($application->candidate->experiences && count(json_decode($application->candidate->experiences)))
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-white">
                        <h5 class="card-title mb-0">Work Experience</h5>
                    </div>
                    <div class="card-body">
                        @foreach(json_decode($application->candidate->experiences) as $experience)
                            <div class="mb-4">
                                <div class="d-flex justify-content-between mb-1">
                                    <h6 class="mb-1">{{ $experience->title }} at {{ $experience->company }}</h6>
                                    <span class="text-muted small">
                                        {{ $experience->start_date }} - {{ $experience->end_date ?? 'Present' }}
                                    </span>
                                </div>
                                <p class="text-muted small mb-2">{{ $experience->location }}</p>
                                <p>{{ $experience->description }}</p>
                            </div>
                            @if(!$loop->last)
                                <hr>
                            @endif
                        @endforeach
                    </div>
                </div>
            @endif
            
            <!-- Candidate Education -->
            @if($application->candidate->educations && count(json_decode($application->candidate->educations)))
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-white">
                        <h5 class="card-title mb-0">Education</h5>
                    </div>
                    <div class="card-body">
                        @foreach(json_decode($application->candidate->educations) as $education)
                            <div class="mb-4">
                                <div class="d-flex justify-content-between mb-1">
                                    <h6 class="mb-1">{{ $education->degree }} - {{ $education->field_of_study }}</h6>
                                    <span class="text-muted small">
                                        {{ $education->start_year }} - {{ $education->end_year ?? 'Present' }}
                                    </span>
                                </div>
                                <p class="text-muted small mb-2">{{ $education->school }}</p>
                                @if(isset($education->description))
                                    <p>{{ $education->description }}</p>
                                @endif
                            </div>
                            @if(!$loop->last)
                                <hr>
                            @endif
                        @endforeach
                    </div>
                </div>
            @endif
            
            <!-- Send Message -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white">
                    <h5 class="card-title mb-0">Contact Candidate</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('jobs.applications.send-message', [$job->id, $application->id]) }}" method="POST">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="subject" class="form-label">Subject</label>
                            <input type="text" class="form-control" id="subject" name="subject" 
                                placeholder="e.g., Follow-up on your application for {{ $job->title }}">
                        </div>
                        
                        <div class="mb-3">
                            <label for="message" class="form-label">Message</label>
                            <textarea class="form-control" id="message" name="message" rows="4" 
                                placeholder="Type your message to the candidate..."></textarea>
                        </div>
                        
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-paper-plane me-1"></i> Send Message
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection