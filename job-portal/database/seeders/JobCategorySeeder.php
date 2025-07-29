<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\JobCategory;
use Illuminate\Support\Str;

class JobCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'Technology' => 'Jobs in software development, IT, data science, and other tech fields.',
            'Finance' => 'Jobs in accounting, banking, investment, and financial services.',
            'Healthcare' => 'Jobs in medical care, nursing, pharmacy, and healthcare administration.',
            'Education' => 'Jobs in teaching, administration, and educational services.',
            'Marketing' => 'Jobs in digital marketing, advertising, PR, and communications.',
            'Sales' => 'Jobs in sales, business development, and account management.',
            'Customer Service' => 'Jobs in customer support, service, and experience.',
            'Design' => 'Jobs in graphic design, UX/UI design, and creative services.',
            'Engineering' => 'Jobs in engineering, manufacturing, and construction.',
            'Human Resources' => 'Jobs in HR, recruiting, and people operations.',
            'Legal' => 'Jobs in law, compliance, and legal services.',
            'Administrative' => 'Jobs in office administration and support.',
            'Hospitality' => 'Jobs in hotels, tourism, events, and food service.',
            'Retail' => 'Jobs in retail sales and management.',
            'Transportation' => 'Jobs in logistics, transportation, and supply chain.',
            'Media' => 'Jobs in journalism, publishing, and content creation.',
        ];
          foreach ($categories as $name => $description) {
            JobCategory::firstOrCreate(
                ['slug' => Str::slug($name)],
                [
                    'name' => $name,
                    'description' => $description,
                ]
            );
        }
    }
}
