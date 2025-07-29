<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'Job Portal' }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Custom CSS -->
    <style>
        :root {
            --primary-color: #2563eb;
            --secondary-color: #475569;
            --success-color: #16a34a;
            --danger-color: #dc2626;
            --warning-color: #eab308;
            --info-color: #0ea5e9;
            --light-color: #f8fafc;
            --dark-color: #1e293b;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            color: #333;
            background-color: #f9fafb;
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .btn-primary:hover, .btn-primary:focus {
            background-color: #1d4ed8;
            border-color: #1d4ed8;
        }
        
        .text-primary {
            color: var(--primary-color) !important;
        }
        
        .bg-primary {
            background-color: var(--primary-color) !important;
        }
        
        /* Accessibility improvements */
        .btn {
            font-weight: 500;
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
        }
        
        .form-control:focus {
            box-shadow: 0 0 0 0.25rem rgba(37, 99, 235, 0.25);
        }
        
        /* Card styles */
        .card {
            border: none;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            transition: box-shadow 0.3s ease;
        }
        
        .card:hover {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        
        /* Job card specifics */
        .job-card {
            border-left: 4px solid var(--primary-color);
        }
        
        /* Organization card specifics */
        .org-card {
            border-top: 4px solid var(--primary-color);
        }
        
        /* Accessibility focus states */
        a:focus, button:focus, input:focus, select:focus, textarea:focus {
            outline: 2px solid var(--primary-color);
            outline-offset: 2px;
        }
    </style>
    
    {{ $styles ?? '' }}
</head>
<body>
    {{ $header }}

    <main>
        {{ $slot }}
    </main>

    {{ $footer }}
    
    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    {{ $scripts ?? '' }}
</body>
</html>
