<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleController extends Controller
{
    /**
     * Switch user's active role
     */
    public function switchRole(Request $request)
    {
        $request->validate([
            'role' => 'required|string|in:Candidate,Organization',
        ]);

        $user = $request->user();
        $role = $request->input('role');

        // Check if the user has the requested role
        if (!$user->hasRole($role)) {
            return response()->json([
                'message' => "You do not have {$role} role privileges.",
            ], 403);
        }

        // Update the user's active role
        $user->setActiveRole($role);

        return response()->json([
            'message' => "Active role switched to {$role}.",
            'active_role' => $role,
        ]);
    }
}