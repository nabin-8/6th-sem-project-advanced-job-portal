<!-- Recent Jobs -->
  <section class="py-5 bg-light">
    <div class="container">
      <h2 class="fw-bold text-center mb-3">Recently Posted Jobs</h2>
      <p class="text-muted text-center mb-5">The latest opportunities</p>
      <div class="row g-4">
        @foreach($recentJobs as $job)
        <div class="col-md-6">
          <div class="job-card p-4 shadow-sm h-100">
            <div class="d-flex align-items-center mb-3">
              <div class="flex-shrink-0">
                @if($job->organization->logo)
                  <img src="{{ asset('uploads/' . $job->organization->logo) }}" class="rounded-circle" width="50" height="50" alt="Logo">
                @else
                  <i class="fas fa-building fa-2x text-secondary"></i>
                @endif
              </div>
              <div class="flex-grow-1 ms-3">
                <h6 class="mb-0">{{ $job->title }}</h6>
                <small class="text-secondary">{{ $job->organization->name }}</small>
              </div>
            </div>
            <div class="mb-3">
              <span class="badge bg-light text-dark me-1"><i class="fas fa-map-marker-alt"></i> {{ $job->location }}</span>
              <span class="badge bg-light text-dark me-1"><i class="fas fa-clock"></i> {{ ucfirst($job->employment_type) }}</span>
              @if($job->salary_range)
                <span class="badge bg-light text-dark"><i class="fas fa-money-bill"></i> {{ $job->salary_range }}</span>
              @endif
            </div>
            <p class="small text-muted">{{ Str::limit($job->description, 100) }}</p>
            <div class="d-flex justify-content-between align-items-center">
              <span class="badge {{ $job->is_featured ? 'bg-primary' : 'bg-success' }}">{{ $job->is_featured ? 'Featured':'New' }}</span>
              <small class="text-muted">{{ $job->created_at->diffForHumans() }}</small>
            </div>
          </div>
        </div>
        @endforeach
      </div>
    </div>
  </section>

  <!-- Hero Section -->
  <section class="hero">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-lg-6">
          <h1 class="display-4 fw-semibold mb-3">Find Your Career & Make a Better Life</h1>
          <p class="lead text-secondary mb-4">Creating a beautiful job website is not always easy. To make your life easier, we are introducing the JobCamp template.</p>
          <a href="{{ route('jobs.index') }}" class="btn btn-primary btn-lg me-3">Browse Jobs</a>
          <a href="{{ route('register') }}" class="btn btn-outline-secondary btn-lg">Create Account</a>
        </div>
        <div class="col-lg-6 text-center">
          <img src="{{ asset('images/job-illustration.svg') }}" alt="Job Search Illustration" class="img-fluid" style="max-height: 350px;">
        </div>
      </div>
    </div>
  </section>

  <!-- Steps Section -->
  <section class="py-5">
    <div class="container">
      <div class="row text-center">
        @foreach([['fa-user-plus','Register your Account'], ['fa-id-card','Complete Profile'], ['fa-paper-plane','Apply for Dream Job']] as $step)
          <div class="col-md-4 mb-4">
            <div class="step-circle text-primary">
              <i class="fas {{ $step[0] }} fa-2x"></i>
            </div>
            <h5 class="mt-2">{{ $step[1] }}</h5>
          </div>
        @endforeach
      </div>
    </div>
  </section>