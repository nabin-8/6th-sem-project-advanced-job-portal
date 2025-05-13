<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();
        
        // Get roles
        $candidateRole = Role::findByName('Candidate');
        $organizationRole = Role::findByName('Organization');

        // Create candidate users
        $candidates = [
            [
                'name' => 'Alice Candidate',
                'email' => 'alice.candidate@example.com',
                'password' => 'password123',
            ],
            [
                'name' => 'Bob Candidate',
                'email' => 'bob.candidate@example.com',
                'password' => 'password123',
            ],
            [
                'name' => 'Charlie Candidate',
                'email' => 'charlie.candidate@example.com',
                'password' => 'password123',
            ]
        ];
        
        foreach ($candidates as $candidate) {
            $user = User::create([
                'name' => $candidate['name'],
                'email' => $candidate['email'],
                'password' => Hash::make($candidate['password']),
                'active_role' => 'Candidate',
            ]);
            $user->assignRole($candidateRole);
        }
        
        // Create organization users
        $organizations = [
            [
                'name' => 'Delta Org',
                'email' => 'delta.organization@example.com',
                'password' => 'password123',
            ],
            [
                'name' => 'Echo Org',
                'email' => 'echo.organization@example.com',
                'password' => 'password123',
            ],
            [
                'name' => 'Foxtrot Org',
                'email' => 'foxtrot.organization@example.com',
                'password' => 'password123',
            ]
        ];
        
        foreach ($organizations as $org) {
            $user = User::create([
                'name' => $org['name'],
                'email' => $org['email'],
                'password' => Hash::make($org['password']),
                'active_role' => 'Organization',
            ]);
            $user->assignRole($organizationRole);
        }
    }
}
