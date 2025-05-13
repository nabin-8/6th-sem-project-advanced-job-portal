@extends('admin.layout')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center mb-3">
        <h1 class="h2">Job Details</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <a href="{{ route('organizations.show', $job->organization) }}" class="btn btn-sm btn-outline-primary">
                    <i class="fas fa-building me-1"></i> Organization
                </a>
                <a href="{{ route('jobs.edit', $job) }}" class="btn btn-sm btn-outline-primary">
                    <i class="fas fa-edit me-1"></i> Edit
                </a>
                <a href="{{ route('jobs.index') }}" class="btn btn-sm btn-outline-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Back to List
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>
                        <i class="fas fa-briefcase me-1"></i> Job Information
                    </span>
                    <span class="badge bg-{{ $job->status === 'open' ? 'success' : 'secondary' }}">
                        {{ ucfirst($job->status) }}
                    </span>
                </div>
                <div class="card-body">
                    <h3>{{ $job->title }}</h3>
                    <p class="text-muted mb-3">
                        <strong>Organization:</strong> {{ $job->organization->company_name }} | 
                        <strong>Location:</strong> {{ $job->location }} | 
                        <strong>Posted:</strong> {{ $job->created_at->format('M d, Y') }}
                    </p>

                    @if($job->salary)
                    <p><strong>Salary:</strong> {{ $job->salary }}</p>
                    @endif

                    <hr>

                    <h5>Description</h5>
                    <div class="mb-4">
                        {!! nl2br(e($job->description)) !!}
                    </div>

                    <h5>Requirements</h5>
                    <div class="mb-4">
                        @if(is_array($job->requirements) && count($job->requirements))
                            @foreach ($job->requirements as $requirement)
                                <li>{{ $requirement }}</li>
                            @endforeach
                        @else
                            <p>{{ $job->requirements }}</p>
                        @endif

                    </div>

                    <div class="d-flex mt-4">
                        {{-- <form action="{{ route('jobs.toggleStatus', $job) }}" method="POST" class="me-2">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="btn {{ $job->status === 'open' ? 'btn-warning' : 'btn-success' }}">
                                {{ $job->status === 'open' ? 'Close Job' : 'Reopen Job' }}
                            </button>
                        </form> --}}

                        <form action="{{ route('jobs.destroy', $job) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this job? All associated applications will also be deleted.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete Job</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-building me-1"></i> Organization
                </div>
                <div class="card-body">
                    <h5>{{ $job->organization->company_name }}</h5>
                    <p class="text-muted">
                        <strong>Industry:</strong> {{ $job->organization->industry ?? 'Not specified' }}<br>
                        <strong>Size:</strong> {{ $job->organization->company_size ?? 'Not specified' }}
                    </p>
                    
                    @if($job->organization->description)
                    <p class="mb-3">{{ Str::limit($job->organization->description, 100) }}</p>
                    @endif
                    
                    <a href="{{ route('organizations.show', $job->organization) }}" class="btn btn-sm btn-outline-primary">
                        View Organization
                    </a>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-file-alt me-1"></i> Applications ({{ $job->applications->count() }})
                </div>
                <div class="card-body">
                    @if($job->applications->count() > 0)
                        <div class="list-group">
                            @foreach($job->applications as $application)
                                <a href="{{ route('applications.show', $application) }}" class="list-group-item list-group-item-action">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h6 class="mb-1">{{ $application->candidate->user->name }}</h6>
                                        <small>
                                            @if($application->status == 'pending')
                                                <span class="badge bg-warning text-dark">Pending</span>
                                            @elseif($application->status == 'reviewed')
                                                <span class="badge bg-success">Reviewed</span>
                                            @elseif($application->status == 'rejected')
                                                <span class="badge bg-danger">Rejected</span>
                                            @endif
                                        </small>
                                    </div>
                                    <small class="text-muted">Applied {{ $application->created_at->diffForHumans() }}</small>
                                </a>
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted mb-0">No applications received yet.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection