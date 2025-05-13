@extends('layouts.master')

@section('title', 'Edit Profile')

@section('page-header')
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="h3 mb-0 text-primary">Edit Your Profile</h1>
            <p class="text-muted">Complete your profile to increase your chances of finding the perfect job</p>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-3">
            <!-- Profile completion card -->
            <div class="card mb-4 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Profile Completion</h5>
                    
                    @php
                        $completionFields = ['headline', 'bio', 'location', 'phone', 'skills', 'resume'];
                        $completedFields = 0;
                        
                        foreach ($completionFields as $field) {
                            if (!empty($profile->$field)) {
                                $completedFields++;
                            }
                        }
                        
                        $completionPercentage = ($completionPercentage = round(($completedFields / count($completionFields)) * 100)) > 100 ? 100 : $completionPercentage;
                        
                        // Determine color based on completion percentage
                        if ($completionPercentage < 40) {
                            $progressColor = 'danger';
                        } elseif ($completionPercentage < 70) {
                            $progressColor = 'warning';
                        } elseif ($completionPercentage < 100) {
                            $progressColor = 'info';
                        } else {
                            $progressColor = 'success';
                        }
                    @endphp
                    
                    <div class="d-flex justify-content-between mb-1">
                        <span>Progress</span>
                        <span>{{ $completionPercentage }}%</span>
                    </div>
                    <div class="progress mb-4" style="height: 10px;">
                        <div class="progress-bar bg-{{ $progressColor }}" role="progressbar" style="width: {{ $completionPercentage }}%" 
                            aria-valuenow="{{ $completionPercentage }}" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    
                    <div class="profile-completion-tasks">
                        <h6 class="text-muted font-weight-normal mb-3">Complete these items:</h6>
                        <ul class="list-unstyled">
                            @foreach ($completionFields as $field)
                                <li class="mb-2 d-flex align-items-center">
                                    @if (!empty($profile->$field))
                                        <i class="fas fa-check-circle text-success me-2"></i>
                                        <span class="text-muted"><s>{{ ucfirst(str_replace('_', ' ', $field)) }}</s></span>
                                    @else
                                        <i class="far fa-circle text-danger me-2"></i>
                                        <span>{{ ucfirst(str_replace('_', ' ', $field)) }}</span>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            
            <!-- Profile preview card -->
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <h5 class="card-title">Profile Preview</h5>
                    <div class="mb-3">
                        @if (Auth::user()->profile_photo)
                            <img src="{{ asset('storage/' . Auth::user()->profile_photo) }}" alt="Profile" class="rounded-circle img-thumbnail" style="width: 150px; height: 150px; object-fit: cover;">
                        @else
                            <div class="bg-light rounded-circle d-flex align-items-center justify-content-center mx-auto" style="width: 150px; height: 150px;">
                                <i class="fas fa-user fa-4x text-secondary"></i>
                            </div>
                        @endif
                    </div>
                    <h5 class="font-weight-bold mb-1">{{ Auth::user()->name }}</h5>
                    <p class="mb-2">{{ $profile->headline ?? 'No headline set' }}</p>
                    <p class="text-muted mb-3">
                        <i class="fas fa-map-marker-alt me-1"></i>
                        {{ $profile->location ?? 'No location set' }}
                    </p>
                    
                    @if ($profile->id)
                        <a href="{{ route('candidate.profile', $profile->id) }}" class="btn btn-outline-primary btn-sm" target="_blank">
                            <i class="fas fa-eye me-1"></i>View Public Profile
                        </a>
                    @else
                        <button class="btn btn-outline-secondary btn-sm" disabled>
                            <i class="fas fa-eye-slash me-1"></i>Profile Not Yet Created
                        </button>
                    @endif
                </div>
            </div>
        </div>
        
        <div class="col-lg-9">
            <!-- Profile Form -->
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <ul class="nav nav-tabs card-header-tabs" id="profileTabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="basic-tab" data-bs-toggle="tab" href="#basic" role="tab" aria-controls="basic" aria-selected="true">
                                Basic Info
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="details-tab" data-bs-toggle="tab" href="#details" role="tab" aria-controls="details" aria-selected="false">
                                Experience & Skills
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="resume-tab" data-bs-toggle="tab" href="#resume" role="tab" aria-controls="resume" aria-selected="false">
                                Resume & Documents
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    
                    <form method="POST" action="{{ route('profile.candidate.update') }}" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="tab-content" id="profileTabsContent">
                            <!-- Basic Info Tab -->
                            <div class="tab-pane fade show active" id="basic" role="tabpanel" aria-labelledby="basic-tab">
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="fullname" class="form-label">Full Name</label>
                                        <input type="text" class="form-control" id="fullname" value="{{ Auth::user()->name }}" disabled>
                                        <small class="text-muted">To update your name, go to account settings</small>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="email" value="{{ Auth::user()->email }}" disabled>
                                        <small class="text-muted">To update your email, go to account settings</small>
                                    </div>
                                </div>
                                
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="headline" class="form-label">Professional Headline</label>
                                        <input type="text" class="form-control @error('headline') is-invalid @enderror" id="headline" name="headline" value="{{ old('headline', $profile->headline) }}" placeholder="e.g., Full Stack Developer with 5 years experience">
                                        @error('headline')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="text-muted">A brief professional headline (max 100 chars)</small>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="phone" class="form-label">Phone Number</label>
                                        <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone', $profile->phone) }}" placeholder="Enter your phone number">
                                        @error('phone')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="location" class="form-label">Location</label>
                                    <input type="text" class="form-control @error('location') is-invalid @enderror" id="location" name="location" value="{{ old('location', $profile->location) }}" placeholder="e.g., New York, NY">
                                    @error('location')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">City, State, Country (or if you're open to remote work, specify "Remote")</small>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="bio" class="form-label">Bio / About Me</label>
                                    <textarea class="form-control @error('bio') is-invalid @enderror" id="bio" name="bio" rows="4" placeholder="Write a short bio about yourself, your background, and career goals">{{ old('bio', $profile->bio) }}</textarea>
                                    @error('bio')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="website" class="form-label">Personal Website</label>
                                        <input type="url" class="form-control @error('website') is-invalid @enderror" id="website" name="website" value="{{ old('website', $profile->website) }}" placeholder="https://yourwebsite.com">
                                        @error('website')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="linkedin" class="form-label">LinkedIn Profile</label>
                                        <input type="url" class="form-control @error('linkedin') is-invalid @enderror" id="linkedin" name="linkedin" value="{{ old('linkedin', $profile->linkedin) }}" placeholder="https://www.linkedin.com/in/yourprofile">
                                        @error('linkedin')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="profile_photo" class="form-label">Profile Photo</label>
                                    <input type="file" class="form-control @error('profile_photo') is-invalid @enderror" id="profile_photo" name="profile_photo">
                                    @error('profile_photo')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">Upload a professional photo (JPEG, PNG, max 2MB)</small>
                                </div>
                            </div>
                            
                            <!-- Experience & Skills Tab -->
                            <div class="tab-pane fade" id="details" role="tabpanel" aria-labelledby="details-tab">
                                <div class="mb-4">
                                    <label for="skills" class="form-label">Skills</label>
                                    <textarea class="form-control @error('skills') is-invalid @enderror" id="skills" name="skills" rows="2" placeholder="List your skills separated by commas (e.g., JavaScript, React, Node.js, HTML, CSS)">{{ old('skills', $profile->skills) }}</textarea>
                                    @error('skills')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">List technical skills, soft skills, tools, and technologies you're proficient in</small>
                                </div>
                                
                                <div class="mb-4">
                                    <label for="experience" class="form-label">Work Experience</label>
                                    <textarea class="form-control @error('experience') is-invalid @enderror" id="experience" name="experience" rows="6" placeholder="Summarize your work experience">{{ old('experience', $profile->experience) }}</textarea>
                                    @error('experience')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">Format: Company - Position (Year-Year): Description</small>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="education" class="form-label">Education</label>
                                    <textarea class="form-control @error('education') is-invalid @enderror" id="education" name="education" rows="4" placeholder="Summarize your educational background">{{ old('education', $profile->education) }}</textarea>
                                    @error('education')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">Format: Institution - Degree (Year-Year)</small>
                                </div>
                            </div>
                            
                            <!-- Resume & Documents Tab -->
                            <div class="tab-pane fade" id="resume" role="tabpanel" aria-labelledby="resume-tab">
                                <div class="mb-4">
                                    <label for="resume" class="form-label">Resume / CV</label>
                                    <input type="file" class="form-control @error('resume') is-invalid @enderror" id="resume" name="resume">
                                    @error('resume')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">Upload your resume in PDF, DOC, or DOCX format (max 5MB)</small>
                                    
                                    @if($profile->resume)
                                        <div class="mt-2 d-flex align-items-center">
                                            <i class="fas fa-file-pdf text-danger me-2"></i>
                                            <span>Current resume:</span>
                                            <a href="{{ asset('storage/' . $profile->resume) }}" target="_blank" class="ms-2">View Resume</a>
                                            <span class="badge bg-success ms-2">Uploaded</span>
                                        </div>
                                    @else
                                        <div class="mt-2">
                                            <i class="fas fa-exclamation-circle text-warning me-2"></i>
                                            <span class="text-muted">No resume uploaded yet</span>
                                        </div>
                                    @endif
                                </div>
                                
                                <div class="alert alert-info" role="alert">
                                    <h6 class="alert-heading"><i class="fas fa-info-circle me-2"></i>Resume Tips</h6>
                                    <ul class="mb-0">
                                        <li>Keep your resume concise and relevant - ideally 1-2 pages</li>
                                        <li>Include your contact information, experience, skills, and education</li>
                                        <li>Highlight achievements and results, not just responsibilities</li>
                                        <li>Use bullet points for better readability</li>
                                        <li>Proofread carefully for grammar and spelling errors</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        
                        <div class="border-top pt-3 mt-4 text-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Save Profile
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection