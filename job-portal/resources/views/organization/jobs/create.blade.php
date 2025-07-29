@extends('layouts.master')

@section('title', 'Post a New Job')

@section('page-header')
    <div class="row mb-4">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('organization.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('jobs.manage') }}">Manage Jobs</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Post a New Job</li>
                </ol>
            </nav>
            <h1 class="h3 mb-0 text-primary">Post a New Job</h1>
            <p class="text-muted">Create a new job listing to attract qualified candidates</p>
        </div>
    </div>
@endsection

@section('content')
    <div class="card shadow-sm">
        <div class="card-body p-4">
            <form action="{{ route('jobs.store') }}" method="POST">
                @csrf
                
                <!-- Basic Information -->
                <div class="mb-4">
                    <h5 class="border-bottom pb-2">Basic Information</h5>
                    
                    <div class="row g-3">
                        <!-- Job Title -->
                        <div class="col-12">
                            <div class="form-group">
                                <label for="title" class="form-label">Job Title <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title') }}" required>
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
                                <input type="text" class="form-control @error('location') is-invalid @enderror" id="location" name="location" value="{{ old('location') }}" required>
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
                                        <option value="{{ $type }}" {{ old('employment_type') == $type ? 'selected' : '' }}>{{ ucfirst($type) }}</option>
                                    @endforeach
                                </select>
                                @error('employment_type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <!-- Job Category -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="category_id" class="form-label">Job Category <span class="text-danger">*</span></label>
                                <select class="form-select @error('category_id') is-invalid @enderror" id="category_id" name="category_id" required>
                                    <option value="">Select job category</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                @error('category_id')
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
                                    <input type="number" class="form-control @error('salary_min') is-invalid @enderror" id="salary_min" name="salary_min" value="{{ old('salary_min') }}" placeholder="Minimum">
                                    <span class="input-group-text">to</span>
                                    <input type="number" class="form-control @error('salary_max') is-invalid @enderror" id="salary_max" name="salary_max" value="{{ old('salary_max') }}" placeholder="Maximum">
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
                                <input type="date" class="form-control @error('application_deadline') is-invalid @enderror" id="application_deadline" name="application_deadline" value="{{ old('application_deadline') }}" required>
                                @error('application_deadline')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Deadline must be a future date</div>
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
                                <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="6" required>{{ old('description') }}</textarea>
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
                                <textarea class="form-control @error('requirements') is-invalid @enderror" id="requirements" name="requirements" rows="6" required>{{ old('requirements') }}</textarea>
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
                
                <!-- Submit Section -->
                <div class="d-flex justify-content-between mt-4 pt-2 border-top">
                    <a href="{{ route('jobs.manage') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Cancel
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-paper-plane me-2"></i>Publish Job
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection