<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CandidateProfile;
use App\Models\Job;
use App\Models\JobApplication;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Spatie\Permission\Models\Role;

class CandidateController extends Controller
{
    /**
     * Register a new candidate
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'phone' => 'required|string|max:20',
            'address' => 'nullable|string|max:255',
            'skills' => 'nullable|string',
        ]);

        // Create user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'active_role' => 'Candidate',
        ]);

        // Assign candidate role
        $candidateRole = Role::findByName('Candidate');
        $user->assignRole($candidateRole);

        // Create candidate profile
        $user->candidateProfile()->create([
            'phone' => $request->phone,
            'address' => $request->address,
            'skills' => $request->skills,
        ]);

        // Generate token for the user
        $token = $user->createToken('candidate_token')->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token,
            'profile' => $user->candidateProfile,
        ], 201);
    }

    /**
     * Login a candidate
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password) || !$user->hasRole('Candidate')) {
            throw ValidationException::withMessages([
                'email' => ['The email or password incorrect.'],
            ]);
        }

        // Set active role to Candidate
        $user->setActiveRole('Candidate');

        // Generate token
        $token = $user->createToken('candidate_token')->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token,
            'profile' => $user->candidateProfile,
        ]);
    }

    /**
     * Logout a candidate
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        
        return response()->json(['message' => 'Logged out successfully']);
    }

    /**
     * Get candidate profile
     */
    public function profile(Request $request)
    {
        $user = $request->user();
        $profile = $user->candidateProfile;
        
        return response()->json([
            'user' => $user,
            'profile' => $profile,
        ]);
    }

    /**
     * Update candidate profile
     */
    public function updateProfile(Request $request)
    {
        $user = $request->user();
        
        $request->validate([
            'name' => 'sometimes|string|max:255',
            'bio' => 'nullable|string',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'skills' => 'nullable|string',
            'education' => 'nullable|string',
            'experience' => 'nullable|string',
            'resume' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        ]);

        // Update user
        if ($request->has('name')) {
            $user->update(['name' => $request->name]);
        }

        // Update profile
        $profileData = $request->only(['bio', 'phone', 'address', 'skills', 'education', 'experience']);
        
        // Handle resume upload
        if ($request->hasFile('resume')) {
            // Delete old resume if exists
            if ($user->candidateProfile->resume_path) {
                Storage::delete($user->candidateProfile->resume_path);
            }
            
            // Store new resume
            $path = $request->file('resume')->store('resumes', 'private');
            $profileData['resume_path'] = $path;
        }
        
        $user->candidateProfile->update($profileData);
        
        return response()->json([
            'user' => $user,
            'profile' => $user->candidateProfile,
            'message' => 'Profile updated successfully',
        ]);
    }

    /**
     * Get all open jobs
     */
    public function jobs()
    {
        $jobs = Job::with('organization')->where('status', 'open')->latest()->paginate(10);
        
        return response()->json($jobs);
    }

    /**
     * Show a specific job
     */
    public function showJob(Job $job)
    {
        $job->load('organization');
        
        return response()->json($job);
    }

    /**
     * Apply for a job
     */
    public function applyForJob(Request $request, Job $job)
    {
        $request->validate([
            'cover_letter' => 'required|string',
        ]);
        
        // Check if job is open
        if ($job->status !== 'open') {
            return response()->json(['message' => 'This job is not open for applications'], 400);
        }
        
        $user = $request->user();
        $candidateId = $user->candidateProfile->id;
        
        // Check if already applied
        $existingApplication = JobApplication::where('job_id', $job->id)
            ->where('candidate_id', $candidateId)
            ->first();
            
        if ($existingApplication) {
            return response()->json(['message' => 'You have already applied for this job'], 400);
        }
        
        // Create job application
        $application = JobApplication::create([
            'job_id' => $job->id,
            'candidate_id' => $candidateId,
            'cover_letter' => $request->cover_letter,
            'status' => 'pending',
        ]);
        
        return response()->json([
            'application' => $application,
            'message' => 'Application submitted successfully',
        ], 201);
    }

    /**
     * Get all applications for the candidate
     */
    public function applications(Request $request)
    {
        $user = $request->user();
        $applications = $user->candidateProfile->jobApplications()
            ->with('job.organization')
            ->latest()
            ->paginate(10);
        
        return response()->json($applications);
    }

    /**
     * Show a specific application
     */
    public function showApplication(Request $request, JobApplication $application)
    {
        $user = $request->user();
        
        // Check if the application belongs to the candidate
        if ($application->candidate_id !== $user->candidateProfile->id) {
            return response()->json(['message' => 'You do not have permission to view this application'], 403);
        }
        
        $application->load('job.organization');
        
        return response()->json($application);
    }
}