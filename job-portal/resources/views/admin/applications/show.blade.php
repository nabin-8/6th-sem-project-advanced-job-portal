@extends('admin.layout')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center mb-3">
        <h1 class="h2">Application Details</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <a href="{{ route('jobs.show', $application->job) }}" class="btn btn-sm btn-outline-primary">
                    <i class="fas fa-briefcase me-1"></i> View Job
                </a>
                <a href="{{ route('candidates.show', $application->candidate) }}" class="btn btn-sm btn-outline-primary">
                    <i class="fas fa-user-tie me-1"></i> View Candidate
                </a>
                <a href="{{ route('applications.index') }}" class="btn btn-sm btn-outline-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Back to List
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <!-- Application Info -->
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-file-alt me-1"></i> Application Information
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <h3>{{ $application->job->title }}</h3>
                            <span class="badge bg-{{ 
                                $application->status === 'pending' ? 'warning text-dark' : 
                                ($application->status === 'reviewed' ? 'success' : 'danger') 
                            }}">
                                {{ ucfirst($application->status) }}
                            </span>
                        </div>
                        <p class="text-muted">
                            <strong>Organization:</strong> {{ $application->job->organization->company_name }} |
                            <strong>Location:</strong> {{ $application->job->location }} |
                            <strong>Applied on:</strong> {{ $application->created_at->format('M d, Y') }}
                        </p>
                    </div>

                    <hr>

                    <div class="mb-4">
                        <h5>Cover Letter</h5>
                        <div class="p-3 bg-light rounded">
                            {!! nl2br(e($application->cover_letter)) !!}
                        </div>
                    </div>

                    @if($application->notes)
                    <div class="mb-4">
                        <h5>Application Notes</h5>
                        <div class="p-3 bg-light rounded">
                            {!! nl2br(e($application->notes)) !!}
                        </div>
                    </div>
                    @endif

                    <hr>

                    <div class="mb-4">
                        <h5>Update Application Status</h5>
                        <form action="{{ route('applications.updateStatus', $application) }}" method="POST" class="row g-2">
                            @csrf
                            @method('PUT')
                            <div class="col-md-8">
                                <select name="status" class="form-select @error('status') is-invalid @enderror">
                                    <option value="pending" {{ $application->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="reviewed" {{ $application->status === 'reviewed' ? 'selected' : '' }}>Reviewed</option>
                                    <option value="rejected" {{ $application->status === 'rejected' ? 'selected' : '' }}>Rejected</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <button type="submit" class="btn btn-primary w-100">Update Status</button>
                            </div>
                        </form>
                    </div>

                    <div class="mb-3">
                        <h5>Add Notes</h5>
                        {{-- <form action="{{ route('applications.addNotes', $application) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <textarea name="notes" class="form-control @error('notes') is-invalid @enderror" rows="3" placeholder="Add internal notes about this application...">{{ old('notes', $application->notes) }}</textarea>
                                @error('notes')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary">Save Notes</button>
                        </form> --}}
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <!-- Candidate Info -->
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-user-tie me-1"></i> Candidate Information
                </div>
                <div class="card-body">
                    <h5>{{ $application->candidate->user->name }}</h5>
                    <p class="text-muted">{{ $application->candidate->user->email }}</p>
                    
                    <div class="mb-3">
                        <strong>Phone:</strong> {{ $application->candidate->phone ?? 'Not provided' }}
                    </div>
                    
                    @if($application->candidate->skills)
                    <div class="mb-3">
                        <strong>Skills:</strong>
                        <p>{{ $application->candidate->skills }}</p>
                    </div>
                    @endif
                    
                    @if($application->candidate->resume_path)
                    <a href="{{ Storage::url($application->candidate->resume_path) }}" target="_blank" class="btn btn-outline-primary w-100 mb-2">
                        <i class="fas fa-file-alt me-1"></i> View Resume
                    </a>
                    @endif
                    
                    <a href="{{ route('candidates.show', $application->candidate) }}" class="btn btn-outline-secondary w-100">
                        <i class="fas fa-user-tie me-1"></i> Full Candidate Profile
                    </a>
                </div>
            </div>
            
            <!-- Job Info -->
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-briefcase me-1"></i> Job Information
                </div>
                <div class="card-body">
                    <h5>{{ $application->job->title }}</h5>
                    <p class="text-muted">{{ $application->job->organization->company_name }}</p>
                    
                    <div class="mb-3">
                        <strong>Location:</strong> {{ $application->job->location }}
                    </div>
                    
                    @if($application->job->salary)
                    <div class="mb-3">
                        <strong>Salary:</strong> {{ $application->job->salary }}
                    </div>
                    @endif
                    
                    <div class="mb-3">
                        <strong>Status:</strong>
                        <span class="badge bg-{{ $application->job->status === 'open' ? 'success' : 'secondary' }}">
                            {{ ucfirst($application->job->status) }}
                        </span>
                    </div>
                    
                    <a href="{{ route('jobs.show', $application->job) }}" class="btn btn-outline-secondary w-100">
                        <i class="fas fa-briefcase me-1"></i> Full Job Details
                    </a>
                </div>
            </div>
            
            <!-- Danger Zone -->
            <div class="card mb-4">
                <div class="card-header bg-danger text-white">
                    <i class="fas fa-exclamation-triangle me-1"></i> Danger Zone
                </div>
                <div class="card-body">
                    <form action="{{ route('applications.destroy', $application) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this application? This action cannot be undone.');">
                        @csrf
                        @method('DELETE')
                        <div class="d-grid">
                            <button type="submit" class="btn btn-outline-danger">
                                <i class="fas fa-trash me-1"></i> Delete Application
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection