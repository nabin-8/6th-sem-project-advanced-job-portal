<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\JobCategory;
use Illuminate\Support\Str;

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
        $deadline = Carbon::now()->addDays(30);

        // Get category IDs
        $technologyCategory = JobCategory::where('name', 'Technology')->first();
        $designCategory = JobCategory::where('name', 'Design')->first();
        $administrativeCategory = JobCategory::where('name', 'Administrative')->first();
        $marketingCategory = JobCategory::where('name', 'Marketing')->first();

        DB::table('vacancies')->insert([
            [
                'organization_id' => 1,
                'category_id'     => $technologyCategory->id,
                'title'           => 'Frontend Developer',
                'slug'            => 'frontend-developer-' . uniqid(),
                'description'     => 'Build and maintain responsive web interfaces using modern JavaScript frameworks.',
                'requirements'    => json_encode([
                    '3+ years experience with React or Vue.js',
                    'Strong knowledge of HTML5, CSS3, and SASS/LESS',
                    'Familiarity with RESTful APIs',
                    'Experience with Webpack or Vite',
                ]),
                'location'        => 'Kathmandu',
                'employment_type' => 'Full-time',
                'salary_min'      => 40000,
                'salary_max'      => 55000,
                'application_deadline' => $deadline,
                'is_featured'     => true,
                'status'          => 'open',
                'created_at'      => $now,
                'updated_at'      => $now,
            ],
            [
                'organization_id' => 1,
                'category_id'     => $technologyCategory->id,
                'title'           => 'Backend Developer (Node.js)',
                'slug'            => 'backend-developer-nodejs-' . uniqid(),
                'description'     => 'Design and implement server-side logic and APIs for our SaaS platform.',
                'requirements'    => json_encode([
                    '2+ years experience with Node.js and Express',
                    'Experience with MongoDB or PostgreSQL',
                    'Understanding of MVC architecture',
                    'Knowledge of Docker and containerization',
                ]),
                'location'        => 'Pokhara',
                'employment_type' => 'Full-time',
                'salary_min'      => 45000,
                'salary_max'      => 60000,
                'application_deadline' => $deadline,
                'is_featured'     => false,
                'status'          => 'open',
                'created_at'      => $now,
                'updated_at'      => $now,
            ],
            [
                'organization_id' => 1,
                'category_id'     => $technologyCategory->id,
                'title'           => 'Full Stack Engineer',
                'slug'            => 'full-stack-engineer-' . uniqid(),
                'description'     => 'End-to-end development from database design to UI implementation.',
                'requirements'    => json_encode([
                    'Proficient in JavaScript (Node.js & React)',
                    'Experience with REST and GraphQL APIs',
                    'Familiarity with CI/CD pipelines',
                    'Ability to write unit and integration tests',
                ]),
                'location'        => 'Chitwan',
                'employment_type' => 'Full-time',
                'salary_min'      => 55000,
                'salary_max'      => 70000,
                'application_deadline' => $deadline,
                'is_featured'     => true,
                'status'          => 'open',
                'created_at'      => $now,
                'updated_at'      => $now,
            ],
            [
                'organization_id' => 1,
                'category_id'     => $technologyCategory->id,
                'title'           => 'DevOps Engineer',
                'slug'            => 'devops-engineer-' . uniqid(),
                'description'     => 'Maintain and optimize our cloud infrastructure and CI/CD workflows.',
                'requirements'    => json_encode([
                    'Experience with AWS or Azure',
                    'Strong scripting skills (Bash, Python)',
                    'Knowledge of Kubernetes and Docker',
                    'Monitoring tools like Prometheus/Grafana',
                ]),
                'location'        => 'Biratnagar',
                'employment_type' => 'Full-time',
                'salary_min'      => 50000,
                'salary_max'      => 65000,
                'application_deadline' => $deadline,
                'is_featured'     => false,
                'status'          => 'open',
                'created_at'      => $now,
                'updated_at'      => $now,
            ],
            [
                'organization_id' => 1,
                'category_id'     => $technologyCategory->id,
                'title'           => 'Data Analyst',
                'slug'            => 'data-analyst-' . uniqid(),
                'description'     => 'Analyze user and system data to drive product decisions and improvements.',
                'requirements'    => json_encode([
                    'Proficient in SQL and Excel',
                    'Experience with BI tools (Tableau, PowerBI)',
                    'Understanding of statistical analysis',
                    'Basic Python or R scripting',
                ]),
                'location'        => 'Lalitpur',
                'employment_type' => 'Full-time',
                'salary_min'      => 35000,
                'salary_max'      => 50000,
                'application_deadline' => $deadline,
                'is_featured'     => false,
                'status'          => 'open',
                'created_at'      => $now,
                'updated_at'      => $now,
            ],
            [
                'organization_id' => 2,
                'category_id'     => $designCategory->id,
                'title'           => 'UI/UX Designer',
                'slug'            => 'ui-ux-designer-' . uniqid(),
                'description'     => 'Design intuitive user interfaces and engaging user experiences.',
                'requirements'    => json_encode([
                    '3+ years experience in UI/UX design',
                    'Proficient with Figma or Adobe XD',
                    'Strong portfolio showcasing design projects',
                    'Knowledge of responsive design principles',
                ]),
                'location'        => 'Kathmandu',
                'employment_type' => 'Full-time',
                'salary_min'      => 40000,
                'salary_max'      => 55000,
                'application_deadline' => $deadline,
                'is_featured'     => true,
                'status'          => 'open',
                'created_at'      => $now,
                'updated_at'      => $now,
            ],
            [
                'organization_id' => 2,
                'category_id'     => $technologyCategory->id,
                'title'           => 'Mobile App Developer (Flutter)',
                'slug'            => 'mobile-app-developer-flutter-' . uniqid(),
                'description'     => 'Develop cross-platform mobile applications using Flutter.',
                'requirements'    => json_encode([
                    '2+ years experience with Flutter and Dart',
                    'Experience with Firebase integration',
                    'Knowledge of RESTful APIs',
                    'Familiarity with CI/CD for mobile apps',
                ]),
                'location'        => 'Pokhara',
                'employment_type' => 'Contract',
                'salary_min'      => 45000,
                'salary_max'      => 60000,
                'application_deadline' => $deadline,
                'is_featured'     => false,
                'status'          => 'open',
                'created_at'      => $now,
                'updated_at'      => $now,
            ],
            [
                'organization_id' => 2,
                'category_id'     => $technologyCategory->id,
                'title'           => 'QA Engineer',
                'slug'            => 'qa-engineer-' . uniqid(),
                'description'     => 'Ensure software quality through testing and automation.',
                'requirements'    => json_encode([
                    'Experience with Selenium or Cypress',
                    'Strong understanding of QA methodologies',
                    'Ability to write automated test scripts',
                    'Familiarity with CI pipelines',
                ]),
                'location'        => 'Chitwan',
                'employment_type' => 'Full-time',
                'salary_min'      => 40000,
                'salary_max'      => 50000,
                'application_deadline' => $deadline,
                'is_featured'     => false,
                'status'          => 'open',
                'created_at'      => $now,
                'updated_at'      => $now,
            ],
            [
                'organization_id' => 3,
                'category_id'     => $administrativeCategory->id,
                'title'           => 'Systems Administrator',
                'slug'            => 'systems-administrator-' . uniqid(),
                'description'     => 'Manage and maintain company servers and network infrastructure.',
                'requirements'    => json_encode([
                    '3+ years in system administration',
                    'Experience with Linux and Windows servers',
                    'Knowledge of networking protocols',
                    'Familiarity with virtualization (VMware, Hyper-V)',
                ]),
                'location'        => 'Biratnagar',
                'employment_type' => 'Full-time',
                'salary_min'      => 48000,
                'salary_max'      => 62000,
                'application_deadline' => $deadline,
                'is_featured'     => false,
                'status'          => 'open',
                'created_at'      => $now,
                'updated_at'      => $now,
            ],
            [
                'organization_id' => 3,
                'category_id'     => $marketingCategory->id,
                'title'           => 'Product Manager',
                'slug'            => 'product-manager-' . uniqid(),
                'description'     => 'Lead product vision, roadmap, and feature prioritization.',
                'requirements'    => json_encode([
                    'Proven experience as a Product Manager',
                    'Strong communication skills',
                    'Ability to analyze market trends',
                    'Familiarity with Agile methodologies',
                ]),
                'location'        => 'Lalitpur',
                'employment_type' => 'Full-time',
                'salary_min'      => 60000,
                'salary_max'      => 80000,
                'application_deadline' => $deadline,
                'is_featured'     => true,
                'status'          => 'open',
                'created_at'      => $now,
                'updated_at'      => $now,
            ],
        ]);
    }
}
