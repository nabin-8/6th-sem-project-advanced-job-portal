@extends('admin.layout')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center mb-3">
            <h1 class="h2">Applications Management</h1>
        </div>

        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <span><i class="fas fa-file-alt me-2"></i>All Applications</span>

                    <div>
                        <form method="GET" action="{{ route('admin.applications.index') }}" class="d-flex">                            <select name="status" class="form-select form-select-sm me-2" onchange="this.form.submit()">
                                <option value="">All Statuses</option>
                                <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="reviewing" {{ request('status') === 'reviewing' ? 'selected' : '' }}>Reviewing</option>
                                <option value="interview" {{ request('status') === 'interview' ? 'selected' : '' }}>Interview</option>
                                <option value="offered" {{ request('status') === 'offered' ? 'selected' : '' }}>Offered</option>
                                <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Rejected</option>
                                <option value="withdrawn" {{ request('status') === 'withdrawn' ? 'selected' : '' }}>Withdrawn</option>
                            </select>
                        </form>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Job Title</th>
                                <th>Candidate</th>
                                <th>Organization</th>
                                <th>Status</th>
                                <th>Applied On</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($applications as $application)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>                                        <a href="{{ route('admin.jobs.show', $application->job) }}" class="text-decoration-none">
                                            {{ $application->job->title }}
                                        </a>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.candidates.show', $application->candidate) }}"
                                            class="text-decoration-none">
                                            {{ $application->candidate->user->name }}
                                        </a>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.organizations.show', $application->job->organization) }}"
                                            class="text-decoration-none">
                                            {{ $application->job->organization->company_name }}
                                        </a>
                                    </td>                                    <td>
                                        @if ($application->status == 'pending')
                                            <span class="badge bg-warning text-dark">Pending</span>
                                        @elseif($application->status == 'reviewing')
                                            <span class="badge bg-info">Reviewing</span>
                                        @elseif($application->status == 'interview')
                                            <span class="badge bg-primary">Interview</span>
                                        @elseif($application->status == 'offered')
                                            <span class="badge bg-success">Offered</span>
                                        @elseif($application->status == 'rejected')
                                            <span class="badge bg-danger">Rejected</span>
                                        @elseif($application->status == 'withdrawn')
                                            <span class="badge bg-secondary">Withdrawn</span>
                                        @else
                                            <span class="badge bg-light text-dark">{{ ucfirst($application->status) }}</span>
                                        @endif
                                    </td>
                                    <td>{{ $application->created_at->format('M d, Y') }}</td>
                                    <td>
                                        <div class="btn-group" role="group">                                            <a href="{{ route('admin.applications.show', $application) }}"
                                                class="btn btn-sm btn-info">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <form action="{{ route('admin.applications.destroy', $application) }}" method="POST"
                                                class="d-inline"
                                                onsubmit="return confirm('Are you sure you want to delete this application?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center">
                    {{ $applications->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
