<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Faq;

class FaqSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faqs = [
            [
                'question' => 'How do I create an account?',
                'answer' => 'To create an account, click on the "Register" button in the top-right corner of any page. Fill in your personal information, select your account type (Job Seeker or Employer), and submit the form. You\'ll receive an email confirmation to activate your account.',
                'order' => 1,
            ],
            [
                'question' => 'How do I post a job as an employer?',
                'answer' => 'Log in to your employer account, go to your dashboard, and click on "Post a Job". Fill in the job details including title, description, requirements, and other relevant information. Review and submit your job posting. Your job will appear in our listings after being approved.',
                'order' => 2,
            ],
            [
                'question' => 'How do I apply for jobs?',
                'answer' => 'To apply for a job, you need to create a candidate account and complete your profile. Once logged in, browse the job listings, click on a job you\'re interested in, and click the "Apply Now" button. Follow the application instructions and submit your application.',
                'order' => 3,
            ],
            [
                'question' => 'How can I update my profile information?',
                'answer' => 'Log in to your account and click on your profile name in the top-right corner. Select "Profile" from the dropdown menu. On your profile page, click "Edit Profile" to update your information. Don\'t forget to save your changes.',
                'order' => 4,
            ],
            [
                'question' => 'Can I use the same account for both job seeking and posting jobs?',
                'answer' => 'Yes, you can register for both candidate and employer accounts using the same email. After creating your initial account, go to your profile and enable the other role. You can switch between roles using the role switcher in the top navigation bar.',
                'order' => 5,
            ],
            [
                'question' => 'How long do job postings stay active?',
                'answer' => 'Job postings remain active for 30 days by default, but employers can specify a different application deadline. Jobs are automatically marked as expired after the deadline passes, but employers can reactivate them at any time.',
                'order' => 6,
            ],
            [
                'question' => 'Is my personal information secure?',
                'answer' => 'We take data security very seriously and comply with data protection regulations. Your personal information is encrypted and stored securely. We only share your information with employers you apply to, and you can control what information is visible to others in your privacy settings.',
                'order' => 7,
            ],
            [
                'question' => 'How can I contact support?',
                'answer' => 'If you need assistance, you can reach our support team by clicking on the "Contact Us" link in the footer of any page. Alternatively, you can email us directly at support@jobportal.com or call our helpline at +1-123-456-7890 during business hours.',
                'order' => 8,
            ],
        ];
        
        foreach ($faqs as $faq) {
            Faq::create([
                'question' => $faq['question'],
                'answer' => $faq['answer'],
                'is_published' => true,
                'order' => $faq['order'],
            ]);
        }
    }
}
