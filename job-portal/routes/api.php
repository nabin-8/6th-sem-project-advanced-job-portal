<?php

use App\Http\Controllers\Api\CandidateController;
use App\Http\Controllers\Api\OrganizationController;
use App\Http\Controllers\Api\RoleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Candidate Routes
Route::prefix('candidate')->group(function () {
    // Public routes
    Route::post('/register', [CandidateController::class, 'register']);
    Route::post('/login', [CandidateController::class, 'login']);
    
    // Protected routes - require active Candidate role
    Route::middleware(['auth:sanctum', 'role:Candidate', 'active.role:Candidate'])->group(function () {
        Route::post('/logout', [CandidateController::class, 'logout']);
        Route::get('/profile', [CandidateController::class, 'profile']);
        Route::put('/profile', [CandidateController::class, 'updateProfile']);
        
        Route::get('/jobs', [CandidateController::class, 'jobs']);
        Route::get('/jobs/{job}', [CandidateController::class, 'showJob']);
        Route::post('/jobs/{job}/apply', [CandidateController::class, 'applyForJob']);
        
        Route::get('/applications', [CandidateController::class, 'applications']);
        Route::get('/applications/{application}', [CandidateController::class, 'showApplication']);
    });
});

// Organization Routes
Route::prefix('organization')->group(function () {
    // Public routes
    Route::post('/register', [OrganizationController::class, 'register']);
    Route::post('/login', [OrganizationController::class, 'login']);
    
    // Protected routes - require active Organization role
    Route::middleware(['auth:sanctum', 'role:Organization', 'active.role:Organization'])->group(function () {
        Route::post('/logout', [OrganizationController::class, 'logout']);
        Route::get('/profile', [OrganizationController::class, 'profile']);
        Route::put('/profile', [OrganizationController::class, 'updateProfile']);
        
        Route::get('/jobs', [OrganizationController::class, 'jobs']);
        Route::post('/jobs', [OrganizationController::class, 'storeJob']);
        Route::put('/jobs/{job}', [OrganizationController::class, 'updateJob']);
        Route::delete('/jobs/{job}', [OrganizationController::class, 'destroyJob']);
    });
});

// Role Switching Route
Route::middleware('auth:sanctum')->post('/switch-role', [RoleController::class, 'switchRole']);