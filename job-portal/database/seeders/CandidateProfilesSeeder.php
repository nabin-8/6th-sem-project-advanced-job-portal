<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CandidateProfilesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('candidate_profiles')->insert([
            // [
            //     'user_id' => 1,
            //     'bio' => 'Enthusiastic developer eager to learn and grow.',
            //     'phone' => '9800000001',
            //     'address' => 'Kathmandu, Nepal',
            //     'skills' => json_encode(['PHP', 'Laravel', 'MySQL']),
            //     'education' => json_encode([
            //         ['degree' => 'BCA', 'institution' => 'TU', 'year' => '2022']
            //     ]),
            //     'experience' => json_encode([
            //         ['position' => 'Intern', 'company' => 'XYZ Pvt Ltd', 'years' => '6 months']
            //     ]),
            //     'resume_path' => null,
            //     'created_at' => now(),
            //     'updated_at' => now(),
            // ],
            [
                'user_id' => 2,
                'bio' => 'Frontend-focused candidate with Vue.js skills.',
                'phone' => '9800000002',
                'address' => 'Lalitpur, Nepal',
                'skills' => json_encode(['HTML', 'CSS', 'Vue.js']),
                'education' => json_encode([
                    ['degree' => 'BSc CSIT', 'institution' => 'TU', 'year' => '2021']
                ]),
                'experience' => json_encode([
                    ['position' => 'Frontend Intern', 'company' => 'WebSoft', 'years' => '4 months']
                ]),
                'resume_path' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 3,
                'bio' => 'Backend developer with experience in REST APIs.',
                'phone' => '9800000003',
                'address' => 'Bhaktapur, Nepal',
                'skills' => json_encode(['Node.js', 'Express', 'MongoDB']),
                'education' => json_encode([
                    ['degree' => 'BIT', 'institution' => 'PU', 'year' => '2023']
                ]),
                'experience' => json_encode([
                    ['position' => 'Backend Intern', 'company' => 'TechHub', 'years' => '5 months']
                ]),
                'resume_path' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 4,
                'bio' => 'UI/UX Designer turned web developer.',
                'phone' => '9800000004',
                'address' => 'Pokhara, Nepal',
                'skills' => json_encode(['Figma', 'Bootstrap', 'React']),
                'education' => json_encode([
                    ['degree' => 'BIM', 'institution' => 'TU', 'year' => '2020']
                ]),
                'experience' => json_encode([
                    ['position' => 'UI Intern', 'company' => 'Creatives Inc.', 'years' => '3 months']
                ]),
                'resume_path' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // [
            //     'user_id' => 5,
            //     'bio' => 'Passionate about data and automation.',
            //     'phone' => '9800000005',
            //     'address' => 'Butwal, Nepal',
            //     'skills' => json_encode(['Python', 'Pandas', 'Selenium']),
            //     'education' => json_encode([
            //         ['degree' => 'BCA', 'institution' => 'TU', 'year' => '2024']
            //     ]),
            //     'experience' => json_encode([
            //         ['position' => 'Data Analyst Intern', 'company' => 'DataSoft', 'years' => '5 months']
            //     ]),
            //     'resume_path' => null,
            //     'created_at' => now(),
            //     'updated_at' => now(),
            // ],
            // [
            //     'user_id' => 6,
            //     'bio' => 'Mobile app developer focused on cross-platform solutions.',
            //     'phone' => '9800000006',
            //     'address' => 'Chitwan, Nepal',
            //     'skills' => json_encode(['Flutter', 'Firebase']),
            //     'education' => json_encode([
            //         ['degree' => 'BSc IT', 'institution' => 'KU', 'year' => '2022']
            //     ]),
            //     'experience' => json_encode([
            //         ['position' => 'Mobile Developer Intern', 'company' => 'MobilityX', 'years' => '6 months']
            //     ]),
            //     'resume_path' => null,
            //     'created_at' => now(),
            //     'updated_at' => now(),
            // ],
        ]);
    }
}
