<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Job;
use App\Models\OrganizationProfile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Spatie\Permission\Models\Role;

class OrganizationController extends Controller
{
    /**
     * Register a new organization
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'phone' => 'required|string|max:20',
            // 'company_name' => 'nullable|string|max:255',
            // 'description' => 'nullable|string',
            // 'website' => 'nullable|string|url|max:255',
            // 'industry' => 'nullable|string|max:255',
            // 'company_size' => 'nullable|string|max:50',
            // 'address' => 'nullable|string|max:255',
        ]);

        // Create user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'active_role' => 'Organization',
        ]);

        // Assign organization role
        $orgRole = Role::findByName('Organization');
        $user->assignRole($orgRole);

        // Create organization profile
        $user->organizationProfile()->create([
            'company_name' => $request->company_name,
            'description' => $request->description,
            'website' => $request->website,
            'industry' => $request->industry,
            'company_size' => $request->company_size,
            'phone' => $request->phone,
            'address' => $request->address,
        ]);

        // Generate token
        $token = $user->createToken('organization_token')->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token,
            'profile' => $user->organizationProfile,
        ], 201);
    }

    /**
     * Login an organization
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password) || !$user->hasRole('Organization')) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect or you do not have organization access.'],
            ]);
        }

        // Set active role to Organization
        $user->setActiveRole('Organization');

        // Generate token
        $token = $user->createToken('organization_token')->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token,
            'profile' => $user->organizationProfile,
        ]);
    }

    /**
     * Logout an organization
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        
        return response()->json(['message' => 'Logged out successfully']);
    }

    /**
     * Get organization profile
     */
    public function profile(Request $request)
    {
        $user = $request->user();
        $profile = $user->organizationProfile;
        
        return response()->json([
            'user' => $user,
            'profile' => $profile,
        ]);
    }

    /**
     * Update organization profile
     */
    public function updateProfile(Request $request)
    {
        $user = $request->user();
        
        $request->validate([
            'name' => 'sometimes|string|max:255',
            'company_name' => 'sometimes|string|max:255',
            'description' => 'required|string',
            'website' => 'required|string|max:255',
            'industry' => 'required|string|max:255',
            'company_size' => 'required|string|max:50',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'logo' => 'nullable|image|max:2048',
        ]);

        logger()->info($request->all());

        // Update user
        if ($request->has('name')) {
            $user->update(['name' => $request->name]);
        }

        // Update profile
        $profileData = $request->only([
            'company_name',
            'description',
            'website',
            'industry',
            'company_size',
            'phone',
            'address',
        ]);
        
        // Handle logo upload
        if ($request->hasFile('logo')) {
            // Delete old logo if exists
            if ($user->organizationProfile->logo_path) {
                Storage::delete($user->organizationProfile->logo_path);
            }
            
            // Store new logo
            $path = $request->file('logo')->store('logos', 'public');
            $profileData['logo_path'] = $path;
        }
        
        $user->organizationProfile->update($profileData);
        
        return response()->json([
            'user' => $user,
            'profile' => $user->organizationProfile,
            'message' => 'Profile updated successfully',
        ]);
    }

    /**
     * Get all jobs posted by the organization
     */
    public function jobs(Request $request)
    {
        $user = $request->user();
        $jobs = $user->organizationProfile->jobs()
            ->withCount('applications')
            ->latest()
            ->paginate(10);
        
        return response()->json($jobs);
    }

    /**
     * Create a new job
     */
    public function storeJob(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'requirements' => 'required',
            'location' => 'required|string|max:255',
            'salary' => 'nullable|string|max:100',
        ]);
        
        $user = $request->user();
        $organizationId = $user->organizationProfile->id;
        
        $job = Job::create([
            'organization_id' => $organizationId,
            'title' => $request->title,
            'description' => $request->description,
            'requirements' => $request->requirements,
            'location' => $request->location,
            'salary' => $request->salary,
            'status' => 'open',
        ]);
        
        return response()->json([
            'job' => $job,
            'message' => 'Job posted successfully',
        ], 201);
    }

    /**
     * Update an existing job
     */
    public function updateJob(Request $request, Job $job)
    {
        $user = $request->user();
        
        // Check if the job belongs to the organization
        if ($job->organization_id !== $user->organizationProfile->id) {
            return response()->json(['message' => 'You do not have permission to update this job'], 403);
        }
        
        $request->validate([
            'title' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'requirements' => 'sometimes|string',
            'location' => 'sometimes|string|max:255',
            'salary' => 'nullable|string|max:100',
            'status' => 'sometimes|in:open,closed',
        ]);
        
        $job->update($request->only([
            'title',
            'description',
            'requirements',
            'location',
            'salary',
            'status',
        ]));
        
        return response()->json([
            'job' => $job,
            'message' => 'Job updated successfully',
        ]);
    }

    /**
     * Delete a job
     */
    public function destroyJob(Request $request, Job $job)
    {
        $user = $request->user();
        
        // Check if the job belongs to the organization
        if ($job->organization_id !== $user->organizationProfile->id) {
            return response()->json(['message' => 'You do not have permission to delete this job'], 403);
        }
        
        $job->delete();
        
        return response()->json([
            'message' => 'Job deleted successfully',
        ]);
    }

    /**
     * Show a specific job
     */
    public function showJob(Request $request, Job $job)
    {
        $user = $request->user();
        
        // Check if the job belongs to the organization
        if ($job->organization_id !== $user->organizationProfile->id) {
            return response()->json(['message' => 'You do not have permission to view this job'], 403);
        }
        
        return response()->json($job);
    }
}