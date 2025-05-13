@extends('admin.layout')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center mb-3">
        <h1 class="h2">Dashboard</h1>
    </div>

    <!-- Stats cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Users</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['users_count'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Candidates</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['candidates_count'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-tie fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Organizations</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['organizations_count'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-building fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Jobs</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['jobs_count'] }}</div>
                            <div class="small text-muted">{{ $stats['open_jobs_count'] }} Open</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-briefcase fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent users -->
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-user mr-1"></i>
            Recent Users
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Roles</th>
                            <th>Date Joined</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recent['users'] as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->roles->pluck('name')->implode(', ') }}</td>
                            <td>{{ $user->created_at->diffForHumans() }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="text-end">
                <a href="{{ route('users.index') }}" class="btn btn-sm btn-primary">View all users</a>
            </div>
        </div>
    </div>

    <!-- Recent Jobs -->
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-briefcase mr-1"></i>
            Recent Jobs
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Title</th>
                            <th>Organization</th>
                            <th>Status</th>
                            <th>Location</th>
                            <th>Posted On</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recent['jobs'] as $job)
                        <tr>
                            <td>{{ $job->title }}</td>
                            <td>{{ $job->organization->company_name }}</td>
                            <td><span class="badge bg-{{ $job->status === 'open' ? 'success' : 'secondary' }}">{{ ucfirst($job->status) }}</span></td>
                            <td>{{ $job->location }}</td>
                            <td>{{ $job->created_at->diffForHumans() }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="text-end">
                <a href="{{ route('jobs.index') }}" class="btn btn-sm btn-primary">View all jobs</a>
            </div>
        </div>
    </div>

    <!-- Recent Applications -->
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-file-alt mr-1"></i>
            Recent Applications
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Job</th>
                            <th>Candidate</th>
                            <th>Status</th>
                            <th>Applied On</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recent['applications'] as $application)
                        <tr>
                            <td>{{ $application->job->title }}</td>
                            <td>{{ $application->candidate->user->name }}</td>
                            <td>
                                @if($application->status == 'pending')
                                    <span class="badge bg-warning text-dark">Pending</span>
                                @elseif($application->status == 'approved')
                                    <span class="badge bg-success">Approved</span>
                                @elseif($application->status == 'rejected')
                                    <span class="badge bg-danger">Rejected</span>
                                @endif
                            </td>
                            <td>{{ $application->created_at->diffForHumans() }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="text-end">
                <a href="{{ route('applications.index') }}" class="btn btn-sm btn-primary">View all applications</a>
            </div>
        </div>
    </div>
</div>
@endsection