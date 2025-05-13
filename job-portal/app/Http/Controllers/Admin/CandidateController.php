<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CandidateProfile;
use App\Models\User;
use Illuminate\Http\Request;

class CandidateController extends Controller
{
    /**
     * Display a listing of candidates.
     */
    public function index()
    {
        $candidates = CandidateProfile::with('user')->paginate(10);
        return view('admin.candidates.index', compact('candidates'));
    }

    /**
     * Display the specified candidate.
     */
    public function show(CandidateProfile $candidate)
    {
        $candidate->load(['user', 'jobApplications.job']);
        return view('admin.candidates.show', compact('candidate'));
    }

    /**
     * Show the form for editing the specified candidate.
     */
    public function edit(CandidateProfile $candidate)
    {
        return view('admin.candidates.edit', compact('candidate'));
    }

    /**
     * Update the specified candidate in storage.
     */
    public function update(Request $request, CandidateProfile $candidate)
    {
        $request->validate([
            'bio' => 'nullable|string',
            'skills' => 'nullable|string',
            'education' => 'nullable|string',
            'experience' => 'nullable|string',
            'phone' => 'nullable|string',
            'address' => 'nullable|string',
        ]);

        $candidate->update($request->all());

        return redirect()->route('admin.candidates.show', $candidate)
            ->with('success', 'Candidate profile updated successfully.');
    }

    /**
     * Remove the specified candidate from storage.
     */
    public function destroy(CandidateProfile $candidate)
    {
        // Store userId for potential cascading delete
        $userId = $candidate->user_id;
        
        // Delete the candidate profile
        $candidate->delete();
        
        // Check if user has both roles or just candidate
        $user = User::find($userId);
        if ($user && !$user->hasRole('Organization') && !$user->hasRole('Admin')) {
            // If user only had Candidate role, delete the user too
            $user->delete();
        }

        return redirect()->route('candidates.index')
            ->with('success', 'Candidate deleted successfully.');
    }
}