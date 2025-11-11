<?php

namespace Database\Seeders;

use App\Models\Testimonial;
use Illuminate\Database\Seeder;

class TestimonialSeeder extends Seeder
{
    public function run(): void
    {
        $testimonials = [
            [
                'author_name' => 'Michael Chen',
                'author_title' => 'Senior IT Manager',
                'author_company' => 'Tech Solutions Inc.',
                'author_photo' => null,
                'content' => 'SisuKai\'s adaptive practice engine helped me pass my PMP certification on the first try. The personalized recommendations focused my study time exactly where I needed it most.',
                'rating' => 5,
                'is_featured' => true,
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'author_name' => 'Sarah Johnson',
                'author_title' => 'Cloud Architect',
                'author_company' => 'Global Systems Corp.',
                'author_photo' => null,
                'content' => 'I earned my AWS Solutions Architect certification in just 6 weeks using SisuKai. The benchmark exams were incredibly realistic and prepared me perfectly for the real thing.',
                'rating' => 5,
                'is_featured' => true,
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'author_name' => 'David Martinez',
                'author_title' => 'Security Analyst',
                'author_company' => 'CyberSafe Solutions',
                'author_photo' => null,
                'content' => 'The CISSP question bank is comprehensive and challenging. SisuKai\'s detailed explanations helped me understand complex security concepts I struggled with for months.',
                'rating' => 5,
                'is_featured' => true,
                'is_active' => true,
                'sort_order' => 3,
            ],
            [
                'author_name' => 'Jennifer Williams',
                'author_title' => 'IT Support Specialist',
                'author_company' => 'Enterprise Tech',
                'author_photo' => null,
                'content' => 'CompTIA A+ was my first certification, and SisuKai made the journey stress-free. The progress tracking kept me motivated, and I passed with a score of 875!',
                'rating' => 5,
                'is_featured' => true,
                'is_active' => true,
                'sort_order' => 4,
            ],
            [
                'author_name' => 'Robert Taylor',
                'author_title' => 'DevOps Engineer',
                'author_company' => 'Cloud Innovations',
                'author_photo' => null,
                'content' => 'After failing my first AWS exam attempt, I found SisuKai. The platform identified my weak areas and helped me pass with flying colors on my second try.',
                'rating' => 5,
                'is_featured' => true,
                'is_active' => true,
                'sort_order' => 5,
            ],
            [
                'author_name' => 'Lisa Anderson',
                'author_title' => 'Project Coordinator',
                'author_company' => 'Agile Ventures',
                'author_photo' => null,
                'content' => 'The PMP exam seemed impossible until I started using SisuKai. The practice sessions with immediate feedback transformed my understanding of project management principles.',
                'rating' => 5,
                'is_featured' => false,
                'is_active' => true,
                'sort_order' => 6,
            ],
            [
                'author_name' => 'James Brown',
                'author_title' => 'Network Administrator',
                'author_company' => 'NetWorks Pro',
                'author_photo' => null,
                'content' => 'SisuKai\'s CompTIA Network+ preparation materials are top-notch. I appreciated the domain-specific practice that let me focus on subnetting and protocols.',
                'rating' => 5,
                'is_featured' => false,
                'is_active' => true,
                'sort_order' => 7,
            ],
            [
                'author_name' => 'Maria Garcia',
                'author_title' => 'Systems Engineer',
                'author_company' => 'Infrastructure Plus',
                'author_photo' => null,
                'content' => 'The exam simulation feature is a game-changer. I felt completely prepared walking into my ITIL certification exam because I\'d already experienced the pressure.',
                'rating' => 5,
                'is_featured' => false,
                'is_active' => true,
                'sort_order' => 8,
            ],
            [
                'author_name' => 'Kevin Thompson',
                'author_title' => 'Solutions Architect',
                'author_company' => 'Digital Transform',
                'author_photo' => null,
                'content' => 'I\'ve used other certification prep platforms, but SisuKai stands out with its intelligent question selection. Every practice session felt tailored to my learning needs.',
                'rating' => 5,
                'is_featured' => false,
                'is_active' => true,
                'sort_order' => 9,
            ],
            [
                'author_name' => 'Amanda White',
                'author_title' => 'Cybersecurity Consultant',
                'author_company' => 'SecureIT Advisory',
                'author_photo' => null,
                'content' => 'SisuKai helped me achieve my CompTIA Security+ certification while working full-time. The flexible practice sessions fit perfectly into my busy schedule.',
                'rating' => 5,
                'is_featured' => false,
                'is_active' => true,
                'sort_order' => 10,
            ],
        ];

        foreach ($testimonials as $testimonial) {
            Testimonial::create($testimonial);
        }
    }
}
