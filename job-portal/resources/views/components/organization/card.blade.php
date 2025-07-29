<div class="card org-card mb-4">
    <div class="card-body">
        <div class="d-flex">
            @if($organization->logo)
                <img src="{{ asset('uploads/' . $organization->logo) }}" alt="{{ $organization->name }}" class="me-3 rounded" style="width: 80px; height: 80px; object-fit: cover;">
            @else
                <div class="me-3 rounded bg-secondary d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                    <i class="fas fa-building text-white fa-3x"></i>
                </div>
            @endif
            <div>                <h2 class="h5 mb-1">
                    <a href="{{ route('public.organizations.show', $organization->slug) }}" class="text-decoration-none">{{ $organization->name }}</a>
                </h2>
                @if($organization->industry)
                    <p class="text-muted mb-1">{{ $organization->industry }}</p>
                @endif
                <p class="mb-2 small">{{ Str::limit($organization->description, 100) }}</p>                <div>
                    <a href="{{ route('public.organizations.show', $organization->slug) }}" class="btn btn-sm btn-outline-primary">View Profile</a>
                    <a href="{{ route('public.jobs.index', ['organization' => $organization->slug]) }}" class="btn btn-sm btn-outline-secondary ms-2">
                        <i class="fas fa-briefcase me-1"></i> {{ $organization->jobs_count ?? $organization->jobs->count() }} Jobs
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
