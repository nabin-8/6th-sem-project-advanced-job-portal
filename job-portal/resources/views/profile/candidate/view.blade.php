@extends('layouts.master')

@section('title', $profile->user->name . ' - Profile')

@push('styles')
    <style>
        .profile-header {
            background: linear-gradient(135deg, var(--secondary-color) 0%, var(--primary-color) 100%);
            padding: 3rem 0;
            margin-bottom: 2rem;
            position: relative;
            overflow: hidden;
        }
        
        .profile-header::before {
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
        
        .profile-header::after {
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
        
        .profile-photo {
            width: 150px;
            height: 150px;
            object-fit: cover;
            border: 4px solid #fff;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        
        .profile-card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            overflow: hidden;
            /* height: 100%; */
        }
        
        .profile-card .card-header {
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            padding: 1rem 1.5rem;
            background: #fff;
        }
        
        .profile-card .card-header h5 {
            margin: 0;
            font-weight: 600;
            color: var(--secondary-color);
        }
        
        .profile-card .card-body {
            padding: 1.5rem;
        }
        
        .profile-sidebar {
            border-radius: 10px;
            overflow: hidden;
        }
        
        .profile-info-list {
            border-radius: 10px;
            overflow: hidden;
        }
        
        .profile-info-list .list-group-item {
            padding: 1rem 1.5rem;
            border-color: rgba(0, 0, 0, 0.05);
        }
        
        .skill-badge {
            background-color: rgba(0, 86, 179, 0.1);
            color: var(--primary-color);
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 50px;
            margin: 0.25rem;
            font-weight: 500;
        }
        
        .contact-icon {
            width: 40px;
            height: 40px;
            background-color: rgba(0, 86, 179, 0.1);
            color: var(--primary-color);
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            margin-right: 1rem;
        }
    </style>
@endpush

@section('content')
    <!-- Profile Header -->
    <div class="profile-header text-white">
        <div class="container position-relative" style="z-index: 1;">
            <div class="d-flex flex-column flex-md-row align-items-md-center">
                <div class="me-md-4 mb-3 mb-md-0 text-center text-md-start">
                    @if ($profile->user->profile_photo)
                        <img src="{{ asset('uploads/' . $profile->user->profile_photo) }}" alt="{{ $profile->user->name }}" class="profile-photo rounded-circle">
                    @else
                        <div class="profile-photo rounded-circle bg-white d-flex align-items-center justify-content-center">
                            <i class="fas fa-user fa-3x text-secondary"></i>
                        </div>
                    @endif
                </div>
                <div>
                    <h1 class="h2 mb-2">{{ $profile->user->name }}</h1>
                    <p class="lead mb-2">{{ $profile->headline ?? 'Candidate' }}</p>
                    <div class="d-flex align-items-center">
                        <i class="fas fa-map-marker-alt me-2"></i>
                        <span>{{ $profile->location ?? 'Location not specified' }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container mb-5">
        <div class="row">
            <div class="col-lg-4">
                <!-- Contact Information -->
                <div class="profile-card mb-4">
                    <div class="card-header">
                        <h5><i class="fas fa-address-card me-2 text-primary"></i>Contact Information</h5>
                    </div>
                    <div class="card-body p-0">
                        <ul class="list-group profile-info-list">
                            <li class="list-group-item d-flex align-items-center">
                                <div class="contact-icon">
                                    <i class="fas fa-envelope"></i>
                                </div>
                                <div>
                                    <small class="text-muted d-block">Email</small>
                                    <span>{{ $profile->user->email }}</span>
                                </div>
                            </li>
                            
                            @if($profile->phone)
                            <li class="list-group-item d-flex align-items-center">
                                <div class="contact-icon">
                                    <i class="fas fa-phone"></i>
                                </div>
                                <div>
                                    <small class="text-muted d-block">Phone</small>
                                    <span>{{ $profile->phone }}</span>
                                </div>
                            </li>
                            @endif
                            
                            @if($profile->website)
                            <li class="list-group-item d-flex align-items-center">
                                <div class="contact-icon">
                                    <i class="fas fa-globe"></i>
                                </div>
                                <div>
                                    <small class="text-muted d-block">Website</small>
                                    <a href="{{ $profile->website }}" target="_blank" class="text-primary">Visit website</a>
                                </div>
                            </li>
                            @endif
                        </ul>
                    </div>
                </div>
                
                <!-- Social Profiles -->
                @if($profile->linkedin)
                <div class="profile-card mb-4">
                    <div class="card-header">
                        <h5><i class="fas fa-share-alt me-2 text-primary"></i>Social Profiles</h5>
                    </div>
                    <div class="card-body">
                        <a href="{{ $profile->linkedin }}" target="_blank" class="btn btn-outline-primary d-flex align-items-center justify-content-center mb-2">
                            <i class="fab fa-linkedin me-2"></i> LinkedIn Profile
                        </a>
                    </div>
                </div>
                @endif
                
                @auth
                    @if(auth()->user()->hasRole('Organization') && session('active_role') === 'Organization')
                        <div class="d-grid">
                            <button class="btn btn-primary rounded-pill py-2" onclick="window.history.back()">
                                <i class="fas fa-arrow-left me-2"></i>Back to Applications
                            </button>
                        </div>
                    @endif
                @endauth
            </div>
            
            <div class="col-lg-8">
                <!-- About Me -->
                <div class="profile-card mb-4">
                    <div class="card-header">
                        <h5><i class="fas fa-user me-2 text-primary"></i>About Me</h5>
                    </div>
                    <div class="card-body">
                        @if($profile->bio)
                            <p class="mb-0">{{ $profile->bio }}</p>
                        @else
                            <p class="text-muted mb-0">No bio information provided.</p>
                        @endif
                    </div>
                </div>
                
                <!-- Skills -->
                <div class="profile-card mb-4">
                    <div class="card-header">
                        <h5><i class="fas fa-tools me-2 text-primary"></i>Skills</h5>
                    </div>
                    <div class="card-body">
                        @if($profile->skills)
                            <div class="d-flex flex-wrap">
                                @foreach(explode(',', $profile->skills) as $skill)
                                    <span class="skill-badge">{{ trim($skill) }}</span>
                                @endforeach
                            </div>
                        @else
                            <p class="text-muted mb-0">No skills listed.</p>
                        @endif
                    </div>
                </div>
                
                <!-- Experience -->
                <div class="profile-card mb-4">
                    <div class="card-header">
                        <h5><i class="fas fa-briefcase me-2 text-primary"></i>Work Experience</h5>
                    </div>
                    <div class="card-body">
                        @if($profile->experience)
                            <div class="mb-0">
                                {!! nl2br(e($profile->experience)) !!}
                            </div>
                        @else
                            <p class="text-muted mb-0">No work experience listed.</p>
                        @endif
                    </div>
                </div>
                
                <!-- Education -->
                <div class="profile-card">
                    <div class="card-header">
                        <h5><i class="fas fa-graduation-cap me-2 text-primary"></i>Education</h5>
                    </div>
                    <div class="card-body">
                        @if($profile->education)
                            <div class="mb-0">
                                {!! nl2br(e($profile->education)) !!}
                            </div>
                        @else
                            <p class="text-muted mb-0">No education information listed.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
