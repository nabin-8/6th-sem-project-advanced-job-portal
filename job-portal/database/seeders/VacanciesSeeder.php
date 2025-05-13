<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class VacanciesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::now();

        DB::table('vacancies')->insert([
            [
                'organization_id' => 1,
                'title'           => 'Frontend Developer',
                'description'     => 'Build and maintain responsive web interfaces using modern JavaScript frameworks.',
                'requirements'    => json_encode([
                    '3+ years experience with React or Vue.js',
                    'Strong knowledge of HTML5, CSS3, and SASS/LESS',
                    'Familiarity with RESTful APIs',
                    'Experience with Webpack or Vite',
                ]),
                'location'        => 'Kathmandu',
                'salary'          => '45000',
                'status'          => 'open',
                'created_at'      => $now,
                'updated_at'      => $now,
            ],
            [
                'organization_id' => 1,
                'title'           => 'Backend Developer (Node.js)',
                'description'     => 'Design and implement server-side logic and APIs for our SaaS platform.',
                'requirements'    => json_encode([
                    '2+ years experience with Node.js and Express',
                    'Experience with MongoDB or PostgreSQL',
                    'Understanding of MVC architecture',
                    'Knowledge of Docker and containerization',
                ]),
                'location'        => 'Pokhara',
                'salary'          => '50000',
                'status'          => 'open',
                'created_at'      => $now,
                'updated_at'      => $now,
            ],
            [
                'organization_id' => 1,
                'title'           => 'Full Stack Engineer',
                'description'     => 'End-to-end development from database design to UI implementation.',
                'requirements'    => json_encode([
                    'Proficient in JavaScript (Node.js & React)',
                    'Experience with REST and GraphQL APIs',
                    'Familiarity with CI/CD pipelines',
                    'Ability to write unit and integration tests',
                ]),
                'location'        => 'Chitwan',
                'salary'          => '60000',
                'status'          => 'open',
                'created_at'      => $now,
                'updated_at'      => $now,
            ],
            [
                'organization_id' => 1,
                'title'           => 'DevOps Engineer',
                'description'     => 'Maintain and optimize our cloud infrastructure and CI/CD workflows.',
                'requirements'    => json_encode([
                    'Experience with AWS or Azure',
                    'Strong scripting skills (Bash, Python)',
                    'Knowledge of Kubernetes and Docker',
                    'Monitoring tools like Prometheus/Grafana',
                ]),
                'location'        => 'Biratnagar',
                'salary'          => '55000',
                'status'          => 'open',
                'created_at'      => $now,
                'updated_at'      => $now,
            ],
            [
                'organization_id' => 1,
                'title'           => 'Data Analyst',
                'description'     => 'Analyze user and system data to drive product decisions and improvements.',
                'requirements'    => json_encode([
                    'Proficient in SQL and Excel',
                    'Experience with BI tools (Tableau, PowerBI)',
                    'Understanding of statistical analysis',
                    'Basic Python or R scripting',
                ]),
                'location'        => 'Lalitpur',
                'salary'          => '40000',
                'status'          => 'open',
                'created_at'      => $now,
                'updated_at'      => $now,
            ],
            [
                'organization_id' => 2,
                'title'           => 'UI/UX Designer',
                'description'     => 'Design intuitive user interfaces and engaging user experiences.',
                'requirements'    => json_encode([
                    '3+ years experience in UI/UX design',
                    'Proficient with Figma or Adobe XD',
                    'Strong portfolio showcasing design projects',
                    'Knowledge of responsive design principles',
                ]),
                'location'        => 'Kathmandu',
                'salary'          => '48000',
                'status'          => 'open',
                'created_at'      => $now,
                'updated_at'      => $now,
            ],
            [
                'organization_id' => 2,
                'title'           => 'Mobile App Developer (Flutter)',
                'description'     => 'Develop cross-platform mobile applications using Flutter.',
                'requirements'    => json_encode([
                    '2+ years experience with Flutter and Dart',
                    'Experience with Firebase integration',
                    'Knowledge of RESTful APIs',
                    'Familiarity with CI/CD for mobile apps',
                ]),
                'location'        => 'Pokhara',
                'salary'          => '52000',
                'status'          => 'open',
                'created_at'      => $now,
                'updated_at'      => $now,
            ],
            [
                'organization_id' => 2,
                'title'           => 'QA Engineer',
                'description'     => 'Ensure software quality through testing and automation.',
                'requirements'    => json_encode([
                    'Experience with Selenium or Cypress',
                    'Strong understanding of QA methodologies',
                    'Ability to write automated test scripts',
                    'Familiarity with CI pipelines',
                ]),
                'location'        => 'Chitwan',
                'salary'          => '45000',
                'status'          => 'open',
                'created_at'      => $now,
                'updated_at'      => $now,
            ],
            [
                'organization_id' => 3,
                'title'           => 'Systems Administrator',
                'description'     => 'Manage and maintain company servers and network infrastructure.',
                'requirements'    => json_encode([
                    '3+ years in system administration',
                    'Experience with Linux and Windows servers',
                    'Knowledge of networking protocols',
                    'Familiarity with virtualization (VMware, Hyper-V)',
                ]),
                'location'        => 'Biratnagar',
                'salary'          => '53000',
                'status'          => 'open',
                'created_at'      => $now,
                'updated_at'      => $now,
            ],
            [
                'organization_id' => 3,
                'title'           => 'Product Manager',
                'description'     => 'Lead product vision, roadmap, and feature prioritization.',
                'requirements'    => json_encode([
                    'Proven experience as a Product Manager',
                    'Strong communication skills',
                    'Ability to analyze market trends',
                    'Familiarity with Agile methodologies',
                ]),
                'location'        => 'Lalitpur',
                'salary'          => '65000',
                'status'          => 'open',
                'created_at'      => $now,
                'updated_at'      => $now,
            ],
        ]);
    }
}
