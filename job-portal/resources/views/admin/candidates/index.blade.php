@extends('admin.layout')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center mb-3">
        <h1 class="h2">Candidates Management</h1>
    </div>

    <div class="card">
        <div class="card-header">
            <i class="fas fa-user-tie me-2"></i>All Candidates
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Skills</th>
                            <th>Applications</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($candidates as $candidate)
                        <tr>
                            <td>{{ $candidate->id }}</td>
                            <td>{{ $candidate->user->name }}</td>
                            <td>{{ $candidate->user->email }}</td>
                            <td>{{ Str::limit($candidate->skills, 30) ?? 'N/A' }}</td>
                            <td>{{ $candidate->jobApplications->count() }}</td>
                            <td>                                <div class="btn-group" role="group">
                                    <a href="{{ route('admin.candidates.show', $candidate) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <form action="{{ route('admin.candidates.destroy', $candidate) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this candidate?')">
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
                {{ $candidates->links() }}
            </div>
        </div>
    </div>
</div>
@endsection