@extends('admin.layout')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center mb-3">
        <h1 class="h2">Jobs Management</h1>
    </div>

    <div class="card">
        <div class="card-header">
            <i class="fas fa-briefcase me-2"></i>All Jobs
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Organization</th>
                            <th>Location</th>
                            <th>Status</th>
                            <th>Applications</th>
                            <th>Posted On</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($jobs as $job)
                        <tr>
                            <td>{{ $job->id }}</td>
                            <td>{{ $job->title }}</td>
                            <td>{{ $job->organization->company_name }}</td>
                            <td>{{ $job->location }}</td>
                            <td>
                                <span class="badge bg-{{ $job->status === 'open' ? 'success' : 'secondary' }}">
                                    {{ ucfirst($job->status) }}
                                </span>
                            </td>
                            <td>{{ $job->applications->count() }}</td>
                            <td>{{ $job->created_at->format('M d, Y') }}</td>
                            <td>                                <div class="btn-group" role="group">
                                    <a href="{{ route('admin.jobs.show', $job) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.jobs.edit', $job) }}" class="btn btn-sm btn-primary">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.jobs.destroy', $job) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this job?')">
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
                {{ $jobs->links() }}
            </div>
        </div>
    </div>
</div>
@endsection