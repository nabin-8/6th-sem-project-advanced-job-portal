<div class="card mb-4 job-card" id="job-{{ $job->id }}">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-start">
            <div class="d-flex">
                @if($job->organization->logo)
                    <img src="{{ asset('uploads/' . $job->organization->logo) }}" alt="{{ $job->organization->name }}" class="me-3 rounded" style="width: 64px; height: 64px; object-fit: cover;">
                @else
                    <div class="me-3 rounded bg-secondary d-flex align-items-center justify-content-center" style="width: 64px; height: 64px;">
                        <i class="fas fa-building text-white fa-2x"></i>
                    </div>
                @endif
                <div>                    <h2 class="h5 mb-1">
                        <a href="{{ route('public.jobs.show', $job->slug) }}" class="text-decoration-none">{{ $job->title }}</a>
                    </h2>
                    <p class="mb-1">
                        <a href="{{ route('public.organizations.show', $job->organization->slug) }}" class="text-muted text-decoration-none">{{ $job->organization->name }}</a>
                    </p>
                    <div class="d-flex flex-wrap mt-2">
                        @if($job->location)
                            <span class="badge bg-light text-dark me-2 mb-1">
                                <i class="fas fa-map-marker-alt me-1"></i> {{ $job->location }}
                            </span>
                        @endif
                        
                        @if($job->employment_type)
                            <span class="badge bg-light text-dark me-2 mb-1">
                                <i class="fas fa-clock me-1"></i> {{ $job->employment_type }}
                            </span>
                        @endif
                        
                        @if($job->category)
                            <span class="badge bg-light text-dark me-2 mb-1">
                                <i class="fas fa-tag me-1"></i> {{ $job->category->name }}
                            </span>
                        @endif
                        
                        @if($job->is_featured)
                            <span class="badge bg-warning text-dark mb-1">
                                <i class="fas fa-star me-1"></i> Featured
                            </span>
                        @endif
                    </div>
                </div>
            </div>
            <div class="text-end">
                @if($job->salary_min && $job->salary_max)
                    <div class="text-success fw-bold mb-2">
                        ${{ number_format($job->salary_min) }} - ${{ number_format($job->salary_max) }}
                    </div>
                @endif
                
                @if($job->application_deadline)
                    <div class="small text-muted mb-2">
                        <i class="far fa-calendar-alt me-1"></i> Deadline: {{ $job->application_deadline->format('M d, Y') }}
                    </div>
                @endif
                
                <a href="{{ route('public.jobs.show', $job->slug) }}" class="btn btn-sm btn-outline-primary">View Details</a>
            </div>
        </div>
    </div>
</div>
