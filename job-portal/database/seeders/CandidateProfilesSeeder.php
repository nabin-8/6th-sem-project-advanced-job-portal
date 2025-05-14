<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CandidateProfilesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * To complete profile: 'headline', 'bio', 'location', 'phone', 'skills', 'resume'
     */
    public function run(): void
    {
        DB::table('candidate_profiles')->insert([
            [
                'user_id' => 2,
                'headline' => 'Frontend Developer',
                'bio' => 'Frontend-focused candidate with Vue.js skills.',
                'phone' => '9800000002',
                'location' => 'Lalitpur, Nepal',
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
                'headline' => 'Backend Developer',
                'bio' => 'Backend developer with experience in REST APIs.',
                'phone' => '9800000003',
                'location' => 'Bhaktapur, Nepal',
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
                "headline" => 'UI/UX Designer',
                'bio' => 'UI/UX Designer turned web developer.',
                'phone' => '9800000004',
                'location' => 'Pokhara, Nepal',
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
        ]);
    }
}
