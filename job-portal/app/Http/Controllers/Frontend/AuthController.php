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
        // dd($request->all());

        $activeRole = $request->input('active_role', 'Candidate');
        
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            
            // Check if user has the selected role
            if ($user->hasRole($activeRole)) {
                // Set active role in user record
                $user->active_role = $activeRole;
                $user->save();
                
                $request->session()->regenerate();
                return redirect()->intended('dashboard');
            } else {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'You do not have the selected role.',
                ])->withInput();
            }
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
