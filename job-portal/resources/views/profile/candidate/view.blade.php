@extends('layouts.master')

@section('title', $profile->user->name . ' - Profile')

@section('content')
    <div class="row mb-4">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Candidate Profile</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row">
        <!-- Profile Overview -->
        <div class="col-lg-4">
            <div class="card shadow-sm mb-4">
                <div class="card-body text-center">
                    <div class="mb-3">
                        @if ($profile->user->profile_photo)
                            <img src="{{ asset('storage/' . $profile->user->profile_photo) }}" alt="Profile" class="rounded-circle img-thumbnail" style="width: 150px; height: 150px; object-fit: cover;">
                        @else
                            <div class="bg-light rounded-circle d-flex align-items-center justify-content-center mx-auto" style="width: 150px; height: 150px;">
                                <i class="fas fa-user fa-4x text-secondary"></i>
                            </div>
                        @endif
                    </div>
                    <h5 class="card-title">{{ $profile->user->name }}</h5>
                    <p class="text-muted mb-1">{{ $profile->headline ?? 'Candidate' }}</p>
                    <p class="mb-2">
                        <i class="fas fa-map-marker-alt me-1"></i>
                        {{ $profile->location ?? 'Location not specified' }}
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
                        <span>{{ $profile->user->email }}</span>
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
                
                @auth
                    @if(auth()->user()->hasRole('Organization') && session('active_role') === 'Organization')
                        <div class="card-body">
                            <div class="d-grid">
                                <button class="btn btn-primary" onclick="window.history.back()">
                                    <i class="fas fa-arrow-left me-2"></i>Back to Applications
                                </button>
                            </div>
                        </div>
                    @endif
                @endauth
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
        </div>
    </div>
@endsection
