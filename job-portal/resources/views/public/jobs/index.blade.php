<x-layout.app>
    <x-slot:title>Browse Jobs | Job Portal</x-slot:title>

    <section class="bg-primary text-white py-4">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h1 class="h3 fw-bold mb-0">Browse Jobs</h1>
                    <p class="lead mb-0">Find the perfect opportunity for your career</p>
                </div>
                <div class="col-lg-6">
                    <form action="{{ route('public.jobs.index') }}" method="GET" class="mt-3 mt-lg-0">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Search jobs..." name="search" value="{{ request('search') }}">
                            <button class="btn btn-light" type="submit">
                                <i class="fas fa-search"></i> Search
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <section class="py-5">
        <div class="container">
            <div class="row">
                <!-- Filters Sidebar -->
                <div class="col-lg-3 mb-4 mb-lg-0">
                    <div class="card shadow-sm">
                        <div class="card-header bg-white">
                            <h3 class="h5 mb-0">Filter Jobs</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('public.jobs.index') }}" method="GET">
                                @if(request('search'))
                                    <input type="hidden" name="search" value="{{ request('search') }}">
                                @endif
                                
                                <!-- Categories Filter -->
                                <div class="mb-4">
                                    <label class="form-label fw-bold">Categories</label>
                                    @foreach($categories as $category)
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="categories[]" 
                                                   value="{{ $category->id }}" id="category{{ $category->id }}"
                                                   {{ in_array($category->id, request('categories', [])) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="category{{ $category->id }}">
                                                {{ $category->name }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                                
                                <!-- Employment Type Filter -->
                                <div class="mb-4">
                                    <label class="form-label fw-bold">Employment Type</label>
                                    @php
                                        $employmentTypes = ['Full-time', 'Part-time', 'Contract', 'Temporary', 'Internship', 'Remote'];
                                    @endphp
                                    
                                    @foreach($employmentTypes as $type)
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="employment_types[]" 
                                                   value="{{ $type }}" id="{{ Str::slug($type) }}"
                                                   {{ in_array($type, request('employment_types', [])) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="{{ Str::slug($type) }}">
                                                {{ $type }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                                
                                <!-- Salary Range Filter -->
                                <div class="mb-4">
                                    <label class="form-label fw-bold">Salary Range</label>
                                    <div class="row g-2">
                                        <div class="col-6">
                                            <input type="number" class="form-control form-control-sm" name="min_salary" 
                                                   placeholder="Min" value="{{ request('min_salary') }}">
                                        </div>
                                        <div class="col-6">
                                            <input type="number" class="form-control form-control-sm" name="max_salary" 
                                                   placeholder="Max" value="{{ request('max_salary') }}">
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Location Filter -->
                                <div class="mb-4">
                                    <label class="form-label fw-bold">Location</label>
                                    <input type="text" class="form-control" name="location" placeholder="City, Country" 
                                           value="{{ request('location') }}">
                                </div>
                                
                                <!-- Featured Jobs Only -->
                                <div class="form-check mb-4">
                                    <input class="form-check-input" type="checkbox" name="featured" id="featuredOnly" 
                                           value="1" {{ request('featured') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="featuredOnly">
                                        Featured Jobs Only
                                    </label>
                                </div>
                                
                                <!-- Filter Actions -->
                                <div class="d-grid gap-2">
                                    <button type="submit" class="btn btn-primary">Apply Filters</button>
                                    <a href="{{ route('public.jobs.index') }}" class="btn btn-outline-secondary">Clear All</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                
                <!-- Job Listings -->
                <div class="col-lg-9">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h2 class="h4 mb-1">{{ $jobs->total() }} Jobs Found</h2>
                            @if(request('search') || request('categories') || request('employment_types') || request('location'))
                                <p class="text-muted mb-0 small">
                                    Filtered results
                                    @if(request('search'))
                                        for "{{ request('search') }}"
                                    @endif
                                </p>
                            @endif
                        </div>
                        
                        <div class="dropdown">
                            <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="sortDropdown" 
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                Sort By: {{ request('sort', 'Newest') }}
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="sortDropdown">
                                <li><a class="dropdown-item {{ request('sort') == 'Newest' ? 'active' : '' }}" 
                                      href="{{ request()->fullUrlWithQuery(['sort' => 'Newest']) }}">Newest</a></li>
                                <li><a class="dropdown-item {{ request('sort') == 'Oldest' ? 'active' : '' }}" 
                                      href="{{ request()->fullUrlWithQuery(['sort' => 'Oldest']) }}">Oldest</a></li>
                                <li><a class="dropdown-item {{ request('sort') == 'Salary: High to Low' ? 'active' : '' }}" 
                                      href="{{ request()->fullUrlWithQuery(['sort' => 'Salary: High to Low']) }}">Salary: High to Low</a></li>
                                <li><a class="dropdown-item {{ request('sort') == 'Salary: Low to High' ? 'active' : '' }}" 
                                      href="{{ request()->fullUrlWithQuery(['sort' => 'Salary: Low to High']) }}">Salary: Low to High</a></li>
                            </ul>
                        </div>
                    </div>
                    
                    <!-- Job Listings -->
                    @forelse($jobs as $job)
                        <x-job.card :job="$job" />
                    @empty
                        <div class="card">
                            <div class="card-body text-center py-5">
                                <i class="fas fa-search fa-3x text-muted mb-3"></i>
                                <h3 class="h5">No jobs found</h3>
                                <p class="mb-0">Try adjusting your search or filter criteria</p>
                                <a href="{{ route('public.jobs.index') }}" class="btn btn-outline-primary mt-3">Clear All Filters</a>
                            </div>
                        </div>
                    @endforelse
                    
                    <!-- Pagination -->
                    <div class="mt-4">
                        {{ $jobs->withQueryString()->links('components.ui.pagination') }}
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-layout.app>
