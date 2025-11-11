<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     * 
     * Organized in 6 phases to ensure proper dependency order:
     * 1. Authentication & Authorization
     * 2. Certifications & Questions
     * 3. Landing Portal Content
     * 4. Subscription & Payment
     * 5. Help Center
     * 6. Quiz & Settings
     */
    public function run(): void
    {
        $this->command->info('');
        $this->command->info('═══════════════════════════════════════════════════════════');
        $this->command->info('  SisuKai Database Seeder - Starting Full Seed');
        $this->command->info('═══════════════════════════════════════════════════════════');
        $this->command->info('');
        
        // ============================================================
        // PHASE 1: Authentication & Authorization
        // ============================================================
        $this->command->info('📋 PHASE 1: Authentication & Authorization');
        $this->command->info('───────────────────────────────────────────────────────────');
        
        $this->call([
            RoleSeeder::class,              // Create roles (admin, learner)
            PermissionSeeder::class,        // Create permissions
            RolePermissionSeeder::class,    // Assign permissions to roles
            AdminUserSeeder::class,         // Create admin users
            LearnerSeeder::class,           // Create test learners
        ]);
        
        $this->command->info('');
        
        // ============================================================
        // PHASE 2: Certifications & Questions
        // ============================================================
        $this->command->info('📚 PHASE 2: Certifications & Questions');
        $this->command->info('───────────────────────────────────────────────────────────');
        
        $this->call([
            CertificationSeeder::class,     // Create 18 certifications
            DomainSeeder::class,            // Create domains per certification
            TopicSeeder::class,             // Create topics per domain
            QuestionSeeder::class,          // Create 1,268 questions with answers
        ]);
        
        $this->command->info('');
        
        // ============================================================
        // PHASE 3: Landing Portal Content
        // ============================================================
        $this->command->info('🌐 PHASE 3: Landing Portal Content');
        $this->command->info('───────────────────────────────────────────────────────────');
        
        $this->call([
            BlogCategoriesSeeder::class,    // Create blog categories
            BlogPostsSeeder::class,         // Create 5 blog posts
            LegalPagesSeeder::class,        // Create 5 legal pages (comprehensive)
            TestimonialSeeder::class,       // Create 10 testimonials
        ]);
        
        $this->command->info('');
        
        // ============================================================
        // PHASE 4: Subscription & Payment
        // ============================================================
        $this->command->info('💳 PHASE 4: Subscription & Payment');
        $this->command->info('───────────────────────────────────────────────────────────');
        
        $this->call([
            SubscriptionPlanSeeder::class,          // Create 3 subscription plans
            PaymentProcessorSettingsSeeder::class,  // Create Stripe & Paddle settings
        ]);
        
        $this->command->info('');
        
        // ============================================================
        // PHASE 5: Help Center
        // ============================================================
        $this->command->info('❓ PHASE 5: Help Center');
        $this->command->info('───────────────────────────────────────────────────────────');
        
        $this->call([
            HelpCenterSeeder::class,        // Create help categories & articles
        ]);
        
        $this->command->info('');
        
        // ============================================================
        // PHASE 6: Quiz & Settings
        // ============================================================
        $this->command->info('⚙️  PHASE 6: Quiz & Settings');
        $this->command->info('───────────────────────────────────────────────────────────');
        
        $this->call([
            CertificationLandingQuizQuestionsSeeder::class,  // Create landing page quiz questions
        ]);
        
        $this->command->info('');
        
        // ============================================================
        // Summary
        // ============================================================
        $this->displaySummary();
    }
    
    /**
     * Display seeding summary with statistics
     */
    private function displaySummary(): void
    {
        $this->command->info('═══════════════════════════════════════════════════════════');
        $this->command->info('  Database Seeding Summary');
        $this->command->info('═══════════════════════════════════════════════════════════');
        $this->command->info('');
        
        // Get counts from database
        $stats = [
            ['Category', 'Table', 'Count'],
            ['─────────────────', '──────────────────────────', '─────'],
            ['Auth', 'Roles', \DB::table('roles')->count()],
            ['Auth', 'Permissions', \DB::table('permissions')->count()],
            ['Auth', 'Admin Users', \DB::table('users')->where('user_type', 'admin')->count()],
            ['Auth', 'Learners', \DB::table('learners')->count()],
            ['', '', ''],
            ['Certifications', 'Certifications', \DB::table('certifications')->count()],
            ['Certifications', 'Domains', \DB::table('domains')->count()],
            ['Certifications', 'Topics', \DB::table('topics')->count()],
            ['Certifications', 'Questions', \DB::table('questions')->count()],
            ['Certifications', 'Answers', \DB::table('answers')->count()],
            ['', '', ''],
            ['Landing Portal', 'Blog Categories', \DB::table('blog_categories')->count()],
            ['Landing Portal', 'Blog Posts', \DB::table('blog_posts')->count()],
            ['Landing Portal', 'Legal Pages', \DB::table('legal_pages')->count()],
            ['Landing Portal', 'Testimonials', \DB::table('testimonials')->count()],
            ['', '', ''],
            ['Subscription', 'Subscription Plans', \DB::table('subscription_plans')->count()],
            ['Subscription', 'Payment Processors', \DB::table('payment_processor_settings')->count()],
            ['', '', ''],
            ['Help Center', 'Help Categories', \DB::table('help_categories')->count()],
            ['Help Center', 'Help Articles', \DB::table('help_articles')->count()],
            ['', '', ''],
            ['Quiz', 'Landing Quiz Questions', \DB::table('certification_landing_quiz_questions')->count()],
            ['Settings', 'Settings', \DB::table('settings')->count()],
        ];
        
        // Calculate column widths
        $col1Width = 20;
        $col2Width = 30;
        $col3Width = 10;
        
        // Display table
        foreach ($stats as $row) {
            if ($row[0] === '─────────────────') {
                $this->command->info(str_repeat('─', $col1Width + $col2Width + $col3Width + 6));
            } else {
                $line = sprintf(
                    '  %-' . $col1Width . 's  %-' . $col2Width . 's  %' . $col3Width . 's',
                    $row[0],
                    $row[1],
                    $row[2]
                );
                $this->command->info($line);
            }
        }
        
        $this->command->info('');
        $this->command->info('═══════════════════════════════════════════════════════════');
        $this->command->info('  ✅ Database seeding completed successfully!');
        $this->command->info('═══════════════════════════════════════════════════════════');
        $this->command->info('');
    }
}
