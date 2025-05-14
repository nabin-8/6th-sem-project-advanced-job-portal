@extends('admin.layout')

@section('content')
<div class="container-fluid">    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center mb-3">
        <h1 class="h2">Organization Details</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <a href="{{ route('admin.users.show', $organization->user) }}" class="btn btn-sm btn-outline-primary">
                    <i class="fas fa-user me-1"></i> User Account
                </a>
                <a href="{{ route('admin.organizations.edit', $organization) }}" class="btn btn-sm btn-outline-primary">
                    <i class="fas fa-edit me-1"></i> Edit
                </a>
                <a href="{{ route('admin.organizations.index') }}" class="btn btn-sm btn-outline-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Back to List
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-building me-1"></i> Organization Information
                </div>
                <div class="card-body">
                    <div class="mb-3 d-flex justify-content-between align-items-start">
                        <div>
                            <h4>{{ $organization->company_name }}</h4>
                            <p class="text-muted mb-0">{{ $organization->industry ?? 'Industry not specified' }}</p>
                            <p class="text-muted">{{ $organization->company_size ?? 'Company size not specified' }}</p>
                        </div>

                        @if($organization->logo_path)
                        <div>
                            <img src="{{ Storage::url($organization->logo_path) }}" alt="Company Logo" class="img-thumbnail" style="max-width: 100px;">
                        </div>
                        @endif
                    </div>

                    <div class="mb-3">
                        <h5>Description</h5>
                        <p>{{ $organization->description ?? 'No description available.' }}</p>
                    </div>

                    <div class="mb-3">
                        <h5>Contact Information</h5>
                        <p><strong>Contact Person:</strong> {{ $organization->user->name }}</p>
                        <p><strong>Email:</strong> {{ $organization->user->email }}</p>
                        <p><strong>Phone:</strong> {{ $organization->phone ?? 'Not provided' }}</p>
                        <p><strong>Address:</strong> {{ $organization->address ?? 'Not provided' }}</p>
                    </div>

                    @if($organization->website)
                    <div class="mb-3">
                        <h5>Website</h5>
                        <p>
                            <a href="{{ $organization->website }}" target="_blank">
                                {{ $organization->website }} <i class="fas fa-external-link-alt ms-1"></i>
                            </a>
                        </p>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-briefcase me-1"></i> Jobs Posted
                </div>
                <div class="card-body">
                    @if($organization->jobs->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th>Location</th>
                                        <th>Status</th>
                                        <th>Applications</th>
                                        <th>Posted Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($organization->jobs as $job)
                                    <tr>
                                        <td>{{ $job->title }}</td>
                                        <td>{{ $job->location }}</td>
                                        <td>
                                            <span class="badge bg-{{ $job->status === 'open' ? 'success' : 'secondary' }}">
                                                {{ ucfirst($job->status) }}
                                            </span>
                                        </td>
                                        <td>{{ $job->applications->count() }}</td>
                                        <td>{{ $job->created_at->format('M d, Y') }}</td>
                                        <td>                                            <a href="{{ route('admin.jobs.show', $job) }}" class="btn btn-sm btn-info">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p>No jobs posted yet.</p>
                    @endif
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header bg-danger text-white">
                    <i class="fas fa-exclamation-triangle me-1"></i> Danger Zone
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.organizations.destroy', $organization) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this organization? This will also delete all associated jobs.');">
                        @csrf
                        @method('DELETE')
                        <div class="d-grid">
                            <button type="submit" class="btn btn-outline-danger">
                                <i class="fas fa-trash me-1"></i> Delete Organization
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection