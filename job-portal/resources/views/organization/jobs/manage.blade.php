@extends('layouts.master')

@section('title', 'Manage Jobs')

@section('page-header')
    <div class="row align-items-center mb-4">
        <div class="col">
            <h1 class="h3 mb-0 text-primary">Manage Job Listings</h1>
            <p class="text-muted">View, edit and manage your job listings</p>
        </div>
        <div class="col-auto">
            <a href="{{ route('jobs.create') }}" class="btn btn-primary">
                <i class="fas fa-plus-circle me-2"></i>Post New Job
            </a>
        </div>
    </div>
@endsection

@section('content')
    <!-- Job Listings -->
    <div class="card shadow-sm">
        <div class="card-header bg-white">
            <div class="row align-items-center">
                <div class="col">
                    <h5 class="mb-0">Your Job Listings</h5>
                </div>
                <div class="col-auto">
                    <div class="btn-group" role="group">
                        <a href="{{ route('jobs.manage', ['status' => 'all']) }}" class="btn btn-sm {{ !request('status') || request('status') == 'all' ? 'btn-primary' : 'btn-outline-primary' }}">
                            All
                        </a>
                        <a href="{{ route('jobs.manage', ['status' => 'open']) }}" class="btn btn-sm {{ request('status') == 'open' ? 'btn-primary' : 'btn-outline-primary' }}">
                            Open
                        </a>
                        <a href="{{ route('jobs.manage', ['status' => 'closed']) }}" class="btn btn-sm {{ request('status') == 'closed' ? 'btn-primary' : 'btn-outline-primary' }}">
                            Closed
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            @if($jobs->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Job Title</th>
                                <th>Location</th>
                                <th>Applications</th>
                                <th>Status</th>
                                <th>Created</th>
                                <th>Deadline</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($jobs as $job)
                                <tr>
                                    <td>
                                        <a href="{{ route('jobs.show', $job->id) }}" class="text-decoration-none fw-bold" target="_blank">
                                            {{ $job->title }}
                                        </a>
                                    </td>
                                    <td>{{ $job->location }}</td>
                                    <td>
                                        {{ $job->applications_count ?? 0 }}
                                        <a href="{{ route('jobs.applications', $job->id) }}" class="btn btn-sm btn-link p-0 ms-1">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                    <td>
                                        @if($job->status == 'open')
                                            <span class="badge bg-success">Open</span>
                                        @else
                                            <span class="badge bg-secondary">Closed</span>
                                        @endif
                                    </td>
                                    <td>{{ $job->created_at->format('M d, Y') }}</td>                                    <td>
                                        @if($job->application_deadline)
                                            {{ \Carbon\Carbon::parse($job->application_deadline)->format('M d, Y') }}
                                            @if(\Carbon\Carbon::parse($job->application_deadline)->isPast())
                                                <span class="badge bg-danger">Expired</span>
                                            @elseif(\Carbon\Carbon::parse($job->application_deadline)->diffInDays() < 7)
                                                <span class="badge bg-warning">Expires Soon</span>
                                            @endif
                                        @else
                                            <span class="text-muted">No deadline set</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" id="jobActionsDropdown{{ $job->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                                Actions
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="jobActionsDropdown{{ $job->id }}">
                                                <li>
                                                    <a class="dropdown-item" href="{{ route('jobs.show', $job->id) }}" target="_blank">
                                                        <i class="fas fa-eye me-2 text-primary"></i>View
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="{{ route('jobs.edit', $job->id) }}">
                                                        <i class="fas fa-edit me-2 text-success"></i>Edit
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="{{ route('jobs.applications', $job->id) }}">
                                                        <i class="fas fa-users me-2 text-info"></i>Applications
                                                    </a>
                                                </li>
                                                <li><hr class="dropdown-divider"></li>
                                                <li>
                                                    <form action="{{ route('jobs.toggle-status', $job->id) }}" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <button type="submit" class="dropdown-item">
                                                            @if($job->status == 'open')
                                                                <i class="fas fa-pause-circle me-2 text-warning"></i>Close Job
                                                            @else
                                                                <i class="fas fa-play-circle me-2 text-success"></i>Reopen Job
                                                            @endif
                                                        </button>
                                                    </form>
                                                </li>
                                                <li>
                                                    <button type="button" class="dropdown-item text-danger" data-bs-toggle="modal" data-bs-target="#deleteJobModal{{ $job->id }}">
                                                        <i class="fas fa-trash-alt me-2"></i>Delete
                                                    </button>
                                                </li>
                                            </ul>
                                        </div>

                                        <!-- Delete Job Modal -->
                                        <div class="modal fade" id="deleteJobModal{{ $job->id }}" tabindex="-1" aria-labelledby="deleteJobModalLabel{{ $job->id }}" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="deleteJobModalLabel{{ $job->id }}">Confirm Delete</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>Are you sure you want to delete the job: <strong>{{ $job->title }}</strong>?</p>
                                                        <p class="text-danger">This action cannot be undone. Jobs with active applications cannot be deleted.</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                        <form action="{{ route('jobs.destroy', $job->id) }}" method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger">Delete Job</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-5">
                    <div class="mb-3">
                        <i class="fas fa-briefcase fa-4x text-muted"></i>
                    </div>
                    <h5>No Jobs Found</h5>
                    <p class="text-muted">You haven't posted any job listings yet.</p>
                    <a href="{{ route('jobs.create') }}" class="btn btn-primary mt-2">
                        <i class="fas fa-plus-circle me-2"></i>Post Your First Job
                    </a>
                </div>
            @endif
        </div>
        @if($jobs->count() > 0)
            <div class="card-footer bg-white">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <small class="text-muted">Showing {{ $jobs->firstItem() ?? 0 }} to {{ $jobs->lastItem() ?? 0 }} of {{ $jobs->total() }} jobs</small>
                    </div>
                    <div>
                        {{ $jobs->links() }}
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection