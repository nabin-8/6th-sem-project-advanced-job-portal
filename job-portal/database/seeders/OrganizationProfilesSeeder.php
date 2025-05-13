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
     */
    public function run(): void
    {
        $now = Carbon::now();

        DB::table('organization_profiles')->insert([
            // [
            //     'user_id'      => 1,
            //     'name' => 'Alpha Tech',
            //     'description'  => 'Leading provider of innovative software solutions.',
            //     'industry'     => 'Information Technology',
            //     'company_size' => '50-100',
            //     'website'      => 'https://alphatech.example.com',
            //     'logo'    => null,
            //     'phone'        => '01-5551001',
            //     'location'      => 'Kathmandu, Nepal',
            //     'created_at'   => $now,
            //     'updated_at'   => $now,
            // ],
            // [
            //     'user_id'      => 2,
            //     'name' => 'Beta Solutions',
            //     'description'  => 'Enterprise-level consulting and IT services.',
            //     'industry'     => 'Consulting',
            //     'company_size' => '200-500',
            //     'website'      => 'https://betasolutions.example.com',
            //     'logo'    => null,
            //     'phone'        => '01-5551002',
            //     'location'      => 'Lalitpur, Nepal',
            //     'created_at'   => $now,
            //     'updated_at'   => $now,
            // ],
            // [
            //     'user_id'      => 3,
            //     'name' => 'Gamma Ventures',
            //     'description'  => 'Venture capital firm investing in tech startups.',
            //     'industry'     => 'Finance',
            //     'company_size' => '20-50',
            //     'website'      => 'https://gammaventures.example.com',
            //     'logo'    => null,
            //     'phone'        => '01-5551003',
            //     'location'      => 'Pokhara, Nepal',
            //     'created_at'   => $now,
            //     'updated_at'   => $now,
            // ],
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
                'created_at'   => $now,
                'updated_at'   => $now,
            ],
        ]);
    }
}
