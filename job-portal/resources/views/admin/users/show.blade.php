@extends('admin.layout')

@section('content')
<div class="container-fluid">    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center mb-3">
        <h1 class="h2">User Details</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-outline-primary">
                    <i class="fas fa-edit me-1"></i> Edit User
                </a>
                <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-outline-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Back to List
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-user me-1"></i> Basic Information
                </div>
                <div class="card-body">
                    <table class="table">
                        <tr>
                            <th style="width: 30%">ID</th>
                            <td>{{ $user->id }}</td>
                        </tr>
                        <tr>
                            <th>Name</th>
                            <td>{{ $user->name }}</td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>{{ $user->email }}</td>
                        </tr>
                        <tr>
                            <th>Active Role</th>
                            <td>
                                @if($user->active_role)
                                    <span class="badge bg-success">{{ $user->active_role }}</span>
                                @else
                                    <span class="badge bg-secondary">None</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Registered</th>
                            <td>{{ $user->created_at->format('M d, Y H:i') }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card mb-4">                <div class="card-header d-flex justify-content-between align-items-center">
                    <span><i class="fas fa-user-tag me-1"></i> Roles</span>
                    <a href="{{ route('admin.users.edit', $user) }}#roles" class="btn btn-sm btn-primary">Manage Roles</a>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        @foreach($user->roles as $role)
                            <span class="badge bg-primary me-1 mb-1 p-2">{{ $role->name }}</span>
                        @endforeach
                    </div>
                </div>
            </div>

            @if($user->candidateProfile)
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-user-tie me-1"></i> Candidate Profile
                </div>
                <div class="card-body">
                    <p><strong>Bio:</strong> {{ $user->candidateProfile->bio ?? 'Not provided' }}</p>
                    <p><strong>Skills:</strong> {{ $user->candidateProfile->skills ?? 'Not provided' }}</p>
                    <p><strong>Phone:</strong> {{ $user->candidateProfile->phone ?? 'Not provided' }}</p>
                    <p><strong>Address:</strong> {{ $user->candidateProfile->address ?? 'Not provided' }}</p>
                    
                    @if($user->candidateProfile->resume_path)
                    <p>
                        <strong>Resume:</strong> 
                        <a href="{{ Storage::url($user->candidateProfile->resume_path) }}" target="_blank">
                            View Resume <i class="fas fa-external-link-alt"></i>
                        </a>
                    </p>                    @endif
                    
                    <a href="{{ route('admin.candidates.show', $user->candidateProfile) }}" class="btn btn-sm btn-info">
                        View Full Candidate Profile
                    </a>
                </div>
            </div>
            @endif

            @if($user->organizationProfile)
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-building me-1"></i> Organization Profile
                </div>
                <div class="card-body">
                    <p><strong>Company Name:</strong> {{ $user->organizationProfile->company_name ?? 'Not provided' }}</p>
                    <p><strong>Industry:</strong> {{ $user->organizationProfile->industry ?? 'Not provided' }}</p>
                    <p><strong>Company Size:</strong> {{ $user->organizationProfile->company_size ?? 'Not provided' }}</p>
                    <p><strong>Phone:</strong> {{ $user->organizationProfile->phone ?? 'Not provided' }}</p>
                    
                    @if($user->organizationProfile->logo_path)
                    <div class="mb-3">
                        <strong>Logo:</strong><br>
                        <img src="{{ Storage::url($user->organizationProfile->logo_path) }}" alt="Company Logo" style="max-height: 80px;" class="mt-2">
                    </div>                    @endif
                    
                    <a href="{{ route('admin.organizations.show', $user->organizationProfile) }}" class="btn btn-sm btn-info">
                        View Full Organization Profile
                    </a>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection