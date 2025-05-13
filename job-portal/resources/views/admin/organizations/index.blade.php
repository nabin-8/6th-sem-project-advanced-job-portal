@extends('admin.layout')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center mb-3">
        <h1 class="h2">Organizations Management</h1>
    </div>

    <div class="card">
        <div class="card-header">
            <i class="fas fa-building me-2"></i>All Organizations
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Company Name</th>
                            <th>Contact Name</th>
                            <th>Email</th>
                            <th>Industry</th>
                            <th>Jobs Posted</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($organizations as $organization)
                        <tr>
                            <td>{{ $organization->id }}</td>
                            <td>{{ $organization->company_name }}</td>
                            <td>{{ $organization->user->name }}</td>
                            <td>{{ $organization->user->email }}</td>
                            <td>{{ $organization->industry ?? 'N/A' }}</td>
                            <td>{{ $organization->jobs->count() }}</td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('organizations.show', $organization) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('organizations.edit', $organization) }}" class="btn btn-sm btn-primary">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('organizations.destroy', $organization) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this organization?')">
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
                {{ $organizations->links() }}
            </div>
        </div>
    </div>
</div>
@endsection