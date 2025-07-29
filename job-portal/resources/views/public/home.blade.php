<x-layout.app>
    <x-slot:title>Job Portal - Find Your Dream Job</x-slot:title>

    <!-- Hero Section -->
    <section class="bg-primary text-white py-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-4 mb-lg-0">
                    <h1 class="display-5 fw-bold mb-3">Find Your Dream Job Today</h1>
                    <p class="lead mb-4">Browse thousands of job opportunities from top companies and start your career journey with us.</p>
                    <div class="d-flex flex-wrap gap-2">
                        <a href="{{ route('public.jobs.index') }}" class="btn btn-light btn-lg">Browse Jobs</a>
                        <a href="{{ route('register') }}" class="btn btn-outline-light btn-lg">Create Account</a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <img src="https://images.unsplash.com/photo-1521737852567-6949f3f9f2b5?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1470&q=80" alt="Job searchers" class="img-fluid rounded shadow">
                </div>
            </div>
        </div>
    </section>

    <!-- Job Categories Section -->
    <section class="py-5">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="h2 fw-bold">Popular Job Categories</h2>
                <p class="text-muted">Explore jobs by category</p>
            </div>
            <div class="row g-4">
                @forelse($categories as $category)
                    <div class="col-md-4 col-lg-3">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-body text-center">
                                <div class="mb-3">
                                    <i class="fas fa-briefcase fa-3x text-primary"></i>
                                </div>
                                <h3 class="h5 mb-2">{{ $category->name }}</h3>
                                <p class="text-muted small mb-3">{{ $category->jobs_count ?? $category->jobs->count() }} jobs available</p>
                                <a href="{{ route('public.jobs.index', ['category' => $category->slug]) }}" class="btn btn-sm btn-outline-primary">Browse Jobs</a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center">
                        <p>No categories available at the moment.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Featured Jobs Section -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="h2 fw-bold mb-0">Featured Jobs</h2>
                    <p class="text-muted">Handpicked opportunities just for you</p>
                </div>
                <a href="{{ route('public.jobs.index', ['featured' => 1]) }}" class="btn btn-outline-primary">View All</a>
            </div>
            
            <div class="row">
                <div class="col-12">
                    @forelse($featuredJobs as $job)
                        <x-job.card :job="$job" />
                    @empty
                        <div class="text-center py-5">
                            <p>No featured jobs available at the moment.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Companies Section -->
    <section class="py-5">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="h2 fw-bold mb-0">Top Organizations</h2>
                    <p class="text-muted">Connect with leading companies</p>
                </div>
                <a href="{{ route('public.organizations.index') }}" class="btn btn-outline-primary">View All</a>
            </div>
            
            <div class="row">
                @forelse($organizations as $organization)
                    <div class="col-md-6">
                        <x-organization.card :organization="$organization" />
                    </div>
                @empty
                    <div class="col-12 text-center">
                        <p>No organizations available at the moment.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- How It Works Section -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="h2 fw-bold">How It Works</h2>
                <p class="text-muted">Three simple steps to start your career journey</p>
            </div>
            
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body text-center">
                            <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center mx-auto mb-4" style="width: 80px; height: 80px;">
                                <i class="fas fa-user-plus fa-2x"></i>
                            </div>
                            <h3 class="h5 mb-3">1. Create an Account</h3>
                            <p class="text-muted mb-0">Sign up and complete your profile to start your job search journey.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body text-center">
                            <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center mx-auto mb-4" style="width: 80px; height: 80px;">
                                <i class="fas fa-search fa-2x"></i>
                            </div>
                            <h3 class="h5 mb-3">2. Find the Right Job</h3>
                            <p class="text-muted mb-0">Browse through our extensive job listings and filter according to your preferences.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body text-center">
                            <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center mx-auto mb-4" style="width: 80px; height: 80px;">
                                <i class="fas fa-paper-plane fa-2x"></i>
                            </div>
                            <h3 class="h5 mb-3">3. Apply and Get Hired</h3>
                            <p class="text-muted mb-0">Submit your application with just a few clicks and wait for employers to contact you.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQs Section -->
    <section class="py-5">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="h2 fw-bold">Frequently Asked Questions</h2>
                <p class="text-muted">Find answers to the most common questions</p>
            </div>
            
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <x-ui.faq-accordion :faqs="$faqs" />
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-5 bg-primary text-white">
        <div class="container text-center">
            <h2 class="h2 fw-bold mb-3">Ready to Start Your Career Journey?</h2>
            <p class="lead mb-4">Join thousands of job seekers who have found their dream job through our platform.</p>
            <div class="d-flex flex-wrap justify-content-center gap-3">
                <a href="{{ route('register') }}" class="btn btn-light btn-lg">Create Account</a>
                <a href="{{ route('public.jobs.index') }}" class="btn btn-outline-light btn-lg">Browse Jobs</a>
            </div>
        </div>
    </section>
</x-layout.app>
