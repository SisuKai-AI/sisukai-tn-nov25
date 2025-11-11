<?php

namespace Database\Seeders;

use App\Models\HelpArticle;
use App\Models\HelpCategory;
use Illuminate\Database\Seeder;

class HelpCenterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // First, create help categories
        $categories = [
            [
                'name' => 'Getting Started',
                'slug' => 'getting-started',
                'description' => 'Learn the basics of using SisuKai',
                'order' => 1,
            ],
            [
                'name' => 'Account & Billing',
                'slug' => 'account-billing',
                'description' => 'Manage your account and subscription',
                'order' => 2,
            ],
            [
                'name' => 'Practice Exams',
                'slug' => 'practice-exams',
                'description' => 'How to use our practice exam features',
                'order' => 3,
            ],
            [
                'name' => 'Technical Support',
                'slug' => 'technical-support',
                'description' => 'Troubleshooting and technical issues',
                'order' => 4,
            ],
        ];

        foreach ($categories as $categoryData) {
            if (empty($categoryData['name']) || empty($categoryData['slug'])) {
                $this->command->error("Invalid category data");
                continue;
            }

            $existing = HelpCategory::where('slug', $categoryData['slug'])->first();
            if ($existing) {
                $this->command->info("Help category '{$categoryData['name']}' already exists, skipping...");
                continue;
            }

            HelpCategory::create($categoryData);
            $this->command->info("Created help category: {$categoryData['name']}");
        }

        // Now create help articles
        $gettingStartedCategory = HelpCategory::where('slug', 'getting-started')->first();
        $accountBillingCategory = HelpCategory::where('slug', 'account-billing')->first();
        $practiceExamsCategory = HelpCategory::where('slug', 'practice-exams')->first();
        $technicalSupportCategory = HelpCategory::where('slug', 'technical-support')->first();

        $articles = [
            // Getting Started
            [
                'title' => 'How do I create an account?',
                'slug' => 'how-to-create-account',
                'content' => $this->getCreateAccountContent(),
                'category_id' => $gettingStartedCategory?->id,
                'order' => 1,
                'is_featured' => true,
            ],
            [
                'title' => 'How do I choose the right certification?',
                'slug' => 'choosing-right-certification',
                'content' => $this->getChooseCertificationContent(),
                'category_id' => $gettingStartedCategory?->id,
                'order' => 2,
                'is_featured' => true,
            ],
            [
                'title' => 'What is the adaptive practice engine?',
                'slug' => 'adaptive-practice-engine',
                'content' => $this->getAdaptivePracticeContent(),
                'category_id' => $gettingStartedCategory?->id,
                'order' => 3,
                'is_featured' => false,
            ],
            
            // Account & Billing
            [
                'title' => 'How do I upgrade my subscription?',
                'slug' => 'upgrade-subscription',
                'content' => $this->getUpgradeSubscriptionContent(),
                'category_id' => $accountBillingCategory?->id,
                'order' => 1,
                'is_featured' => true,
            ],
            [
                'title' => 'How do I cancel my subscription?',
                'slug' => 'cancel-subscription',
                'content' => $this->getCancelSubscriptionContent(),
                'category_id' => $accountBillingCategory?->id,
                'order' => 2,
                'is_featured' => true,
            ],
            [
                'title' => 'What is your refund policy?',
                'slug' => 'refund-policy-faq',
                'content' => $this->getRefundPolicyFAQContent(),
                'category_id' => $accountBillingCategory?->id,
                'order' => 3,
                'is_featured' => false,
            ],
            
            // Practice Exams
            [
                'title' => 'How do practice exams work?',
                'slug' => 'how-practice-exams-work',
                'content' => $this->getPracticeExamsWorkContent(),
                'category_id' => $practiceExamsCategory?->id,
                'order' => 1,
                'is_featured' => true,
            ],
            [
                'title' => 'How do I track my progress?',
                'slug' => 'track-progress',
                'content' => $this->getTrackProgressContent(),
                'category_id' => $practiceExamsCategory?->id,
                'order' => 2,
                'is_featured' => false,
            ],
            [
                'title' => 'Can I retake practice exams?',
                'slug' => 'retake-practice-exams',
                'content' => $this->getRetakePracticeExamsContent(),
                'category_id' => $practiceExamsCategory?->id,
                'order' => 3,
                'is_featured' => false,
            ],
            
            // Technical Support
            [
                'title' => 'I forgot my password. How do I reset it?',
                'slug' => 'reset-password',
                'content' => $this->getResetPasswordContent(),
                'category_id' => $technicalSupportCategory?->id,
                'order' => 1,
                'is_featured' => true,
            ],
            [
                'title' => 'The website is loading slowly. What should I do?',
                'slug' => 'slow-loading-website',
                'content' => $this->getSlowLoadingContent(),
                'category_id' => $technicalSupportCategory?->id,
                'order' => 2,
                'is_featured' => false,
            ],
            [
                'title' => 'How do I contact support?',
                'slug' => 'contact-support',
                'content' => $this->getContactSupportContent(),
                'category_id' => $technicalSupportCategory?->id,
                'order' => 3,
                'is_featured' => false,
            ],
        ];

        foreach ($articles as $articleData) {
            if (empty($articleData['title']) || empty($articleData['slug']) || empty($articleData['content'])) {
                $this->command->error("Invalid article data");
                continue;
            }

            $existing = HelpArticle::where('slug', $articleData['slug'])->first();
            if ($existing) {
                $this->command->info("Help article '{$articleData['title']}' already exists, skipping...");
                continue;
            }

            HelpArticle::create($articleData);
            $this->command->info("Created help article: {$articleData['title']}");
        }
    }

    private function getCreateAccountContent(): string
    {
        return <<<'HTML'
<p>Creating a SisuKai account is quick and easy. Follow these steps:</p>

<h3>Step 1: Click "Sign Up"</h3>
<p>Click the "Sign Up" button in the top right corner of the homepage.</p>

<h3>Step 2: Enter Your Information</h3>
<p>Provide the following information:</p>
<ul>
    <li>Full name</li>
    <li>Email address</li>
    <li>Password (at least 8 characters)</li>
</ul>

<h3>Step 3: Verify Your Email</h3>
<p>Check your email inbox for a verification link. Click the link to activate your account.</p>

<h3>Step 4: Choose a Plan</h3>
<p>Select a subscription plan that fits your needs. We offer a 7-day free trial for new users!</p>

<p><strong>Need help?</strong> Contact us at <a href="mailto:support@sisukai.com">support@sisukai.com</a></p>
HTML;
    }

    private function getChooseCertificationContent(): string
    {
        return <<<'HTML'
<p>Choosing the right certification depends on your career goals and current experience level. Here's how to decide:</p>

<h3>1. Assess Your Career Goals</h3>
<p>Consider what you want to achieve:</p>
<ul>
    <li><strong>Cloud Computing:</strong> AWS, Azure, or Google Cloud certifications</li>
    <li><strong>Cybersecurity:</strong> CompTIA Security+, CISSP, or CEH</li>
    <li><strong>Networking:</strong> CCNA or CompTIA Network+</li>
    <li><strong>Project Management:</strong> PMP or CSM</li>
</ul>

<h3>2. Evaluate Your Experience Level</h3>
<ul>
    <li><strong>Beginner:</strong> Start with foundational certifications (e.g., AWS Cloud Practitioner, CompTIA A+)</li>
    <li><strong>Intermediate:</strong> Move to associate-level certifications (e.g., AWS Solutions Architect, Security+)</li>
    <li><strong>Advanced:</strong> Pursue professional or expert certifications (e.g., CISSP, AWS Solutions Architect Professional)</li>
</ul>

<h3>3. Research Job Market Demand</h3>
<p>Check job postings in your area to see which certifications are most in-demand.</p>

<h3>4. Browse Our Certification Catalog</h3>
<p>Explore our <a href="/certifications">certification catalog</a> to see detailed information about each certification, including exam details, prerequisites, and career benefits.</p>

<p><strong>Still unsure?</strong> Contact our team at <a href="mailto:support@sisukai.com">support@sisukai.com</a> for personalized guidance.</p>
HTML;
    }

    private function getAdaptivePracticeContent(): string
    {
        return <<<'HTML'
<p>SisuKai's adaptive practice engine is a powerful feature that personalizes your study experience based on your performance.</p>

<h3>How It Works</h3>
<ol>
    <li><strong>Initial Assessment:</strong> The engine evaluates your baseline knowledge</li>
    <li><strong>Performance Tracking:</strong> It monitors which topics you struggle with</li>
    <li><strong>Personalized Questions:</strong> It serves more questions on your weak areas</li>
    <li><strong>Continuous Adjustment:</strong> As you improve, it adjusts difficulty and focus</li>
</ol>

<h3>Benefits</h3>
<ul>
    <li><strong>Efficient Learning:</strong> Focus on areas that need improvement</li>
    <li><strong>Time Savings:</strong> Don't waste time on topics you've already mastered</li>
    <li><strong>Increased Confidence:</strong> See measurable progress over time</li>
    <li><strong>Higher Pass Rates:</strong> Targeted practice leads to better exam results</li>
</ul>

<h3>How to Use It</h3>
<p>Simply start a practice session, and the adaptive engine will automatically activate. You don't need to configure anything—it works seamlessly in the background.</p>

<p><strong>Pro Tip:</strong> Take practice exams regularly to give the engine more data to work with, resulting in even more personalized recommendations.</p>
HTML;
    }

    private function getUpgradeSubscriptionContent(): string
    {
        return <<<'HTML'
<p>Upgrading your SisuKai subscription is simple. Follow these steps:</p>

<h3>Step 1: Log In to Your Account</h3>
<p>Navigate to your account dashboard.</p>

<h3>Step 2: Go to Subscription Settings</h3>
<p>Click on "Account Settings" in the top right corner, then select "Subscription."</p>

<h3>Step 3: Choose a New Plan</h3>
<p>Review available plans and select the one that best fits your needs:</p>
<ul>
    <li><strong>Single-Cert Access:</strong> $29.99/month - Access to one certification</li>
    <li><strong>All-Access Pass:</strong> $79.99/month - Unlimited certifications</li>
</ul>

<h3>Step 4: Confirm Upgrade</h3>
<p>Click "Upgrade" and confirm your payment method. Your new plan will take effect immediately.</p>

<h3>Billing</h3>
<p>When you upgrade:</p>
<ul>
    <li>You'll be charged a prorated amount for the remainder of your current billing cycle</li>
    <li>Future billing will reflect the new plan price</li>
</ul>

<p><strong>Questions?</strong> Contact us at <a href="mailto:support@sisukai.com">support@sisukai.com</a></p>
HTML;
    }

    private function getCancelSubscriptionContent(): string
    {
        return <<<'HTML'
<p>We're sorry to see you go! You can cancel your subscription at any time. Here's how:</p>

<h3>Step 1: Log In to Your Account</h3>
<p>Navigate to your account dashboard.</p>

<h3>Step 2: Go to Subscription Settings</h3>
<p>Click on "Account Settings" in the top right corner, then select "Subscription."</p>

<h3>Step 3: Cancel Subscription</h3>
<p>Click the "Cancel Subscription" button and confirm your cancellation.</p>

<h3>What Happens Next?</h3>
<ul>
    <li>Your subscription will remain active until the end of your current billing period</li>
    <li>You will not be charged again</li>
    <li>You can reactivate your subscription at any time</li>
</ul>

<h3>Refunds</h3>
<p>If you cancel within 7 days of your initial purchase, you may be eligible for a refund. See our <a href="/legal/refund-policy">Refund Policy</a> for details.</p>

<p><strong>Need help or have feedback?</strong> Contact us at <a href="mailto:support@sisukai.com">support@sisukai.com</a>. We'd love to hear how we can improve!</p>
HTML;
    }

    private function getRefundPolicyFAQContent(): string
    {
        return <<<'HTML'
<p>SisuKai offers a 7-day money-back guarantee for new subscriptions. Here's what you need to know:</p>

<h3>Eligibility</h3>
<p>You may request a full refund if:</p>
<ul>
    <li>You request within 7 days of your initial purchase</li>
    <li>You have not extensively used the platform (more than 50% of questions or 3+ full exams)</li>
</ul>

<h3>Non-Refundable Items</h3>
<ul>
    <li>Subscription renewals (after the first 7 days)</li>
    <li>Partial months or unused portions</li>
    <li>Accounts suspended for Terms of Service violations</li>
</ul>

<h3>How to Request a Refund</h3>
<p>Email <a href="mailto:support@sisukai.com">support@sisukai.com</a> with "Refund Request" in the subject line. Include your account email and reason for the refund.</p>

<h3>Processing Time</h3>
<p>Refunds are processed within 5-10 business days after approval.</p>

<p>For complete details, see our <a href="/legal/refund-policy">Refund Policy</a>.</p>
HTML;
    }

    private function getPracticeExamsWorkContent(): string
    {
        return <<<'HTML'
<p>SisuKai's practice exams are designed to simulate real certification exams and help you prepare effectively.</p>

<h3>Types of Practice Exams</h3>
<ul>
    <li><strong>Practice Mode:</strong> Immediate feedback after each question</li>
    <li><strong>Exam Mode:</strong> Simulates the real exam experience with time limits</li>
    <li><strong>Adaptive Mode:</strong> Personalized questions based on your performance</li>
</ul>

<h3>Features</h3>
<ul>
    <li><strong>Detailed Explanations:</strong> Understand why each answer is correct or incorrect</li>
    <li><strong>Performance Analytics:</strong> Track your progress over time</li>
    <li><strong>Bookmarking:</strong> Save questions for later review</li>
    <li><strong>Timed Sessions:</strong> Practice under exam conditions</li>
</ul>

<h3>How to Start a Practice Exam</h3>
<ol>
    <li>Go to your dashboard</li>
    <li>Select a certification</li>
    <li>Choose "Start Practice Exam"</li>
    <li>Select your preferred mode (Practice, Exam, or Adaptive)</li>
    <li>Begin answering questions!</li>
</ol>

<h3>Tips for Success</h3>
<ul>
    <li>Start with Practice Mode to learn the material</li>
    <li>Use Exam Mode to build test-taking stamina</li>
    <li>Review incorrect answers thoroughly</li>
    <li>Take multiple exams to identify patterns in your weak areas</li>
</ul>
HTML;
    }

    private function getTrackProgressContent(): string
    {
        return <<<'HTML'
<p>SisuKai provides comprehensive analytics to help you track your progress and identify areas for improvement.</p>

<h3>Dashboard Overview</h3>
<p>Your dashboard displays:</p>
<ul>
    <li><strong>Overall Score:</strong> Your average performance across all practice exams</li>
    <li><strong>Progress Chart:</strong> Visual representation of your improvement over time</li>
    <li><strong>Weak Areas:</strong> Topics where you need more practice</li>
    <li><strong>Study Streak:</strong> Consecutive days of practice</li>
</ul>

<h3>Detailed Analytics</h3>
<p>Click on "Analytics" to see:</p>
<ul>
    <li><strong>Domain Breakdown:</strong> Performance by exam domain/topic</li>
    <li><strong>Question History:</strong> All questions you've answered</li>
    <li><strong>Time Analysis:</strong> Average time per question</li>
    <li><strong>Readiness Score:</strong> Estimated likelihood of passing the real exam</li>
</ul>

<h3>Using Analytics to Improve</h3>
<ol>
    <li>Identify your weakest domains</li>
    <li>Focus practice sessions on those areas</li>
    <li>Monitor your progress over time</li>
    <li>Adjust your study plan based on analytics</li>
</ol>

<p><strong>Pro Tip:</strong> Aim for a readiness score of 80% or higher before scheduling your real exam.</p>
HTML;
    }

    private function getRetakePracticeExamsContent(): string
    {
        return <<<'HTML'
<p>Yes! You can retake practice exams as many times as you want. Here's what you need to know:</p>

<h3>Unlimited Retakes</h3>
<p>All SisuKai subscription plans include unlimited practice exam attempts. There are no restrictions on how many times you can retake an exam.</p>

<h3>Benefits of Retaking Exams</h3>
<ul>
    <li><strong>Reinforcement:</strong> Repetition helps solidify knowledge</li>
    <li><strong>Track Improvement:</strong> See how your scores improve over time</li>
    <li><strong>Build Confidence:</strong> Familiarity with question formats reduces test anxiety</li>
    <li><strong>Identify Patterns:</strong> Recognize recurring weak areas</li>
</ul>

<h3>Question Randomization</h3>
<p>Our question bank is large enough that you'll see different questions each time you retake an exam. However, some questions may repeat to reinforce key concepts.</p>

<h3>Best Practices</h3>
<ul>
    <li>Wait at least 24 hours between retakes to allow for knowledge retention</li>
    <li>Review incorrect answers before retaking</li>
    <li>Focus on weak areas identified in your analytics</li>
    <li>Don't just memorize answers—understand the concepts</li>
</ul>

<p><strong>Remember:</strong> The goal is not just to pass practice exams, but to truly understand the material so you can pass the real certification exam.</p>
HTML;
    }

    private function getResetPasswordContent(): string
    {
        return <<<'HTML'
<p>If you've forgotten your password, you can easily reset it. Follow these steps:</p>

<h3>Step 1: Go to the Login Page</h3>
<p>Navigate to the <a href="/login">login page</a>.</p>

<h3>Step 2: Click "Forgot Password"</h3>
<p>Below the login form, click the "Forgot Password?" link.</p>

<h3>Step 3: Enter Your Email</h3>
<p>Enter the email address associated with your SisuKai account.</p>

<h3>Step 4: Check Your Email</h3>
<p>You'll receive a password reset link within a few minutes. Click the link to reset your password.</p>

<h3>Step 5: Create a New Password</h3>
<p>Enter a new password (at least 8 characters) and confirm it.</p>

<h3>Troubleshooting</h3>
<p>If you don't receive the reset email:</p>
<ul>
    <li>Check your spam/junk folder</li>
    <li>Verify you entered the correct email address</li>
    <li>Wait a few minutes and try again</li>
    <li>Contact support at <a href="mailto:support@sisukai.com">support@sisukai.com</a></li>
</ul>

<p><strong>Security Tip:</strong> Use a strong, unique password and consider using a password manager.</p>
HTML;
    }

    private function getSlowLoadingContent(): string
    {
        return <<<'HTML'
<p>If SisuKai is loading slowly, try these troubleshooting steps:</p>

<h3>1. Check Your Internet Connection</h3>
<p>Ensure you have a stable internet connection. Try loading other websites to verify.</p>

<h3>2. Clear Your Browser Cache</h3>
<p>Cached data can sometimes cause performance issues. Clear your browser cache and cookies:</p>
<ul>
    <li><strong>Chrome:</strong> Settings > Privacy and security > Clear browsing data</li>
    <li><strong>Firefox:</strong> Options > Privacy & Security > Clear Data</li>
    <li><strong>Safari:</strong> Preferences > Privacy > Manage Website Data > Remove All</li>
</ul>

<h3>3. Try a Different Browser</h3>
<p>Test SisuKai in another browser (Chrome, Firefox, Safari, Edge) to see if the issue persists.</p>

<h3>4. Disable Browser Extensions</h3>
<p>Some browser extensions can interfere with website performance. Try disabling them temporarily.</p>

<h3>5. Update Your Browser</h3>
<p>Ensure you're using the latest version of your browser.</p>

<h3>6. Check for System Updates</h3>
<p>Make sure your operating system is up to date.</p>

<h3>Still Having Issues?</h3>
<p>If the problem persists, contact our support team at <a href="mailto:support@sisukai.com">support@sisukai.com</a> with the following information:</p>
<ul>
    <li>Your browser and version</li>
    <li>Your operating system</li>
    <li>A description of the issue</li>
    <li>Any error messages you see</li>
</ul>
HTML;
    }

    private function getContactSupportContent(): string
    {
        return <<<'HTML'
<p>We're here to help! There are several ways to contact SisuKai support:</p>

<h3>Email Support</h3>
<p>Send us an email at <a href="mailto:support@sisukai.com">support@sisukai.com</a>. We typically respond within 24 hours (Monday-Friday).</p>

<h3>Contact Form</h3>
<p>Fill out our <a href="/contact">contact form</a> with your question or issue. Include as much detail as possible to help us assist you quickly.</p>

<h3>Help Center</h3>
<p>Browse our <a href="/help">Help Center</a> for answers to common questions. You might find the solution you need right away!</p>

<h3>Social Media</h3>
<p>Follow us on social media for updates and quick responses:</p>
<ul>
    <li><strong>Twitter:</strong> @SisuKai</li>
    <li><strong>LinkedIn:</strong> SisuKai</li>
</ul>

<h3>Response Times</h3>
<ul>
    <li><strong>Email:</strong> Within 24 hours (Monday-Friday)</li>
    <li><strong>Contact Form:</strong> Within 24 hours (Monday-Friday)</li>
    <li><strong>Social Media:</strong> Within 48 hours</li>
</ul>

<h3>Before Contacting Support</h3>
<p>To help us assist you faster, please include:</p>
<ul>
    <li>Your account email address</li>
    <li>A detailed description of the issue</li>
    <li>Screenshots (if applicable)</li>
    <li>Steps to reproduce the problem</li>
</ul>

<p><strong>Emergency Issues:</strong> For urgent account or billing issues, mark your email as "URGENT" in the subject line.</p>
HTML;
    }
}
