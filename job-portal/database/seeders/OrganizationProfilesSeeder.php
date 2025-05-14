<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrganizationProfilesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * To complete profile: 'name', 'industry', 'description', 'location'
     */
    public function run(): void
    {
        $now = Carbon::now();

        DB::table('organization_profiles')->insert([
            [
                'user_id'      => 5,
                'name' => 'Delta Dynamics',
                'description'  => 'Advanced robotics and automation solutions.',
                'industry'     => 'Manufacturing',
                'company_size' => '100-200',
                'website'      => 'https://deltadynamics.example.com',
                'logo'    => null,
                'phone'        => '01-5551004',
                'location'      => 'Chitwan, Nepal',
                'is_complete' => true,
                'created_at'   => $now,
                'updated_at'   => $now,
            ],
            [
                'user_id'      => 6,
                'name' => 'Echo Media',
                'description'  => 'Digital media agency specializing in branding.',
                'industry'     => 'Marketing',
                'company_size' => '10-20',
                'website'      => 'https://echomedia.example.com',
                'logo'    => null,
                'phone'        => '01-5551005',
                'location'      => 'Biratnagar, Nepal',
                'is_complete' => true,
                'created_at'   => $now,
                'updated_at'   => $now,
            ],
            [
                'user_id'      => 7,
                'name' => 'Foxtrot Logistics',
                'description'  => 'Comprehensive logistics and supply chain services.',
                'industry'     => 'Logistics',
                'company_size' => '150-300',
                'website'      => 'https://foxtrotlogistics.example.com',
                'logo'    => null,
                'phone'        => '01-5551006',
                'location'      => 'Kathmandu, Nepal',
                'is_complete' => true,
                'created_at'   => $now,
                'updated_at'   => $now,
            ],
        ]);
    }
}
