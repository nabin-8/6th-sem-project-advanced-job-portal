<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleController extends Controller
{
    /**
     * Switch between user roles (Candidate/Organization)
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function switchRole(Request $request)
    {
        $request->validate([
            'role' => 'required|in:Candidate,Organization',
        ]);
        
        $user = Auth::user();
        $newRole = $request->input('role');
        
        // Verify that the user has the requested role
        if (!$user->hasRole($newRole)) {
            return back()->with('error', 'You do not have permission to switch to this role.');
        }
        
        // Update the user's active role
        $user->active_role = $newRole;
        $user->save();
        
        // Store the active role in the session
        session(['active_role' => $newRole]);
        
        return redirect()->route('dashboard')
            ->with('success', "Switched to {$newRole} role successfully.");
    }
}
