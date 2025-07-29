<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * Show the login form
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Handle login request
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            
            // Determine the appropriate role to activate
            if ($user->hasRole(['Candidate', 'Organization'])) {
                // If user has both roles, prioritize:
                // 1. Last active role if it exists
                // 2. Organization role if organization profile is complete
                // 3. Candidate role if candidate profile is complete
                // 4. Default to Candidate

                if ($user->active_role && $user->hasRole($user->active_role)) {
                    // Keep the last active role if valid
                } elseif ($user->hasRole('Organization') && $user->organizationProfile && $user->organizationProfile->is_complete) {
                    $user->active_role = 'Organization';
                } elseif ($user->hasRole('Candidate') && $user->candidateProfile && $user->candidateProfile->is_complete) {
                    $user->active_role = 'Candidate';
                } elseif ($user->hasRole('Organization')) {
                    $user->active_role = 'Organization';
                } else {
                    $user->active_role = 'Candidate';
                }
            } elseif ($user->hasRole('Candidate')) {
                $user->active_role = 'Candidate';
            } elseif ($user->hasRole('Organization')) {
                $user->active_role = 'Organization';
            }
            
            $user->save();
            
            // Store in session for middleware
            session(['active_role' => $user->active_role]);
            
            $request->session()->regenerate();
            return redirect()->intended('dashboard');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->withInput();
    }

    /**
     * Show the registration form
     */
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    /**
     * Handle registration request
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'roles' => 'required|in:candidate,organization,both',
            'terms' => 'required',
        ]);

        // 'password' => [
        //         'required',
        //         'string',
        //         'min:8',
        //         'confirmed',
        //         'regex:/^(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/',
        // ]
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Create the user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'active_role' => 'Candidate', // Default role
        ]);

        // Assign roles based on selection
        if ($request->roles == 'candidate') {
            $user->assignRole('Candidate');
        } elseif ($request->roles == 'organization') {
            $user->assignRole('Organization');
            $user->active_role = 'Organization';
            $user->save();
        } elseif ($request->roles == 'both') {
            $user->assignRole(['Candidate', 'Organization']);
        }

        // Log the user in
        Auth::login($user);

        // Create initial profile records
        if ($user->hasRole('Candidate')) {
            $user->candidateProfile()->create();
        }

        if ($user->hasRole('Organization')) {
            $user->organizationProfile()->create();
        }

        return redirect()->route('dashboard');
    }

    /**
     * Handle logout request
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
