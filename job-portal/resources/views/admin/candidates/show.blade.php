@extends('admin.layout')

@section('content')
<div class="container-fluid">    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center mb-3">
        <h1 class="h2">Candidate Details</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <a href="{{ route('admin.users.show', $candidate->user) }}" class="btn btn-sm btn-outline-primary">
                    <i class="fas fa-user me-1"></i> User Account
                </a>
                <a href="{{ route('admin.candidates.index') }}" class="btn btn-sm btn-outline-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Back to List
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-user-tie me-1"></i> Basic Information
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <h4>{{ $candidate->user->name }}</h4>
                        <p class="text-muted">{{ $candidate->user->email }}</p>
                    </div>

                    <div class="mb-3">
                        <h5>Contact Information</h5>
                        <p><strong>Phone:</strong> {{ $candidate->phone ?? 'Not provided' }}</p>
                        <p><strong>Address:</strong> {{ $candidate->address ?? 'Not provided' }}</p>
                    </div>

                    @if($candidate->bio)
                    <div class="mb-3">
                        <h5>Bio</h5>
                        <p>{{ $candidate->bio }}</p>
                    </div>
                    @endif
                </div>
            </div>

            @if($candidate->resume_path)
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-file-alt me-1"></i> Resume
                </div>
                <div class="card-body">
                    <a href="{{ Storage::url($candidate->resume_path) }}" target="_blank" class="btn btn-primary">
                        <i class="fas fa-download me-1"></i> Download Resume
                    </a>
                </div>
            </div>
            @endif
        </div>

        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-cogs me-1"></i> Skills & Experience
                </div>
                <div class="card-body">
                    @if($candidate->skills)
                    <div class="mb-3">
                        <h5>Skills</h5>
                        <p>{{ $candidate->skills }}</p>
                    </div>
                    @endif

                    @if($candidate->education)
                    <div class="mb-3">
                        <h5>Education</h5>
                        <p>{{ $candidate->education }}</p>
                    </div>
                    @endif

                    @if($candidate->experience)
                    <div class="mb-3">
                        <h5>Experience</h5>
                        <p>{{ $candidate->experience }}</p>
                    </div>
                    @endif

                    @if(!$candidate->skills && !$candidate->education && !$candidate->experience)
                    <p>No skills or experience information provided.</p>
                    @endif
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-briefcase me-1"></i> Job Applications
                </div>
                <div class="card-body">
                    @if($candidate->jobApplications->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Job Title</th>
                                        <th>Organization</th>
                                        <th>Status</th>
                                        <th>Applied Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($candidate->jobApplications as $application)
                                    <tr>
                                        <td>{{ $application->job->title }}</td>
                                        <td>{{ $application->job->organization->company_name }}</td>
                                        <td>
                                            @if($application->status == 'pending')
                                                <span class="badge bg-warning text-dark">Pending</span>
                                            @elseif($application->status == 'approved')
                                                <span class="badge bg-success">Approved</span>
                                            @elseif($application->status == 'rejected')
                                                <span class="badge bg-danger">Rejected</span>
                                            @endif
                                        </td>
                                        <td>{{ $application->created_at->format('M d, Y') }}</td>
                                        <td>
                                            <a href="{{ route('applications.show', $application) }}" class="btn btn-sm btn-info">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p>No job applications submitted yet.</p>
                    @endif
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header bg-danger text-white">
                    <i class="fas fa-exclamation-triangle me-1"></i> Danger Zone
                </div>
                <div class="card-body">                    <form action="{{ route('admin.candidates.destroy', $candidate) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this candidate profile? This action cannot be undone.');">
                        @csrf
                        @method('DELETE')
                        <div class="d-grid">
                            <button type="submit" class="btn btn-outline-danger">
                                <i class="fas fa-trash me-1"></i> Delete Candidate Profile
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection