@extends('layouts.master')

@section('title', 'Edit Job')

@section('page-header')
    <div class="row mb-4">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('organization.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('jobs.manage') }}">Manage Jobs</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit Job</li>
                </ol>
            </nav>
            <h1 class="h3 mb-0 text-primary">Edit Job</h1>
            <p class="text-muted">Update your job listing information</p>
        </div>
    </div>
@endsection

@section('content')
    <div class="card shadow-sm">
        <div class="card-body p-4">
            <form action="{{ route('jobs.update', $job->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <!-- Basic Information -->
                <div class="mb-4">
                    <h5 class="border-bottom pb-2">Basic Information</h5>
                    
                    <div class="row g-3">
                        <!-- Job Title -->
                        <div class="col-12">
                            <div class="form-group">
                                <label for="title" class="form-label">Job Title <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title', $job->title) }}" required>
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Clearly describe the position (e.g., "Senior Software Engineer", "Marketing Manager")</div>
                            </div>
                        </div>
                        
                        <!-- Location -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="location" class="form-label">Location <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('location') is-invalid @enderror" id="location" name="location" value="{{ old('location', $job->location) }}" required>
                                @error('location')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Specify the job location or "Remote" if applicable</div>
                            </div>
                        </div>
                        
                        <!-- Employment Type -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="employment_type" class="form-label">Employment Type <span class="text-danger">*</span></label>
                                <select class="form-select @error('employment_type') is-invalid @enderror" id="employment_type" name="employment_type" required>
                                    <option value="">Select employment type</option>
                                    @foreach($employmentTypes as $type)
                                        <option value="{{ $type }}" {{ old('employment_type', $job->employment_type) == $type ? 'selected' : '' }}>{{ ucfirst($type) }}</option>
                                    @endforeach
                                </select>
                                @error('employment_type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <!-- Salary Range -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="salary_min" class="form-label">Salary Range (Optional)</label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input type="number" class="form-control @error('salary_min') is-invalid @enderror" id="salary_min" name="salary_min" value="{{ old('salary_min', $job->salary_min) }}" placeholder="Minimum">
                                    <span class="input-group-text">to</span>
                                    <input type="number" class="form-control @error('salary_max') is-invalid @enderror" id="salary_max" name="salary_max" value="{{ old('salary_max', $job->salary_max) }}" placeholder="Maximum">
                                </div>
                                @error('salary_min')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                                @error('salary_max')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Providing a salary range increases application rates</div>
                            </div>
                        </div>
                          <!-- Application Deadline -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="application_deadline" class="form-label">Application Deadline <span class="text-danger">*</span></label>
                                <input type="date" class="form-control @error('application_deadline') is-invalid @enderror" id="application_deadline" name="application_deadline" value="{{ old('application_deadline', $job->application_deadline ? $job->application_deadline->format('Y-m-d') : '') }}" required>
                                @error('application_deadline')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Job Description -->
                <div class="mb-4">
                    <h5 class="border-bottom pb-2">Job Details</h5>
                    
                    <div class="row g-3">
                        <!-- Description -->
                        <div class="col-12">
                            <div class="form-group">
                                <label for="description" class="form-label">Job Description <span class="text-danger">*</span></label>
                                <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="6" required>{{ old('description', $job->description) }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">
                                    Provide a detailed description of the job, including:
                                    <ul class="mt-1">
                                        <li>Overview of the role and its importance</li>
                                        <li>Key responsibilities and tasks</li>
                                        <li>Team structure and reporting lines</li>
                                        <li>Company benefits and perks</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Requirements -->
                        <div class="col-12">
                            <div class="form-group">
                                <label for="requirements" class="form-label">Requirements <span class="text-danger">*</span></label>
                                <textarea class="form-control @error('requirements') is-invalid @enderror" id="requirements" name="requirements" rows="6" required>{{ old('requirements', is_array($job->requirements) ? implode("\n", $job->requirements) : $job->requirements) }}</textarea>
                                @error('requirements')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">
                                    Specify the qualifications candidates should have, including:
                                    <ul class="mt-1">
                                        <li>Required education and experience</li>
                                        <li>Technical skills and certifications</li>
                                        <li>Soft skills and personal qualities</li>
                                        <li>Any other requirements (e.g., travel, licenses)</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Current Status -->
                <div class="mb-4">
                    <h5 class="border-bottom pb-2">Job Status</h5>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Current Status</label>
                                <div>
                                    <span class="badge {{ $job->status == 'open' ? 'bg-success' : 'bg-secondary' }} p-2">
                                        <i class="fas fa-{{ $job->status == 'open' ? 'check-circle' : 'times-circle' }} me-1"></i>
                                        {{ ucfirst($job->status) }}
                                    </span>
                                </div>
                                <div class="form-text mt-2">
                                    To change the job status, use the toggle button on the job management page.
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Applications</label>
                                <div>
                                    <a href="{{ route('jobs.applications', $job->id) }}" class="btn btn-outline-primary btn-sm">
                                        <i class="fas fa-users me-1"></i>
                                        View {{ $job->applications_count ?? '0' }} Applications
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Submit Section -->
                <div class="d-flex justify-content-between mt-4 pt-2 border-top">
                    <a href="{{ route('jobs.manage') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Cancel
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection