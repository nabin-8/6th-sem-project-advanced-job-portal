@extends('layouts.master')

@section('title', 'My Profile')

@section('page-header')
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="                                         <a href="{{ asset('uploads/' . $profile->resume) }}" target="_blank" class="btn btn-sm btn-outline-primary me-2">
                                        <i class="fas fa-eye me-1"></i> View Resume
                                    </a>
                                    <a href="{{ asset('uploads/' . $profile->resume) }}" download class="btn btn-sm btn-outline-success">
                                        <i class="fas fa-download me-1"></i> Download Resume
                                    </a>                         <a href="{{ asset('uploads/' . $profile->resume) }}" target="_blank" class="btn btn-sm btn-outline-primary me-2">
                                        <i class="fas fa-eye me-1"></i> View Resume
                                    </a>
                                    <a href="{{ asset('uploads/' . $profile->resume) }}" download class="btn btn-sm btn-outline-success">
                                        <i class="fas fa-download me-1"></i> Download Resume
                                    </a>0 text-primary">My Profile</h1>
            <p class="text-muted">View and manage your candidate profile</p>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <!-- Profile Overview -->
        <div class="col-lg-4">
            <div class="card shadow-sm mb-4">
                <div class="card-body text-center">                    <div class="mb-3">
                        @if ($user->profile_photo)
                            <img src="{{ asset('uploads/' . $user->profile_photo) }}" alt="Profile" class="rounded-circle img-thumbnail" style="width: 150px; height: 150px; object-fit: cover;">
                        @else
                            <div class="bg-light rounded-circle d-flex align-items-center justify-content-center mx-auto" style="width: 150px; height: 150px;">
                                <i class="fas fa-user fa-4x text-secondary"></i>
                            </div>
                        @endif
                    </div>
                    <h5 class="card-title">{{ $user->name }}</h5>
                    <p class="text-muted mb-1">{{ $profile->headline ?? 'No headline set' }}</p>
                    <p class="mb-2">
                        <i class="fas fa-map-marker-alt me-1"></i>
                        {{ $profile->location ?? 'No location set' }}
                    </p>
                </div>
                <ul class="list-group list-group-flush">
                    @if($profile->phone)
                        <li class="list-group-item d-flex justify-content-between">
                            <span><i class="fas fa-phone me-2"></i>Phone</span>
                            <span>{{ $profile->phone }}</span>
                        </li>
                    @endif
                    <li class="list-group-item d-flex justify-content-between">
                        <span><i class="fas fa-envelope me-2"></i>Email</span>
                        <span>{{ $user->email }}</span>
                    </li>
                    @if($profile->website)
                        <li class="list-group-item d-flex justify-content-between">
                            <span><i class="fas fa-globe me-2"></i>Website</span>
                            <a href="{{ $profile->website }}" target="_blank">Visit</a>
                        </li>
                    @endif
                    @if($profile->linkedin)
                        <li class="list-group-item d-flex justify-content-between">
                            <span><i class="fab fa-linkedin me-2"></i>LinkedIn</span>
                            <a href="{{ $profile->linkedin }}" target="_blank">View</a>
                        </li>
                    @endif
                </ul>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('profile.edit') }}" class="btn btn-primary">
                            <i class="fas fa-edit me-2"></i>Edit Profile
                        </a>
                        <a href="{{ route('applications.index') }}" class="btn btn-outline-primary">
                            <i class="fas fa-file-alt me-2"></i>My Applications
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
                            Your profile is complete and ready for job applications.
                        </div>
                    @else
                        <div class="alert alert-warning mb-3">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            Your profile is incomplete. Complete your profile to apply for jobs.
                        </div>
                        <a href="{{ route('profile.edit') }}" class="btn btn-warning btn-sm">
                            Complete Profile
                        </a>
                    @endif
                </div>
            </div>
        </div>
        
        <!-- Profile Details -->
        <div class="col-lg-8">
            <!-- About Me -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0">About Me</h5>
                </div>
                <div class="card-body">
                    @if($profile->bio)
                        <p>{{ $profile->bio }}</p>
                    @else
                        <p class="text-muted">No bio information provided.</p>
                    @endif
                </div>
            </div>
            
            <!-- Skills -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Skills</h5>
                </div>
                <div class="card-body">
                    @if($profile->skills)
                        <div class="d-flex flex-wrap gap-2">
                            @foreach(explode(',', $profile->skills) as $skill)
                                <span class="badge bg-light text-dark border">{{ trim($skill) }}</span>
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted">No skills listed.</p>
                    @endif
                </div>
            </div>
            
            <!-- Experience -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Work Experience</h5>
                </div>
                <div class="card-body">
                    @if($profile->experience)
                        <div class="mb-0">
                            {!! nl2br(e($profile->experience)) !!}
                        </div>
                    @else
                        <p class="text-muted">No work experience listed.</p>
                    @endif
                </div>
            </div>
            
            <!-- Education -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Education</h5>
                </div>
                <div class="card-body">
                    @if($profile->education)
                        <div class="mb-0">
                            {!! nl2br(e($profile->education)) !!}
                        </div>
                    @else
                        <p class="text-muted">No education information listed.</p>
                    @endif
                </div>
            </div>
            
            <!-- Resume -->
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Resume</h5>
                </div>
                <div class="card-body">
                    @if($profile->resume)
                        <div class="d-flex align-items-center">
                            <i class="fas fa-file-pdf fa-2x text-danger me-3"></i>
                            <div>
                                <h6 class="mb-1">Resume</h6>
                                <div class="d-flex">                                    <a href="{{ asset('uploads/' . $profile->resume) }}" target="_blank" class="btn btn-sm btn-outline-primary me-2">
                                        <i class="fas fa-eye me-1"></i>View
                                    </a>
                                    <a href="{{ asset('uploads/' . $profile->resume) }}" download class="btn btn-sm btn-outline-success">
                                        <i class="fas fa-download me-1"></i>Download
                                    </a>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-file-upload fa-3x text-muted mb-3"></i>
                            <h5>No Resume Uploaded</h5>
                            <p class="text-muted">Upload your resume to apply for jobs.</p>
                            <a href="{{ route('profile.edit') }}" class="btn btn-primary">
                                <i class="fas fa-upload me-1"></i>Upload Resume
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection