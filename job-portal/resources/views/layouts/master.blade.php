<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Job Portal') }} - @yield('title')</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Custom styles -->
    <style>
        body {
            font-family: 'Nunito', sans-serif;
            background-color: #f8f9fa;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        .navbar {
            background-color: #343a40;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .navbar-brand {
            font-weight: bold;
            color: #fff !important;
        }
        .nav-link {
            color: rgba(255,255,255,0.8) !important;
        }
        .nav-link:hover {
            color: #fff !important;
        }
        .dropdown-menu {
            border-radius: 0.25rem;
            box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.15);
        }
        .header-actions .btn {
            margin-left: 0.5rem;
        }
        footer {
            margin-top: auto;
            background-color: #343a40;
            color: #fff;
            padding: 1.5rem 0;
        }
        .footer-links a {
            color: rgba(255,255,255,0.8);
            text-decoration: none;
            margin-right: 1rem;
        }
        .footer-links a:hover {
            color: #fff;
        }
        .main-content {
            padding: 2rem 0;
            flex: 1;
        }
        .profile-completion-alert {
            margin-bottom: 1rem;
        }
        .job-card {
            height: 100%;
            transition: transform 0.3s ease;
        }
        .job-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.15);
        }
        .dashboard-stats .card {
            height: 100%;
            border-left: 4px solid #007bff;
        }
        .stats-icon {
            font-size: 2rem;
            color: #007bff;
        }
    </style>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    @stack('styles')
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">{{ config('app.name', 'Job Portal') }}</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('jobs.index') ? 'active' : '' }}" href="{{ route('jobs.index') }}">Jobs</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}" href="{{ route('about') }}">About</a>
                    </li>
                </ul>
                
                <div class="header-actions d-flex align-items-center">                    @guest
                        <a href="{{ route('login') }}" class="btn btn-outline-light btn-sm">Login</a>
                        <a href="{{ route('register') }}" class="btn btn-light btn-sm">Register</a>
                    @else
                        <!-- Role switcher if user has multiple roles and has setup both profiles -->
                        @php
                            $user = auth()->user();
                            $hasCandidateRole = $user->hasRole('Candidate');
                            $hasOrgRole = $user->hasRole('Organization');
                            $hasCandidateProfile = $hasCandidateRole && $user->candidateProfile && $user->candidateProfile->exists();
                            $hasOrgProfile = $hasOrgRole && $user->organizationProfile && $user->organizationProfile->exists();
                            $showSwitcher = ($hasCandidateRole && $hasOrgRole && $hasCandidateProfile && $hasOrgProfile);
                        @endphp
                        
                        @if($showSwitcher)
                            @include('partials.role-switcher')
                        @endif
                        
                        <div class="dropdown">
                            <button class="btn btn-outline-light dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-user-circle me-1"></i> {{ Auth::user()->name }}
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
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
                    @endguest
                </div>
            </div>
        </div>
    </nav>

    <!-- Main content area -->
    <div class="main-content">
        <div class="container">
            <!-- Flash messages -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            
            <!-- Profile completion alert for logged in users -->
            @auth
                @if(auth()->user()->hasRole('Candidate') && session('active_role', '') === 'Candidate' && !auth()->user()->candidateProfile->is_complete)
                    <div class="alert alert-warning profile-completion-alert">
                        <i class="fas fa-exclamation-triangle me-2"></i> Your candidate profile is incomplete. Please <a href="{{ route('profile.edit') }}" class="alert-link">complete your profile</a> to apply for jobs.
                    </div>
                @endif
                
                @if(auth()->user()->hasRole('Organization') && session('active_role', '') === 'Organization' && !auth()->user()->organizationProfile->is_complete)
                    <div class="alert alert-warning profile-completion-alert">
                        <i class="fas fa-exclamation-triangle me-2"></i> Your organization profile is incomplete. Please <a href="{{ route('profile.edit') }}" class="alert-link">complete your profile</a> to post jobs.
                    </div>
                @endif
            @endauth
            
            <!-- Page header -->
            <div class="mb-4">
                @yield('page-header')
            </div>
            
            <!-- Page content -->
            @yield('content')
        </div>
    </div>
    
    <!-- Footer -->
    <footer class="footer mt-auto">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h5>{{ config('app.name', 'Job Portal') }}</h5>
                    <p class="text-amber-100">Connecting talent with opportunities</p>
                </div>
                <div class="col-md-6">
                    <div class="footer-links text-md-end">
                        <a href="{{ route('home') }}">Home</a>
                        <a href="{{ route('jobs.index') }}">Jobs</a>
                        <a href="{{ route('about') }}">About</a>
                        @guest
                            <a href="{{ route('login') }}">Login</a>
                            <a href="{{ route('register') }}">Register</a>
                        @endguest
                    </div>
                    <p class="text-amber-100 text-md-end mt-2">© {{ date('Y') }} {{ config('app.name', 'Job Portal') }}. All rights reserved.</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Vanilla JS for minimal interactivity -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Auto-dismiss alerts after 5 seconds
            const alerts = document.querySelectorAll('.alert-dismissible');
            alerts.forEach(function(alert) {
                setTimeout(function() {
                    const closeButton = alert.querySelector('.btn-close');
                    if (closeButton) {
                        closeButton.click();
                    }
                }, 5000);
            });
        });
    </script>
    
    @stack('scripts')
</body>
</html>