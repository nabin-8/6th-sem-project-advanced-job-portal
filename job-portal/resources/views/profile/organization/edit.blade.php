@extends('layouts.master')

@section('title', 'Edit Organization Profile')

@section('page-header')
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="h3 mb-0 text-primary">Edit Organization Profile</h1>
            <p class="text-muted">Complete your organization's profile to attract the best talent</p>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-3">
            <!-- Profile completion card -->
            <div class="card mb-4 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Profile Completion</h5>                    @php
                        $completionFields = \App\Models\OrganizationProfile::getRequiredFields();
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
            
            <!-- Organization preview card -->
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <h5 class="card-title">Organization Preview</h5>
                    <div class="mb-3">                        @if ($profile->logo)
                            <img src="{{ asset('uploads/' . $profile->logo) }}" alt="Company Logo" class="img-thumbnail" style="max-width: 150px; max-height: 150px; object-fit: contain;">
                        @else
                            <div class="bg-light rounded d-flex align-items-center justify-content-center mx-auto" style="width: 150px; height: 150px;">
                                <i class="fas fa-building fa-4x text-secondary"></i>
                            </div>
                        @endif
                    </div>
                    <h5 class="font-weight-bold mb-1">{{ $profile->name ?? Auth::user()->name }}</h5>
                    <p class="mb-2">{{ $profile->industry ?? 'Industry not specified' }}</p>
                    <p class="text-muted mb-3">
                        <i class="fas fa-map-marker-alt me-1"></i>
                        {{ $profile->location ?? 'No location set' }}
                    </p>
                    
                    @if ($profile->id)
                        <a href="{{ route('organization.profile', $profile->id) }}" class="btn btn-outline-primary btn-sm" target="_blank">
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
            <!-- Organization Profile Form -->
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
                                Company Details
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="media-tab" data-bs-toggle="tab" href="#media" role="tab" aria-controls="media" aria-selected="false">
                                Media & Documents
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
                    
                    <form method="POST" action="{{ route('profile.organization.update') }}" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="tab-content" id="profileTabsContent">
                            <!-- Basic Info Tab -->
                            <div class="tab-pane fade show active" id="basic" role="tabpanel" aria-labelledby="basic-tab">
                                <div class="row mb-3">
                                    <div class="col-md-6">                                        <label for="name" class="form-label">Company Name</label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $profile->name) }}" placeholder="Enter your company name">
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="industry" class="form-label">Industry</label>
                                        <input type="text" class="form-control @error('industry') is-invalid @enderror" id="industry" name="industry" value="{{ old('industry', $profile->industry) }}" placeholder="e.g., Software Development, Healthcare, Finance">
                                        @error('industry')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="location" class="form-label">Headquarters Location</label>
                                    <input type="text" class="form-control @error('location') is-invalid @enderror" id="location" name="location" value="{{ old('location', $profile->location) }}" placeholder="e.g., San Francisco, CA">
                                    @error('location')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="website" class="form-label">Company Website</label>
                                        <input type="url" class="form-control @error('website') is-invalid @enderror" id="website" name="website" value="{{ old('website', $profile->website) }}" placeholder="https://yourcompany.com">
                                        @error('website')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="founded_year" class="form-label">Founded Year</label>
                                        <input type="number" class="form-control @error('founded_year') is-invalid @enderror" id="founded_year" name="founded_year" value="{{ old('founded_year', $profile->founded_year) }}" placeholder="e.g., 2010">
                                        @error('founded_year')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="company_size" class="form-label">Company Size</label>
                                        <select class="form-select @error('company_size') is-invalid @enderror" id="company_size" name="company_size">
                                            <option value="">Select company size</option>
                                            <option value="1-10" {{ old('company_size', $profile->company_size) == '1-10' ? 'selected' : '' }}>1-10 employees</option>
                                            <option value="11-50" {{ old('company_size', $profile->company_size) == '11-50' ? 'selected' : '' }}>11-50 employees</option>
                                            <option value="51-200" {{ old('company_size', $profile->company_size) == '51-200' ? 'selected' : '' }}>51-200 employees</option>
                                            <option value="201-500" {{ old('company_size', $profile->company_size) == '201-500' ? 'selected' : '' }}>201-500 employees</option>
                                            <option value="501-1000" {{ old('company_size', $profile->company_size) == '501-1000' ? 'selected' : '' }}>501-1000 employees</option>
                                            <option value="1001-5000" {{ old('company_size', $profile->company_size) == '1001-5000' ? 'selected' : '' }}>1001-5000 employees</option>
                                            <option value="5001+" {{ old('company_size', $profile->company_size) == '5001+' ? 'selected' : '' }}>5001+ employees</option>
                                        </select>
                                        @error('company_size')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">                                        <label for="email" class="form-label">Public Contact Email</label>
                                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $profile->email) }}" placeholder="contact@yourcompany.com">
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="text-muted">This email will be visible on your public profile</small>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Company Details Tab -->
                            <div class="tab-pane fade" id="details" role="tabpanel" aria-labelledby="details-tab">
                                <div class="mb-4">
                                    <label for="description" class="form-label">Company Description</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="4" placeholder="Describe what your company does">{{ old('description', $profile->description) }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-4">
                                    <label for="mission" class="form-label">Company Mission & Values</label>
                                    <textarea class="form-control @error('mission') is-invalid @enderror" id="mission" name="mission" rows="3" placeholder="What is your company's mission statement and core values?">{{ old('mission', $profile->mission) }}</textarea>
                                    @error('mission')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-4">
                                    <label for="benefits" class="form-label">Employee Benefits</label>
                                    <textarea class="form-control @error('benefits') is-invalid @enderror" id="benefits" name="benefits" rows="3" placeholder="List the benefits you offer to employees (healthcare, remote work, etc.)">{{ old('benefits', $profile->benefits) }}</textarea>
                                    @error('benefits')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="linkedin" class="form-label">LinkedIn Company Page</label>
                                        <input type="url" class="form-control @error('linkedin') is-invalid @enderror" id="linkedin" name="linkedin" value="{{ old('linkedin', $profile->linkedin) }}" placeholder="https://www.linkedin.com/company/yourcompany">
                                        @error('linkedin')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="twitter" class="form-label">Twitter/X Profile</label>
                                        <input type="url" class="form-control @error('twitter') is-invalid @enderror" id="twitter" name="twitter" value="{{ old('twitter', $profile->twitter) }}" placeholder="https://twitter.com/yourcompany">
                                        @error('twitter')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Media & Documents Tab -->
                            <div class="tab-pane fade" id="media" role="tabpanel" aria-labelledby="media-tab">
                                <div class="mb-4">
                                    <label for="logo" class="form-label">Company Logo</label>
                                    <input type="file" class="form-control @error('logo') is-invalid @enderror" id="logo" name="logo">
                                    @error('logo')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">Upload a square logo in PNG, JPG format (max 2MB)</small>
                                      @if($profile->logo)
                                        <div class="mt-2 d-flex align-items-center">
                                            <img src="{{ asset('uploads/' . $profile->logo) }}" alt="Current Logo" style="max-width: 100px; max-height: 100px;" class="me-3">
                                            <span>Current logo</span>
                                        </div>
                                    @endif
                                </div>
                                
                                <div class="mb-4">
                                    <label for="banner_image" class="form-label">Company Banner Image</label>
                                    <input type="file" class="form-control @error('banner_image') is-invalid @enderror" id="banner_image" name="banner_image">
                                    @error('banner_image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">Upload a banner image (recommended size: 1200x400px, max 3MB)</small>
                                      @if($profile->banner_image)
                                        <div class="mt-2">
                                            <img src="{{ asset('uploads/' . $profile->banner_image) }}" alt="Current Banner" style="max-width: 100%; height: auto; max-height: 200px;" class="img-thumbnail">
                                        </div>
                                    @endif
                                </div>
                                
                                <div class="mb-4">
                                    <label for="company_brochure" class="form-label">Company Brochure/Documents (Optional)</label>
                                    <input type="file" class="form-control @error('company_brochure') is-invalid @enderror" id="company_brochure" name="company_brochure">
                                    @error('company_brochure')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">Upload company brochure or other documents (PDF format, max 5MB)</small>
                                      @if($profile->company_brochure)
                                        <div class="mt-2 d-flex align-items-center">
                                            <i class="fas fa-file-pdf text-danger me-2"></i>
                                            <a href="{{ asset('uploads/' . $profile->company_brochure) }}" target="_blank">View Current Brochure</a>
                                        </div>
                                    @endif
                                </div>
                                
                                <div class="alert alert-info" role="alert">
                                    <h6 class="alert-heading"><i class="fas fa-info-circle me-2"></i>Media Tips</h6>
                                    <p>A complete visual identity helps candidates better understand your company culture:</p>
                                    <ul class="mb-0">
                                        <li>Use a clear, professional logo</li>
                                        <li>Choose a banner image that represents your company culture</li>
                                        <li>Add documents that showcase your company values or employee experience</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        
                        <div class="border-top pt-3 mt-4 text-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Save Organization Profile
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection