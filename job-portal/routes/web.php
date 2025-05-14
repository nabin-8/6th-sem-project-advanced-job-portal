<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CandidateController;
use App\Http\Controllers\Admin\OrganizationController;
use App\Http\Controllers\Admin\JobController as AdminJobController;
use App\Http\Controllers\Admin\JobApplicationController as AdminApplicationController;
use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\JobsController;
use App\Http\Controllers\Frontend\AuthController;
use App\Http\Controllers\Frontend\DashboardController;
use App\Http\Controllers\Frontend\ProfileController;
use App\Http\Controllers\Frontend\ApplicationController;
use App\Http\Controllers\Frontend\RoleController;

// Admin Authentication Routes - Must be placed FIRST to avoid conflicts
Route::prefix('admin')->name('admin.')->group(function () {
    // Guest middleware applied to login routes
    Route::middleware('guest')->group(function () {
        Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [AdminAuthController::class, 'login'])->name('login.submit');
    });
    
    // Admin logout route
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout')->middleware('auth');
    
    // Admin Panel Routes - Protected by admin role middleware
    Route::middleware(['auth', 'role:Admin'])->group(function () {
        Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');
        
        // Users Management
        Route::resource('users', UserController::class);
        Route::put('users/{user}/deactivate', [UserController::class, 'deactivate'])->name('users.deactivate');
        Route::put('users/{user}/roles', [UserController::class, 'updateRoles'])->name('users.roles.update');
        
        // Candidates Management
        Route::resource('candidates', CandidateController::class);
        
        // Organizations Management
        Route::resource('organizations', OrganizationController::class);
        
        // Jobs Management
        Route::resource('jobs', AdminJobController::class);
        Route::put('jobs/{job}/status', [AdminJobController::class, 'toggleStatus'])->name('jobs.toggleStatus');
        
        // Job Applications Management
        Route::resource('applications', AdminApplicationController::class);
        Route::put('applications/{application}/status', [AdminApplicationController::class, 'updateStatus'])->name('applications.updateStatus');
    });
});

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/jobs', [JobsController::class, 'index'])->name('jobs.index');
Route::get('/jobs/{job}', [JobsController::class, 'show'])->name('jobs.show');

// Frontend Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
    Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.submit');
});

// Protected Frontend Routes (requires authentication)
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Role Switch
    Route::post('/switch-role', [RoleController::class, 'switchRole'])->name('switch.role');
    
    // Candidate Routes
    Route::middleware(['role:Candidate', 'active.role:Candidate'])->prefix('candidate')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'candidateDashboard'])->name('candidate.dashboard');
        Route::get('/applications', [ApplicationController::class, 'index'])->name('applications.index');
        Route::get('/applications/{application}', [ApplicationController::class, 'show'])->name('applications.show');
        Route::post('/jobs/{job}/apply', [ApplicationController::class, 'apply'])->name('jobs.apply');
        Route::post('/applications/{application}/withdraw', [ApplicationController::class, 'withdraw'])->name('applications.withdraw');
    });
    
    // Organization Routes
    Route::middleware(['role:Organization', 'active.role:Organization'])->prefix('organization')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'organizationDashboard'])->name('organization.dashboard');
        Route::get('/jobs/manage', [JobsController::class, 'manage'])->name('jobs.manage');
        Route::get('/jobs/manage/create', [JobsController::class, 'create'])->name('jobs.create');
        Route::post('/jobs', [JobsController::class, 'store'])->name('jobs.store');
        Route::get('/jobs/manage/{job}/edit', [JobsController::class, 'edit'])->name('jobs.edit');
        Route::put('/jobs/{job}', [JobsController::class, 'update'])->name('jobs.update');
        Route::delete('/jobs/{job}', [JobsController::class, 'destroy'])->name('jobs.destroy');
        Route::put('/jobs/{job}/toggle-status', [JobsController::class, 'toggleStatus'])->name('jobs.toggle-status');
        Route::get('/applications/{job}', [ApplicationController::class, 'jobApplications'])->name('jobs.applications');
        Route::get('/applications/{job}/{application}', [ApplicationController::class, 'showApplication'])->name('jobs.applications.show');
        Route::put('/applications/{job}/{application}/status', [ApplicationController::class, 'updateApplicationStatus'])->name('jobs.applications.update-status');
        Route::post('/applications/{job}/{application}/message', [ApplicationController::class, 'sendMessage'])->name('jobs.applications.send-message');
    });
    
    // Profile Routes (available to both roles)
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/candidate', [ProfileController::class, 'updateCandidateProfile'])->name('profile.candidate.update');
    Route::post('/profile/organization', [ProfileController::class, 'updateOrganizationProfile'])->name('profile.organization.update');
    
    // Public profile routes
    Route::get('/candidate/{id}', [ProfileController::class, 'viewCandidateProfile'])->name('candidate.profile');
    Route::get('/organization/{id}', [ProfileController::class, 'viewOrganizationProfile'])->name('organization.profile');
});