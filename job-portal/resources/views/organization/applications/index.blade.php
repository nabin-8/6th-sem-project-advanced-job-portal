@extends('layouts.master')

@section('title', 'Applications for ' . $job->title)

@section('page-header')
    <div class="row mb-4">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('organization.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('jobs.manage') }}">Manage Jobs</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Applications</li>
                </ol>
            </nav>
            <h1 class="h3 mb-0 text-primary">Applications for "{{ $job->title }}"</h1>
            <p class="text-muted">Review and manage applications for this position</p>
        </div>
    </div>
@endsection

@section('content')
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-white">
            <div class="d-flex align-items-center justify-content-between">
                <h5 class="card-title mb-0">Job Details</h5>
                <a href="{{ route('jobs.show', $job->id) }}" class="btn btn-sm btn-outline-primary">View Job Post</a>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <p class="mb-2"><strong>Location:</strong> {{ $job->location }}</p>
                    <p class="mb-2"><strong>Employment Type:</strong> {{ ucfirst($job->employment_type) }}</p>
                    <p class="mb-2">
                        <strong>Salary Range:</strong> 
                        @if($job->salary_min && $job->salary_max)
                            ${{ number_format($job->salary_min) }} - ${{ number_format($job->salary_max) }}
                        @elseif($job->salary_min)
                            From ${{ number_format($job->salary_min) }}
                        @elseif($job->salary_max)
                            Up to ${{ number_format($job->salary_max) }}
                        @else
                            Not specified
                        @endif
                    </p>
                </div>
                <div class="col-md-6">
                    <p class="mb-2"><strong>Status:</strong> 
                        <span class="badge {{ $job->status == 'open' ? 'bg-success' : 'bg-danger' }}">
                            {{ ucfirst($job->status) }}
                        </span>
                    </p>
                    <p class="mb-2"><strong>Posted on:</strong> {{ $job->created_at->format('M d, Y') }}</p>
                    <p class="mb-0">
                        <strong>Application Deadline:</strong> 
                        {{ $job->application_deadline->format('M d, Y') }}
                        @if($job->application_deadline->isPast())
                            <span class="badge bg-danger ms-2">Expired</span>
                        @else
                            <span class="badge bg-success ms-2">{{ $job->application_deadline->diffForHumans() }}</span>
                        @endif
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Applications -->
    <div class="card shadow-sm">
        <div class="card-header bg-white">
            <div class="d-flex align-items-center justify-content-between">
                <h5 class="card-title mb-0">
                    Applications 
                    <span class="badge bg-primary ms-2">{{ $applications->total() }}</span>
                </h5>
                <div>
                    <form action="{{ route('jobs.applications', $job->id) }}" method="GET" class="d-flex">
                        <select name="status" class="form-select form-select-sm me-2" onchange="this.form.submit()">
                            <option value="all" {{ request('status', 'all') == 'all' ? 'selected' : '' }}>All Statuses</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="reviewing" {{ request('status') == 'reviewing' ? 'selected' : '' }}>Reviewing</option>
                            <option value="interview" {{ request('status') == 'interview' ? 'selected' : '' }}>Interview</option>
                            <option value="offered" {{ request('status') == 'offered' ? 'selected' : '' }}>Offered</option>
                            <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                            <option value="withdrawn" {{ request('status') == 'withdrawn' ? 'selected' : '' }}>Withdrawn</option>
                        </select>
                    </form>
                </div>
            </div>
        </div>
        
        @if($applications->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Candidate</th>
                            <th>Applied On</th>
                            <th>Status</th>
                            <th>Experience</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($applications as $application)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0 me-3">
                                            @if(isset($application->candidate->user->profile_photo))
                                                <img src="{{ asset('storage/' . $application->candidate->user->profile_photo) }}" alt="Profile" class="rounded-circle" width="40" height="40">
                                            @else
                                                <div class="rounded-circle bg-light d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                                    <i class="fas fa-user text-secondary"></i>
                                                </div>
                                            @endif
                                        </div>
                                        <div>
                                            <h6 class="mb-0">{{ $application->candidate->user->name }}</h6>
                                            <small class="text-muted">{{ $application->candidate->headline ?? 'Candidate' }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $application->created_at->format('M d, Y') }}</td>
                                <td>
                                    <span class="badge p-2
                                        @if($application->status == 'pending')
                                            bg-warning
                                        @elseif($application->status == 'reviewing')
                                            bg-info
                                        @elseif($application->status == 'interview')
                                            bg-primary
                                        @elseif($application->status == 'offered')
                                            bg-success
                                        @elseif($application->status == 'rejected')
                                            bg-danger
                                        @elseif($application->status == 'withdrawn')
                                            bg-secondary
                                        @endif">
                                        {{ ucfirst($application->status) }}
                                    </span>
                                </td>
                                <td>{{ $application->candidate->experience ? $application->candidate->experience . ' years' : 'Not specified' }}</td>
                                <td>
                                    <a href="{{ route('jobs.applications.show', [$job->id, $application->id]) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-eye"></i> View
                                    </a>

                                    @if($application->status == 'pending')
                                        <form action="{{ route('jobs.applications.update-status', [$job->id, $application->id]) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="reviewing">
                                            <button type="submit" class="btn btn-sm btn-outline-info">
                                                <i class="fas fa-search"></i> Start Review
                                            </button>
                                        </form>
                                    @endif

                                    @if(in_array($application->status, ['reviewing', 'interview']))
                                        <div class="dropdown d-inline">
                                            <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                                Actions
                                            </button>
                                            <ul class="dropdown-menu">
                                                @if($application->status == 'reviewing')
                                                    <li>
                                                        <form action="{{ route('jobs.applications.update-status', [$job->id, $application->id]) }}" method="POST">
                                                            @csrf
                                                            @method('PUT')
                                                            <input type="hidden" name="status" value="interview">
                                                            <button type="submit" class="dropdown-item">
                                                                <i class="fas fa-user-tie me-2"></i>Move to Interview
                                                            </button>
                                                        </form>
                                                    </li>
                                                @endif
                                                @if($application->status == 'interview')
                                                    <li>
                                                        <form action="{{ route('jobs.applications.update-status', [$job->id, $application->id]) }}" method="POST">
                                                            @csrf
                                                            @method('PUT')
                                                            <input type="hidden" name="status" value="offered">
                                                            <button type="submit" class="dropdown-item">
                                                                <i class="fas fa-check-circle me-2"></i>Send Job Offer
                                                            </button>
                                                        </form>
                                                    </li>
                                                @endif
                                                <li>
                                                    <form action="{{ route('jobs.applications.update-status', [$job->id, $application->id]) }}" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <input type="hidden" name="status" value="rejected">
                                                        <button type="submit" class="dropdown-item text-danger">
                                                            <i class="fas fa-times-circle me-2"></i>Reject
                                                        </button>
                                                    </form>
                                                </li>
                                            </ul>
                                        </div>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <div class="card-footer bg-white">
                <div class="d-flex justify-content-between align-items-center">
                    <p class="mb-0 text-muted">
                        Showing {{ $applications->firstItem() ?? 0 }} to {{ $applications->lastItem() ?? 0 }} of {{ $applications->total() }} applications
                    </p>
                    {{ $applications->appends(request()->query())->links() }}
                </div>
            </div>
        @else
            <div class="card-body">
                <div class="text-center py-4">
                    <img src="{{ asset('images/empty-applications.svg') }}" alt="No Applications" class="img-fluid mb-3" style="max-height: 150px; opacity: 0.7;">
                    <h5>No Applications Yet</h5>
                    <p class="text-muted">There are no applications matching your current filters.</p>
                    
                    @if(request('status') != 'all')
                        <a href="{{ route('jobs.applications', $job->id) }}" class="btn btn-outline-primary">
                            <i class="fas fa-sync-alt me-2"></i>View All Applications
                        </a>
                    @endif
                </div>
            </div>
        @endif
    </div>
@endsection

@push('scripts')
<script>
    // Initialize tooltips
    document.addEventListener('DOMContentLoaded', function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });
    });
</script>
@endpush