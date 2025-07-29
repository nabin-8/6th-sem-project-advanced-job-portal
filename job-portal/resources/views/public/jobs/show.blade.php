<x-layout.app>
    <x-slot:title>{{ $job->title }} | Job Portal</x-slot:title>

    <section class="bg-primary text-white py-4">
        <div class="container">
            <x-ui.breadcrumb :items="[
                ['label' => 'Jobs', 'url' => route('public.jobs.index')],
                ['label' => $job->title]
            ]" />
            
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <span class="badge bg-light text-primary mb-2">{{ $job->category ? $job->category->name : 'Uncategorized' }}</span>
                    <h1 class="h2 fw-bold mb-1">{{ $job->title }}</h1>
                    <p class="mb-2">
                        <a href="{{ route('public.organizations.show', $job->organization->slug) }}" class="text-white text-opacity-75 text-decoration-none">
                            <i class="fas fa-building me-1"></i> {{ $job->organization->name }}
                        </a>
                    </p>
                    <div class="d-flex flex-wrap gap-2 mt-3">
                        @if($job->location)
                            <span class="badge bg-white text-dark">
                                <i class="fas fa-map-marker-alt me-1"></i> {{ $job->location }}
                            </span>
                        @endif
                        
                        @if($job->employment_type)
                            <span class="badge bg-white text-dark">
                                <i class="fas fa-clock me-1"></i> {{ $job->employment_type }}
                            </span>
                        @endif
                        
                        @if($job->salary_min && $job->salary_max)
                            <span class="badge bg-white text-success">
                                <i class="fas fa-money-bill-wave me-1"></i> ${{ number_format($job->salary_min) }} - ${{ number_format($job->salary_max) }}
                            </span>
                        @endif
                    </div>
                </div>
                
                <div class="col-lg-4 text-lg-end mt-4 mt-lg-0">
                    <a href="{{ route('public.jobs.apply', $job->slug) }}" class="btn btn-light">Apply Now</a>
                    <button type="button" class="btn btn-outline-light ms-2" 
                            onclick="window.navigator.clipboard.writeText(window.location.href); alert('Link copied to clipboard!')">
                        <i class="fas fa-share-alt"></i> Share
                    </button>
                </div>
            </div>
        </div>
    </section>

    <section class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mb-4 mb-lg-0">
                    <!-- Job Description -->
                    <div class="card mb-4 shadow-sm">
                        <div class="card-header bg-white d-flex justify-content-between align-items-center">
                            <h2 class="h5 mb-0">Job Description</h2>
                            <span class="badge bg-success">
                                <i class="fas fa-clock me-1"></i> Posted {{ $job->created_at->diffForHumans() }}
                            </span>
                        </div>
                        <div class="card-body">
                            <div class="job-description mb-4">
                                {!! nl2br(e($job->description)) !!}
                            </div>
                            
                            @if($job->requirements && is_array($job->requirements) && count($job->requirements) > 0)
                                <h3 class="h5 mb-3">Requirements</h3>
                                <ul class="list-group list-group-flush mb-4">
                                    @foreach($job->requirements as $requirement)
                                        <li class="list-group-item bg-light">
                                            <i class="fas fa-check-circle text-success me-2"></i> {{ $requirement }}
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                            
                            @if($job->application_deadline)
                                <div class="alert alert-warning">
                                    <i class="fas fa-calendar-alt me-2"></i> Application Deadline: <strong>{{ $job->application_deadline->format('F j, Y') }}</strong>
                                    <div class="small mt-1">
                                        {{ now()->diffInDays($job->application_deadline, false) > 0 
                                            ? now()->diffInDays($job->application_deadline) . ' days remaining' 
                                            : 'Deadline passed' }}
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="card-footer bg-white">
                            <div class="d-grid">
                                <a href="{{ route('public.jobs.apply', $job->slug) }}" class="btn btn-primary">
                                    <i class="fas fa-paper-plane me-1"></i> Apply for this Position
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Similar Jobs -->
                    @if($similarJobs && $similarJobs->count() > 0)
                        <div class="card shadow-sm">
                            <div class="card-header bg-white">
                                <h3 class="h5 mb-0">Similar Jobs</h3>
                            </div>
                            <div class="card-body">
                                <div class="row g-3">
                                    @foreach($similarJobs as $similarJob)
                                        <div class="col-md-6">
                                            <div class="card h-100 border-0 shadow-sm">
                                                <div class="card-body">
                                                    <h4 class="h6 mb-1">
                                                        <a href="{{ route('public.jobs.show', $similarJob->slug) }}" class="text-decoration-none">
                                                            {{ $similarJob->title }}
                                                        </a>
                                                    </h4>
                                                    <p class="small text-muted mb-2">{{ $similarJob->organization->name }}</p>
                                                    <div class="d-flex gap-2 flex-wrap">
                                                        @if($similarJob->location)
                                                            <span class="badge bg-light text-dark small">
                                                                <i class="fas fa-map-marker-alt"></i> {{ Str::limit($similarJob->location, 15) }}
                                                            </span>
                                                        @endif
                                                        
                                                        @if($similarJob->employment_type)
                                                            <span class="badge bg-light text-dark small">
                                                                {{ $similarJob->employment_type }}
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
                
                <div class="col-lg-4">
                    <!-- Company Information -->
                    <div class="card mb-4 shadow-sm">
                        <div class="card-header bg-white">
                            <h3 class="h5 mb-0">About the Company</h3>
                        </div>
                        <div class="card-body">
                            <div class="text-center mb-3">
                                @if($job->organization->logo)
                                    <img src="{{ asset('uploads/' . $job->organization->logo) }}" alt="{{ $job->organization->name }}" 
                                         class="mb-3 rounded" style="width: 100px; height: 100px; object-fit: cover;">
                                @else
                                    <div class="bg-light rounded d-inline-flex align-items-center justify-content-center mb-3" style="width: 100px; height: 100px;">
                                        <i class="fas fa-building fa-3x text-muted"></i>
                                    </div>
                                @endif
                                <h4 class="h5 mb-1">{{ $job->organization->name }}</h4>
                                @if($job->organization->industry)
                                    <p class="text-muted small mb-2">{{ $job->organization->industry }}</p>
                                @endif
                                @if($job->organization->website)
                                    <a href="{{ $job->organization->website }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-external-link-alt me-1"></i> Visit Website
                                    </a>
                                @endif
                            </div>
                            
                            @if($job->organization->description)
                                <p class="small">{{ Str::limit($job->organization->description, 200) }}</p>
                            @endif
                            
                            <div class="d-grid mt-3">
                                <a href="{{ route('public.organizations.show', $job->organization->slug) }}" class="btn btn-outline-primary">
                                    View Company Profile
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Job Details Summary -->
                    <div class="card mb-4 shadow-sm">
                        <div class="card-header bg-white">
                            <h3 class="h5 mb-0">Job Details</h3>
                        </div>
                        <ul class="list-group list-group-flush">
                            @if($job->employment_type)
                                <li class="list-group-item d-flex justify-content-between">
                                    <span class="text-muted">Employment Type</span>
                                    <span class="fw-semibold">{{ $job->employment_type }}</span>
                                </li>
                            @endif
                            
                            @if($job->location)
                                <li class="list-group-item d-flex justify-content-between">
                                    <span class="text-muted">Location</span>
                                    <span class="fw-semibold">{{ $job->location }}</span>
                                </li>
                            @endif
                            
                            @if($job->category)
                                <li class="list-group-item d-flex justify-content-between">
                                    <span class="text-muted">Category</span>
                                    <span class="fw-semibold">{{ $job->category->name }}</span>
                                </li>
                            @endif
                            
                            @if($job->created_at)
                                <li class="list-group-item d-flex justify-content-between">
                                    <span class="text-muted">Posted</span>
                                    <span class="fw-semibold">{{ $job->created_at->format('M d, Y') }}</span>
                                </li>
                            @endif
                            
                            @if($job->application_deadline)
                                <li class="list-group-item d-flex justify-content-between">
                                    <span class="text-muted">Deadline</span>
                                    <span class="fw-semibold">{{ $job->application_deadline->format('M d, Y') }}</span>
                                </li>
                            @endif
                        </ul>
                    </div>
                    
                    <!-- Share Job -->
                    <div class="card shadow-sm">
                        <div class="card-header bg-white">
                            <h3 class="h5 mb-0">Share This Job</h3>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-center gap-3">
                                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('public.jobs.show', $job->slug)) }}" 
                                   target="_blank" class="btn btn-outline-primary">
                                    <i class="fab fa-facebook-f"></i>
                                </a>
                                <a href="https://twitter.com/intent/tweet?url={{ urlencode(route('public.jobs.show', $job->slug)) }}&text={{ urlencode($job->title . ' at ' . $job->organization->name) }}" 
                                   target="_blank" class="btn btn-outline-primary">
                                    <i class="fab fa-twitter"></i>
                                </a>
                                <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode(route('public.jobs.show', $job->slug)) }}&title={{ urlencode($job->title) }}&summary={{ urlencode(Str::limit($job->description, 100)) }}" 
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
