<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        // For API routes, no need to redirect
        if ($request->expectsJson()) {
            return null;
        }
        
        // If trying to access admin routes, redirect to admin login
        if (str_starts_with($request->path(), 'admin')) {
            return route('admin.login');
        }
        
        // Default login route could be defined here if needed
        // return route('login');
        
        return route('admin.login');
    }
}