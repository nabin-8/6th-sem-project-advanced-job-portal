<header class="bg-primary text-white py-4">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-3 col-md-4 col-6">
                <a href="{{ route('public.home') }}" class="text-white text-decoration-none">
                    <h1 class="h4 m-0 fw-bold">Job Portal</h1>
                </a>
            </div>
            <div class="col-lg-6 col-md-4 d-none d-md-block">
                <nav class="navbar navbar-expand">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link text-white {{ request()->routeIs('public.home') ? 'fw-bold' : '' }}" href="{{ route('public.home') }}">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white {{ request()->routeIs('public.jobs.*') ? 'fw-bold' : '' }}" href="{{ route('public.jobs.index') }}">Jobs</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white {{ request()->routeIs('public.organizations.*') ? 'fw-bold' : '' }}" href="{{ route('public.organizations.index') }}">Organizations</a>
                        </li>
                    </ul>
                </nav>
            </div>
            <div class="col-lg-3 col-md-4 col-6 text-end">
                @auth
                    <div class="dropdown">
                        <button class="btn btn-outline-light dropdown-toggle d-flex align-items-center" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            @if(Auth::user()->profile_photo)
                                <img src="{{ asset('uploads/' . Auth::user()->profile_photo) }}" class="rounded-circle me-2" style="width: 24px; height: 24px; object-fit: cover;">
                            @else
                                <i class="fas fa-user-circle me-1"></i>
                            @endif
                            {{ Auth::user()->name }}
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            <li><a class="dropdown-item" href="{{ route('dashboard') }}"><i class="fas fa-tachometer-alt me-2"></i>Dashboard</a></li>
                            <li><a class="dropdown-item" href="{{ route('profile.show') }}"><i class="fas fa-user me-2"></i>Profile</a></li>
                            
                            @if(auth()->user()->hasRole('Candidate') && session('active_role', 'Candidate') === 'Candidate')
                                <li><a class="dropdown-item" href="{{ route('applications.index') }}"><i class="fas fa-file-alt me-2"></i>My Applications</a></li>
                            @endif
                            
                            @if(auth()->user()->hasRole('Organization') && session('active_role', '') === 'Organization')
                                <li><a class="dropdown-item" href="{{ route('jobs.manage') }}"><i class="fas fa-briefcase me-2"></i>Manage Jobs</a></li>
                            @endif
                            
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item">
                                        <i class="fas fa-sign-out-alt me-2"></i>Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="btn btn-outline-light me-2">Login</a>
                    <a href="{{ route('register') }}" class="btn btn-light">Register</a>
                @endauth
            </div>
        </div>
    </div>
    
    <!-- Mobile Navigation Toggle (for small screens) -->
    <div class="container mt-2 d-md-none">
        <button class="btn btn-outline-light w-100" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileNav">
            <i class="fas fa-bars me-2"></i> Menu
        </button>
    </div>
</header>

<!-- Mobile Navigation Offcanvas -->
<div class="offcanvas offcanvas-start" tabindex="-1" id="mobileNav">
    <div class="offcanvas-header bg-primary text-white">
        <h5 class="offcanvas-title">Job Portal</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('public.home') ? 'fw-bold text-primary' : '' }}" href="{{ route('public.home') }}">
                    <i class="fas fa-home me-2"></i> Home
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('public.jobs.*') ? 'fw-bold text-primary' : '' }}" href="{{ route('public.jobs.index') }}">
                    <i class="fas fa-briefcase me-2"></i> Jobs
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('public.organizations.*') ? 'fw-bold text-primary' : '' }}" href="{{ route('public.organizations.index') }}">
                    <i class="fas fa-building me-2"></i> Organizations
                </a>
            </li>
            <li><hr class="dropdown-divider"></li>
            @auth
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('dashboard') }}">
                        <i class="fas fa-tachometer-alt me-2"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('profile.show') }}">
                        <i class="fas fa-user me-2"></i> Profile
                    </a>
                </li>
                <li class="nav-item">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="nav-link text-danger border-0 bg-transparent w-100 text-start">
                            <i class="fas fa-sign-out-alt me-2"></i> Logout
                        </button>
                    </form>
                </li>
            @else
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('login') }}">
                        <i class="fas fa-sign-in-alt me-2"></i> Login
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('register') }}">
                        <i class="fas fa-user-plus me-2"></i> Register
                    </a>
                </li>
            @endauth
        </ul>
    </div>
</div>
