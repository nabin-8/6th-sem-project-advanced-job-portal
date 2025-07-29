<nav class="navbar navbar-expand-lg navbar-light bg-white sticky-top">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="{{ route('home') }}">
            <div class="me-2">
                <div class="rounded-circle d-flex align-items-center justify-content-center"
                    style="width: 35px; height: 35px;">
                    <img src="{{ asset('uploads/assets/logo_blue.svg') }}" alt="Logo" class="img-fluid"
                        style="max-width: 100%; max-height: 100%;">
                    {{-- <span class="text-white fw-bold">J</span> --}}
                </div>
            </div>
            <span>{{ config('app.name', 'Job Portal') }}</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">
                        <i class="fas fa-home me-1"></i> Home
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('jobs.index') ? 'active' : '' }}"
                        href="{{ route('jobs.index') }}">
                        <i class="fas fa-briefcase me-1"></i> Jobs
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}" href="{{ route('about') }}">
                        <i class="fas fa-info-circle me-1"></i> About
                    </a>
                </li>
            </ul>

            <div class="header-actions d-flex align-items-center">
                @guest
                    <a href="{{ route('login') }}" class="btn btn-outline-primary me-2">
                        <i class="fas fa-sign-in-alt me-1"></i> Login
                    </a>
                    <a href="{{ route('register') }}" class="btn btn-primary">
                        <i class="fas fa-user-plus me-1"></i> Register
                    </a>
                @else
                    <!-- Role switcher if user has multiple roles and has setup both profiles -->
                    @php
                        $user = auth()->user();
                        $hasCandidateRole = $user->hasRole('Candidate');
                        $hasOrgRole = $user->hasRole('Organization');
                        $hasCandidateProfile =
                            $hasCandidateRole && $user->candidateProfile && $user->candidateProfile->exists();
                        $hasOrgProfile =
                            $hasOrgRole && $user->organizationProfile && $user->organizationProfile->exists();
                        $showSwitcher = $hasCandidateRole && $hasOrgRole && $hasCandidateProfile && $hasOrgProfile;
                    @endphp

                    @if ($showSwitcher)
                        @include('partials.role-switcher')
                    @endif
                    <div class="dropdown">
                        <button class="btn btn-outline-primary dropdown-toggle d-flex align-items-center" type="button"
                            id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                            @if (Auth::user()->profile_photo)
                                <img src="{{ asset('uploads/' . Auth::user()->profile_photo) }}" alt="Profile Photo"
                                    class="rounded-circle me-2"
                                    style="width: 30px; height: 30px; object-fit: cover; border: 2px solid var(--primary-color);">
                            @else
                                <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-2"
                                    style="width: 30px; height: 30px;">
                                    <i class="fas fa-user"></i>
                                </div>
                            @endif
                            {{ Auth::user()->name }}
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                            <li><a class="dropdown-item" href="{{ route('dashboard') }}"><i
                                        class="fas fa-tachometer-alt me-2"></i>Dashboard</a></li>
                            <li><a class="dropdown-item" href="{{ route('profile.show') }}"><i
                                        class="fas fa-user me-2"></i>Profile</a></li>

                            @if (auth()->user()->hasRole('Candidate') && session('active_role', 'Candidate') === 'Candidate')
                                <li><a class="dropdown-item" href="{{ route('applications.index') }}"><i
                                            class="fas fa-file-alt me-2"></i>My Applications</a></li>
                            @endif

                            @if (auth()->user()->hasRole('Organization') && session('active_role', '') === 'Organization')
                                <li><a class="dropdown-item" href="{{ route('jobs.manage') }}"><i
                                            class="fas fa-briefcase me-2"></i>Manage Jobs</a></li>
                            @endif

                            <li>
                                <hr class="dropdown-divider">
                            </li>
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
                @endguest
            </div>
        </div>
    </div>
</nav>
