<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OrganizationProfile;
use App\Models\User;
use Illuminate\Http\Request;

class OrganizationController extends Controller
{
    /**
     * Display a listing of organizations.
     */
    public function index()
    {
        $organizations = OrganizationProfile::with('user')->paginate(10);
        // dd($organizations);
        return view('admin.organizations.index', compact('organizations'));
    }

    /**
     * Display the specified organization.
     */
    public function show(OrganizationProfile $organization)
    {
        $organization->load(['user', 'jobs']);
        return view('admin.organizations.show', compact('organization'));
    }

    /**
     * Show the form for editing the specified organization.
     */
    public function edit(OrganizationProfile $organization)
    {
        return view('admin.organizations.edit', compact('organization'));
    }

    /**
     * Update the specified organization in storage.
     */
    public function update(Request $request, OrganizationProfile $organization)
    {
        $request->validate([
            'company_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'website' => 'nullable|url',
            'industry' => 'nullable|string|max:255',
            'company_size' => 'nullable|string|max:50',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
        ]);

        $organization->update($request->all());

        return redirect()->route('organizations.show', $organization)
            ->with('success', 'Organization updated successfully.');
    }

    /**
     * Remove the specified organization from storage.
     */
    public function destroy(OrganizationProfile $organization)
    {
        // Store userId for potential cascading delete
        $userId = $organization->user_id;
        
        // Delete the organization profile
        $organization->delete();
        
        // Check if user has both roles or just organization
        $user = User::find($userId);
        if ($user && !$user->hasRole('Candidate') && !$user->hasRole('Admin')) {
            // If user only had Organization role, delete the user too
            $user->delete();
        }

        return redirect()->route('organizations.index')
            ->with('success', 'Organization deleted successfully.');
    }
}