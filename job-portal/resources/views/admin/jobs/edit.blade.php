@extends('admin.layout')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center mb-3">
        <h1 class="h2">Edit Job</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">                <a href="{{ route('admin.jobs.show', $job) }}" class="btn btn-sm btn-outline-secondary">
                    <i class="fas fa-eye me-1"></i> View Details
                </a>
                <a href="{{ route('admin.jobs.index') }}" class="btn btn-sm btn-outline-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Back to List
                </a>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <i class="fas fa-briefcase me-1"></i> Edit Job
        </div>
        <div class="card-body">            <form action="{{ route('admin.jobs.update', $job) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="title" class="form-label">Job Title *</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title', $job->title) }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                          <div class="mb-3">
                            <label for="location" class="form-label">Location *</label>
                            <input type="text" class="form-control @error('location') is-invalid @enderror" id="location" name="location" value="{{ old('location', $job->location) }}" required>
                            @error('location')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="employment_type" class="form-label">Employment Type *</label>
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
                        
                        <div class="mb-3">
                            <label for="salary" class="form-label">Salary (Optional)</label>
                            <input type="text" class="form-control @error('salary') is-invalid @enderror" id="salary" name="salary" value="{{ old('salary', $job->salary) }}">
                            @error('salary')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                          <div class="mb-3">
                            <label for="status" class="form-label">Status *</label>
                            <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                                <option value="open" {{ (old('status', $job->status) === 'open') ? 'selected' : '' }}>Open</option>
                                <option value="closed" {{ (old('status', $job->status) === 'closed') ? 'selected' : '' }}>Closed</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="category_id" class="form-label">Job Category *</label>
                            <select class="form-select @error('category_id') is-invalid @enderror" id="category_id" name="category_id" required>
                                <option value="">Select job category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id', $job->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="description" class="form-label">Description *</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="4" required>{{ old('description', $job->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="requirements" class="form-label">Requirements *</label>
                            <textarea class="form-control @error('requirements') is-invalid @enderror" id="requirements" name="requirements" rows="4" required>{{ old('requirements', is_array($job->requirements) ? implode("\n", $job->requirements) : $job->requirements) }}</textarea>
                            @error('requirements')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <div class="mb-4">
                    <button type="submit" class="btn btn-primary">Update Job</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection