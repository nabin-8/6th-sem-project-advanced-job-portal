<x-layout.app>
    <x-slot:title>Organizations | Job Portal</x-slot:title>

    <section class="bg-primary text-white py-4">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h1 class="h3 fw-bold mb-0">Browse Organizations</h1>
                    <p class="lead mb-0">Discover great companies hiring now</p>
                </div>
                <div class="col-lg-6">
                    <form action="{{ route('public.organizations.index') }}" method="GET" class="mt-3 mt-lg-0">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Search organizations..." name="search" value="{{ request('search') }}">
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
                            <h3 class="h5 mb-0">Filter Organizations</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('public.organizations.index') }}" method="GET">
                                @if(request('search'))
                                    <input type="hidden" name="search" value="{{ request('search') }}">
                                @endif
                                
                                <!-- Industries Filter -->
                                <div class="mb-4">
                                    <label class="form-label fw-bold">Industries</label>
                                    @php
                                        $industries = [
                                            'Technology', 'Finance', 'Healthcare', 'Education', 
                                            'Manufacturing', 'Retail', 'Hospitality', 'Construction',
                                            'Media', 'Transportation', 'Energy', 'Real Estate'
                                        ];
                                    @endphp
                                    
                                    @foreach($industries as $industry)
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="industries[]" 
                                                   value="{{ $industry }}" id="{{ Str::slug($industry) }}"
                                                   {{ in_array($industry, request('industries', [])) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="{{ Str::slug($industry) }}">
                                                {{ $industry }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                                
                                <!-- Company Size Filter -->
                                <div class="mb-4">
                                    <label class="form-label fw-bold">Company Size</label>
                                    @php
                                        $companySizes = [
                                            'Startup (1-10)', 
                                            'Small (11-50)', 
                                            'Medium (51-200)',
                                            'Large (201-500)',
                                            'Enterprise (500+)'
                                        ];
                                    @endphp
                                    
                                    @foreach($companySizes as $size)
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="sizes[]" 
                                                   value="{{ $size }}" id="{{ Str::slug($size) }}"
                                                   {{ in_array($size, request('sizes', [])) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="{{ Str::slug($size) }}">
                                                {{ $size }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                                
                                <!-- Location Filter -->
                                <div class="mb-4">
                                    <label class="form-label fw-bold">Location</label>
                                    <input type="text" class="form-control" name="location" placeholder="City, Country" 
                                           value="{{ request('location') }}">
                                </div>
                                
                                <!-- Filter Actions -->
                                <div class="d-grid gap-2">
                                    <button type="submit" class="btn btn-primary">Apply Filters</button>
                                    <a href="{{ route('public.organizations.index') }}" class="btn btn-outline-secondary">Clear All</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                
                <!-- Organization Listings -->
                <div class="col-lg-9">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h2 class="h4 mb-1">{{ $organizations->total() }} Organizations Found</h2>
                            @if(request('search') || request('industries') || request('sizes') || request('location'))
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
                                Sort By: {{ request('sort', 'Name') }}
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="sortDropdown">
                                <li><a class="dropdown-item {{ request('sort') == 'Name' ? 'active' : '' }}" 
                                      href="{{ request()->fullUrlWithQuery(['sort' => 'Name']) }}">Name</a></li>
                                <li><a class="dropdown-item {{ request('sort') == 'Most Jobs' ? 'active' : '' }}" 
                                      href="{{ request()->fullUrlWithQuery(['sort' => 'Most Jobs']) }}">Most Jobs</a></li>
                                <li><a class="dropdown-item {{ request('sort') == 'Newest' ? 'active' : '' }}" 
                                      href="{{ request()->fullUrlWithQuery(['sort' => 'Newest']) }}">Newest</a></li>
                            </ul>
                        </div>
                    </div>
                    
                    <!-- Organization Listings -->
                    @forelse($organizations as $organization)
                        <x-organization.card :organization="$organization" />
                    @empty
                        <div class="card">
                            <div class="card-body text-center py-5">
                                <i class="fas fa-search fa-3x text-muted mb-3"></i>
                                <h3 class="h5">No organizations found</h3>
                                <p class="mb-0">Try adjusting your search or filter criteria</p>
                                <a href="{{ route('public.organizations.index') }}" class="btn btn-outline-primary mt-3">Clear All Filters</a>
                            </div>
                        </div>
                    @endforelse
                    
                    <!-- Pagination -->
                    <div class="mt-4">
                        {{ $organizations->withQueryString()->links('components.ui.pagination') }}
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-layout.app>
