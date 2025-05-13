<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create roles
        $adminRole = Role::create(['name' => 'Admin']);
        $candidateRole = Role::create(['name' => 'Candidate']);
        $organizationRole = Role::create(['name' => 'Organization']);

        // Create permissions for Candidates
        $candidatePermissions = [
            'view jobs',
            'apply jobs',
            'view own applications',
            'manage candidate profile',
        ];

        foreach ($candidatePermissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Create permissions for Organizations
        $organizationPermissions = [
            'manage jobs',
            'view applications',
            'manage organization profile',
        ];

        foreach ($organizationPermissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Assign permissions to roles
        $candidateRole->syncPermissions($candidatePermissions);
        $organizationRole->syncPermissions($organizationPermissions);

        // Admin role gets all permissions
        $adminRole->syncPermissions(Permission::all());
    }
}