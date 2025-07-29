<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Job Portal') }} - @yield('title')</title>
    <link rel="icon" href="{{ asset('uploads/assets/favicon.ico') }}" style="background-color: white;" type="image/x-icon">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('dist-front/css/bootstrap.min.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('dist-front/css/all.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Custom styles -->
    <style>
        :root {
            --primary-color: #0056b3;
            --secondary-color: #1a1a1a;
            --light-bg: #f8f9fa;
            --border-radius: 4px;
            --box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
            --transition: all 0.25s ease;
        }

        body {
            font-family: 'Inter', 'Segoe UI', sans-serif;
            background-color: var(--light-bg);
            /* min-height: 100vh; */
            display: flex;
            flex-direction: column;
            color: #333;
            line-height: 1.6;
        }

        .navbar {
            background-color: #ffffff;
            box-shadow: var(--box-shadow);
            padding: 0.8rem 0;
        }

        .navbar-brand {
            font-weight: 700;
            color: var(--secondary-color) !important;
            font-size: 1.4rem;
        }

        .nav-link {
            color: #333 !important;
            font-weight: 500;
            padding: 0.5rem 1rem;
            transition: var(--transition);
        }

        .nav-link:hover,
        .nav-link.active {
            color: var(--primary-color) !important;
        }

        .dropdown-menu {
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            border: none;
            padding: 0.5rem 0;
        }

        .dropdown-item {
            padding: 0.5rem 1.5rem;
            transition: var(--transition);
        }

        .dropdown-item:hover {
            background-color: rgba(0, 86, 179, 0.05);
        }

        .btn {
            border-radius: var(--border-radius);
            font-weight: 500;
            padding: 0.5rem 1.25rem;
            transition: var(--transition);
        }

        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            color: #fff;
        }

        .btn-primary:hover,
        .btn-primary:focus {
            background-color: #004494;
            border-color: #004494;
            transform: translateY(-2px);
        }

        .btn-outline-primary {
            color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .btn-outline-primary:hover {
            background-color: var(--primary-color);
            color: #fff;
            transform: translateY(-2px);
        }

        .hover-shadow {
            transition: var(--transition);
        }

        .hover-shadow:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1) !important;
        }

        .header-actions .btn {
            margin-left: 0.5rem;
        }

        footer {
            margin-top: auto;
            /* position: static; */
            background-color: var(--secondary-color);
            color: #fff;
            padding: 3rem 0 1rem;
        }

        .hover-text-primary:hover {
            color: var(--primary-color) !important;
        }

        .main-content {
            padding: 2rem 0;
            flex: 1;
        }

        .card {
            border: none;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            transition: var(--transition);
            overflow: hidden;
        }

        .card-header {
            background-color: #fff;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            padding: 1rem 1.25rem;
        }

        .text-primary {
            color: var(--primary-color) !important;
        }

        .bg-primary {
            background-color: var(--primary-color) !important;
        }

        .profile-completion-alert {
            margin-bottom: 1rem;
            border-radius: var(--border-radius);
            background-color: #fff3cd;
            border-left: 4px solid #ffc107;
            box-shadow: var(--box-shadow);
        }

        .job-card {
            height: 100%;
            transition: var(--transition);
            border-radius: var(--border-radius);
        }

        .job-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .dashboard-stats .card {
            height: 100%;
            border-left: 4px solid var(--primary-color);
        }

        .stats-icon {
            font-size: 1.75rem;
            color: var(--primary-color);
        }

        .rounded-lg {
            border-radius: 8px !important;
        }

        .transition-all {
            transition: var(--transition);
        }

        .bg-opacity-10 {
            opacity: 0.1;
        }

        .opacity-10 {
            opacity: 0.1;
        }

        .opacity-75 {
            opacity: 0.75;
        }

        .opacity-90 {
            opacity: 0.9;
        }

        /* Form elements */
        .form-control,
        .form-select {
            padding: 0.6rem 1rem;
            border-radius: var(--border-radius);
            border: 1px solid #e1e1e1;
            box-shadow: none;
            transition: var(--transition);
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(0, 86, 179, 0.15);
        }

        /* Badge styling */
        .badge {
            padding: 0.5rem 1rem;
            font-weight: 500;
        }

        .badge.rounded-pill {
            padding: 0.5rem 1.25rem;
        }

        /* Section headings */
        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-weight: 600;
            color: var(--secondary-color);
        }

        /* Custom gradients */
        .bg-gradient-primary {
            background: linear-gradient(135deg, var(--primary-color), #007bff);
        }

        /* Clean and professional table styles */
        table {
            background: #fff;
            border-radius: var(--border-radius);
            border-collapse: collapse;
            width: 100%;
        }

        th {
            font-weight: 600;
            background-color: #f8f9fa;
            color: var(--secondary-color);
        }

        th,
        td {
            padding: 1rem;
            text-align: left;
            border-bottom: 1px solid #f1f1f1;
        }

        tr:last-child td {
            border-bottom: none;
        }
    </style>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')
</head>

<body>
    <!-- Navbar -->
    @include('layouts.navbar')
    <!-- Main content area -->
    <div class="main-content">
        <div class="container">
            <!-- Flash messages -->
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- Profile completion alert for logged in users -->
            @auth
                @if (auth()->user()->hasRole('Candidate') &&
                        session('active_role', '') === 'Candidate' &&
                        !auth()->user()->candidateProfile->is_complete)
                    <div class="alert alert-warning profile-completion-alert">
                        <i class="fas fa-exclamation-triangle me-2"></i> Your candidate profile is incomplete. Please <a
                            href="{{ route('profile.edit') }}" class="alert-link">complete your profile</a> to apply for
                        jobs.
                    </div>
                @endif

                @if (auth()->user()->hasRole('Organization') &&
                        session('active_role', '') === 'Organization' &&
                        !auth()->user()->organizationProfile->is_complete)
                    <div class="alert alert-warning profile-completion-alert">
                        <i class="fas fa-exclamation-triangle me-2"></i> Your organization profile is incomplete. Please <a
                            href="{{ route('profile.edit') }}" class="alert-link">complete your profile</a> to post jobs.
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
    @include('layouts.footer')


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
