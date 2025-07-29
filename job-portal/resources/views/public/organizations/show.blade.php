<x-layout.app>
    <x-slot:title>{{ $organization->name }} | Job Portal</x-slot:title>

    <section class="bg-primary text-white py-4">
        <div class="container">
            <x-ui.breadcrumb :items="[
                ['label' => 'Organizations', 'url' => route('public.organizations.index')],
                ['label' => $organization->name]
            ]" />
            
            <div class="row align-items-center">
                <div class="col-lg-2 col-md-3 col-4 mb-3 mb-lg-0 text-center">
                    @if($organization->logo)
                        <img src="{{ asset('uploads/' . $organization->logo) }}" alt="{{ $organization->name }}" 
                             class="img-fluid rounded" style="max-width: 120px; max-height: 120px; object-fit: cover;">
                    @else
                        <div class="bg-white rounded d-inline-flex align-items-center justify-content-center" style="width: 120px; height: 120px;">
                            <i class="fas fa-building fa-3x text-muted"></i>
                        </div>
                    @endif
                </div>
                <div class="col-lg-7 col-md-9 col-8">
                    <h1 class="h2 fw-bold mb-1">{{ $organization->name }}</h1>
                    @if($organization->industry)
                        <p class="mb-2">
                            <i class="fas fa-industry me-1"></i> {{ $organization->industry }}
                        </p>
                    @endif
                    @if($organization->location)
                        <p class="mb-2">
                            <i class="fas fa-map-marker-alt me-1"></i> {{ $organization->location }}
                        </p>
                    @endif
                </div>
                <div class="col-lg-3 mt-3 mt-lg-0 text-lg-end">
                    @if($organization->website)
                        <a href="{{ $organization->website }}" target="_blank" class="btn btn-light mb-2">
                            <i class="fas fa-external-link-alt me-1"></i> Visit Website
                        </a>
                    @endif
                    
                    <div class="d-flex gap-2 mt-2 justify-content-lg-end">
                        @if($organization->facebook)
                            <a href="{{ $organization->facebook }}" target="_blank" class="btn btn-sm btn-outline-light">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                        @endif
                        @if($organization->twitter)
                            <a href="{{ $organization->twitter }}" target="_blank" class="btn btn-sm btn-outline-light">
                                <i class="fab fa-twitter"></i>
                            </a>
                        @endif
                        @if($organization->linkedin)
                            <a href="{{ $organization->linkedin }}" target="_blank" class="btn btn-sm btn-outline-light">
                                <i class="fab fa-linkedin-in"></i>
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-5">
        <div class="container">
            <div class="row">
                <!-- Main Content -->
                <div class="col-lg-8 mb-4 mb-lg-0">
                    <!-- About Organization -->
                    <div class="card mb-4 shadow-sm">
                        <div class="card-header bg-white">
                            <h2 class="h5 mb-0">About {{ $organization->name }}</h2>
                        </div>
                        <div class="card-body">
                            @if($organization->description)
                                <div class="mb-4">
                                    {!! nl2br(e($organization->description)) !!}
                                </div>
                            @else
                                <p class="text-muted">No description available.</p>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Current Job Openings -->
                    <div class="card shadow-sm">
                        <div class="card-header bg-white d-flex justify-content-between align-items-center">
                            <h2 class="h5 mb-0">Current Job Openings</h2>
                            <span class="badge bg-primary">{{ $jobs->total() }} Jobs</span>
                        </div>
                        <div class="card-body">
                            @forelse($jobs as $job)
                                <div class="card mb-3 border-0 shadow-sm">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div>
                                                <h3 class="h6 mb-1">
                                                    <a href="{{ route('public.jobs.show', $job->slug) }}" class="text-decoration-none">{{ $job->title }}</a>
                                                </h3>
                                                <div class="d-flex flex-wrap gap-2 mt-2">
                                                    @if($job->location)
                                                        <span class="badge bg-light text-dark small">
                                                            <i class="fas fa-map-marker-alt"></i> {{ $job->location }}
                                                        </span>
                                                    @endif
                                                    
                                                    @if($job->employment_type)
                                                        <span class="badge bg-light text-dark small">
                                                            <i class="fas fa-clock"></i> {{ $job->employment_type }}
                                                        </span>
                                                    @endif
                                                    
                                                    @if($job->created_at)
                                                        <span class="badge bg-light text-dark small">
                                                            <i class="fas fa-calendar"></i> Posted {{ $job->created_at->diffForHumans() }}
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                            <a href="{{ route('public.jobs.show', $job->slug) }}" class="btn btn-sm btn-outline-primary">View</a>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-4">
                                    <i class="fas fa-briefcase fa-3x text-muted mb-3"></i>
                                    <h3 class="h5">No job openings</h3>
                                    <p class="text-muted">This organization doesn't have any active job listings at the moment.</p>
                                </div>
                            @endforelse
                            
                            <!-- Pagination -->
                            <div class="mt-4">
                                {{ $jobs->links('components.ui.pagination') }}
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Sidebar -->
                <div class="col-lg-4">
                    <!-- Organization Details -->
                    <div class="card mb-4 shadow-sm">
                        <div class="card-header bg-white">
                            <h3 class="h5 mb-0">Company Details</h3>
                        </div>
                        <ul class="list-group list-group-flush">
                            @if($organization->industry)
                                <li class="list-group-item d-flex justify-content-between">
                                    <span class="text-muted">Industry</span>
                                    <span class="fw-semibold">{{ $organization->industry }}</span>
                                </li>
                            @endif
                            
                            @if($organization->size)
                                <li class="list-group-item d-flex justify-content-between">
                                    <span class="text-muted">Company Size</span>
                                    <span class="fw-semibold">{{ $organization->size }}</span>
                                </li>
                            @endif
                            
                            @if($organization->founded_year)
                                <li class="list-group-item d-flex justify-content-between">
                                    <span class="text-muted">Founded</span>
                                    <span class="fw-semibold">{{ $organization->founded_year }}</span>
                                </li>
                            @endif
                            
                            @if($organization->location)
                                <li class="list-group-item d-flex justify-content-between">
                                    <span class="text-muted">Headquarters</span>
                                    <span class="fw-semibold">{{ $organization->location }}</span>
                                </li>
                            @endif
                            
                            @if($organization->website)
                                <li class="list-group-item">
                                    <span class="text-muted">Website</span>
                                    <div class="mt-1">
                                        <a href="{{ $organization->website }}" target="_blank" class="text-decoration-none">
                                            {{ $organization->website }}
                                        </a>
                                    </div>
                                </li>
                            @endif
                        </ul>
                    </div>
                    
                    <!-- Share Organization Profile -->
                    <div class="card shadow-sm">
                        <div class="card-header bg-white">
                            <h3 class="h5 mb-0">Share this Company</h3>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-center gap-3">
                                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('public.organizations.show', $organization->slug)) }}" 
                                   target="_blank" class="btn btn-outline-primary">
                                    <i class="fab fa-facebook-f"></i>
                                </a>
                                <a href="https://twitter.com/intent/tweet?url={{ urlencode(route('public.organizations.show', $organization->slug)) }}&text={{ urlencode('Check out ' . $organization->name . ' on Job Portal') }}" 
                                   target="_blank" class="btn btn-outline-primary">
                                    <i class="fab fa-twitter"></i>
                                </a>
                                <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode(route('public.organizations.show', $organization->slug)) }}&title={{ urlencode($organization->name) }}" 
                                   target="_blank" class="btn btn-outline-primary">
                                    <i class="fab fa-linkedin-in"></i>
                                </a>
                                <button type="button" class="btn btn-outline-primary" 
                                        onclick="window.navigator.clipboard.writeText(window.location.href); alert('Link copied to clipboard!')">
                                    <i class="fas fa-link"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-layout.app>
