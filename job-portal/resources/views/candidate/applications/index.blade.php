@extends('layouts.master')

@section('title', 'My Applications')

@section('page-header')
    <div class="row mb-4">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('candidate.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">My Applications</li>
                </ol>
            </nav>
            <h1 class="h3 mb-0 text-primary">My Job Applications</h1>
            <p class="text-muted">Track and manage your submitted job applications</p>
        </div>
    </div>
@endsection

@section('content')
    <div class="card shadow-sm">
        <div class="card-header bg-white">
            <div class="row align-items-center">
                <div class="col">
                    <h5 class="mb-0">All Applications</h5>
                </div>
                <div class="col-auto">
                    <div class="btn-group" role="group">
                        <a href="{{ route('applications.index', ['status' => 'all']) }}" class="btn btn-sm {{ !request('status') || request('status') == 'all' ? 'btn-primary' : 'btn-outline-primary' }}">
                            All
                        </a>
                        <a href="{{ route('applications.index', ['status' => 'pending']) }}" class="btn btn-sm {{ request('status') == 'pending' ? 'btn-primary' : 'btn-outline-primary' }}">
                            Pending
                        </a>
                        <a href="{{ route('applications.index', ['status' => 'interview']) }}" class="btn btn-sm {{ request('status') == 'interview' ? 'btn-primary' : 'btn-outline-primary' }}">
                            Interview
                        </a>
                        <a href="{{ route('applications.index', ['status' => 'offered']) }}" class="btn btn-sm {{ request('status') == 'offered' ? 'btn-primary' : 'btn-outline-primary' }}">
                            Offered
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            @if($applications->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Job Title</th>
                                <th>Company</th>
                                <th>Applied On</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($applications as $application)
                                <tr>
                                    <td class="text-nowrap">
                                        <a href="{{ route('jobs.show', $application->job->id) }}" class="text-decoration-none" target="_blank">
                                            {{ $application->job->title }}
                                        </a>
                                    </td>
                                    <td>{{ $application->job->organization->name ?? 'Organization' }}</td>
                                    <td>{{ $application->created_at->format('M d, Y') }}</td>
                                    <td>
                                        @if($application->status == 'pending')
                                            <span class="badge bg-warning">Pending</span>
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
                                            <span class="badge bg-secondary">{{ ucfirst($application->status) }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('applications.show', $application->id) }}" class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            @if(in_array($application->status, ['pending', 'reviewing', 'interview']))
                                                <button type="button" class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#withdrawModal{{ $application->id }}">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                                
                                                <!-- Withdraw Application Modal -->
                                                <div class="modal fade" id="withdrawModal{{ $application->id }}" tabindex="-1" aria-labelledby="withdrawModalLabel{{ $application->id }}" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="withdrawModalLabel{{ $application->id }}">Withdraw Application</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p>Are you sure you want to withdraw your application for <strong>{{ $application->job->title }}</strong> at <strong>{{ $application->job->organization->name ?? 'Organization' }}</strong>?</p>
                                                                <p class="text-danger">This action cannot be undone.</p>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                                <form action="{{ route('applications.withdraw', $application->id) }}" method="POST">
                                                                    @csrf
                                                                    @method('PUT')
                                                                    <button type="submit" class="btn btn-danger">Withdraw Application</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
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
                        <i class="fas fa-file-alt fa-4x text-muted"></i>
                    </div>
                    <h4>No Applications Found</h4>
                    <p class="text-muted">You haven't applied to any jobs yet.</p>
                    <a href="{{ route('jobs.index') }}" class="btn btn-primary mt-2">
                        <i class="fas fa-search me-2"></i>Browse Jobs
                    </a>
                </div>
            @endif
        </div>
        @if($applications->count() > 0)
            <div class="card-footer bg-white">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <small class="text-muted">Showing {{ $applications->firstItem() ?? 0 }} to {{ $applications->lastItem() ?? 0 }} of {{ $applications->total() }} applications</small>
                    </div>
                    <div>
                        {{ $applications->links() }}
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection