<?php

namespace Database\Seeders;

use App\Models\LegalPage;
use Illuminate\Database\Seeder;

class LegalPagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pages = [
            [
                'title' => 'Privacy Policy',
                'slug' => 'privacy-policy',
                'content' => $this->getPrivacyPolicyContent(),
                'is_published' => true,
            ],
            [
                'title' => 'Terms of Service',
                'slug' => 'terms-of-service',
                'content' => $this->getTermsOfServiceContent(),
                'is_published' => true,
            ],
            [
                'title' => 'Cookie Policy',
                'slug' => 'cookie-policy',
                'content' => $this->getCookiePolicyContent(),
                'is_published' => true,
            ],
            [
                'title' => 'Acceptable Use Policy',
                'slug' => 'acceptable-use-policy',
                'content' => $this->getAcceptableUsePolicyContent(),
                'is_published' => true,
            ],
            [
                'title' => 'Refund Policy',
                'slug' => 'refund-policy',
                'content' => $this->getRefundPolicyContent(),
                'is_published' => true,
            ],
        ];

        foreach ($pages as $pageData) {
            // Validate required fields
            if (empty($pageData['title']) || empty($pageData['slug']) || empty($pageData['content'])) {
                $this->command->error("Invalid legal page data: title, slug, and content are required");
                continue;
            }

            // Check if page already exists
            $existing = LegalPage::where('slug', $pageData['slug'])->first();
            if ($existing) {
                // Update existing page with new content
                $existing->update($pageData);
                $this->command->info("Updated legal page: {$pageData['title']}");
            } else {
                // Create new page
                LegalPage::create($pageData);
                $this->command->info("Created legal page: {$pageData['title']}");
            }
        }
    }

    private function getPrivacyPolicyContent(): string
    {
        return <<<'HTML'
<h1>Privacy Policy</h1>
<p><strong>Last Updated:</strong> November 10, 2025</p>

<p>At SisuKai, we take your privacy seriously. This Privacy Policy explains how we collect, use, disclose, and safeguard your information when you use our certification exam preparation platform.</p>

<h2>1. Information We Collect</h2>

<h3>1.1 Personal Information</h3>
<p>We collect personal information that you voluntarily provide to us when you:</p>
<ul>
    <li>Register for an account</li>
    <li>Subscribe to our services</li>
    <li>Contact customer support</li>
    <li>Subscribe to our newsletter</li>
    <li>Participate in surveys or promotions</li>
</ul>

<p>This information may include:</p>
<ul>
    <li>Name and email address</li>
    <li>Payment information (processed securely through third-party payment processors)</li>
    <li>Profile information (optional, such as job title, company, certification goals)</li>
    <li>Communication preferences</li>
</ul>

<h3>1.2 Usage Information</h3>
<p>We automatically collect certain information when you use SisuKai, including:</p>
<ul>
    <li>Practice exam performance and progress data</li>
    <li>Study patterns and time spent on the platform</li>
    <li>Questions answered and topics studied</li>
    <li>Device information (browser type, operating system, device model)</li>
    <li>IP address and approximate geographic location</li>
    <li>Cookies and similar tracking technologies</li>
    <li>Log data (access times, pages viewed, links clicked)</li>
</ul>

<h2>2. How We Use Your Information</h2>

<p>We use the information we collect to:</p>
<ul>
    <li><strong>Provide our services:</strong> Deliver personalized exam preparation content, track your progress, and provide performance analytics</li>
    <li><strong>Improve our platform:</strong> Analyze usage patterns to enhance user experience, develop new features, and optimize content</li>
    <li><strong>Communicate with you:</strong> Send updates, newsletters, promotional materials, and customer support responses</li>
    <li><strong>Process payments:</strong> Handle subscription billing, process refunds, and prevent fraud</li>
    <li><strong>Ensure security:</strong> Detect and prevent fraud, unauthorized access, and other malicious activities</li>
    <li><strong>Comply with legal obligations:</strong> Meet regulatory requirements and respond to legal requests</li>
    <li><strong>Personalize experience:</strong> Recommend relevant certifications, study materials, and practice questions based on your goals and performance</li>
</ul>

<h2>3. Information Sharing and Disclosure</h2>

<p>We do not sell your personal information to third parties. We may share your information with:</p>

<h3>3.1 Service Providers</h3>
<p>Third-party vendors who perform services on our behalf, including:</p>
<ul>
    <li><strong>Payment processors:</strong> Stripe and Paddle for secure payment processing</li>
    <li><strong>Email service providers:</strong> For sending transactional and marketing emails</li>
    <li><strong>Analytics providers:</strong> Google Analytics and similar tools to understand platform usage</li>
    <li><strong>Cloud hosting providers:</strong> For secure data storage and platform hosting</li>
    <li><strong>Customer support tools:</strong> To provide efficient customer service</li>
</ul>

<p>These service providers are contractually obligated to protect your information and use it only for the purposes we specify.</p>

<h3>3.2 Legal Requirements</h3>
<p>We may disclose your information if required by law or in response to:</p>
<ul>
    <li>Valid legal processes (subpoenas, court orders, search warrants)</li>
    <li>Requests by public authorities (law enforcement, regulatory agencies)</li>
    <li>Protection of our rights, property, or safety</li>
    <li>Investigation of fraud or security issues</li>
</ul>

<h3>3.3 Business Transfers</h3>
<p>In the event of a merger, acquisition, or sale of assets, your information may be transferred to the acquiring entity. We will notify you of any such change in ownership.</p>

<h2>4. Data Security</h2>

<p>We implement appropriate technical and organizational measures to protect your personal information, including:</p>
<ul>
    <li><strong>Encryption:</strong> All data is encrypted in transit (TLS/SSL) and at rest (AES-256)</li>
    <li><strong>Access controls:</strong> Role-based access controls and multi-factor authentication for internal systems</li>
    <li><strong>Secure payment processing:</strong> PCI DSS compliant payment processing through certified providers</li>
    <li><strong>Regular security assessments:</strong> Periodic vulnerability scans and penetration testing</li>
    <li><strong>Employee training:</strong> Regular security awareness training for all staff</li>
    <li><strong>Incident response:</strong> Documented procedures for detecting and responding to security incidents</li>
</ul>

<p>However, no method of transmission over the internet or electronic storage is 100% secure. While we strive to protect your information, we cannot guarantee absolute security.</p>

<h2>5. Your Rights and Choices</h2>

<p>Depending on your location, you may have the following rights:</p>

<h3>5.1 Access and Portability</h3>
<ul>
    <li>Request a copy of your personal information in a portable format</li>
    <li>Download your study progress and performance data</li>
</ul>

<h3>5.2 Correction and Update</h3>
<ul>
    <li>Update or correct inaccurate or incomplete information</li>
    <li>Modify your profile and communication preferences</li>
</ul>

<h3>5.3 Deletion</h3>
<ul>
    <li>Request deletion of your account and personal data</li>
    <li>Note: We may retain certain information as required by law or for legitimate business purposes</li>
</ul>

<h3>5.4 Opt-Out</h3>
<ul>
    <li>Unsubscribe from marketing communications via the link in any email</li>
    <li>Disable cookies through your browser settings</li>
    <li>Opt out of analytics tracking</li>
</ul>

<h3>5.5 Restriction and Objection</h3>
<ul>
    <li>Request restriction of processing in certain circumstances</li>
    <li>Object to processing based on legitimate interests</li>
</ul>

<p>To exercise these rights, contact us at <a href="mailto:privacy@sisukai.com">privacy@sisukai.com</a>. We will respond within 30 days.</p>

<h2>6. Cookies and Tracking Technologies</h2>

<p>We use cookies and similar technologies to:</p>
<ul>
    <li>Remember your login session and preferences</li>
    <li>Analyze site traffic and usage patterns</li>
    <li>Personalize content and study recommendations</li>
    <li>Measure the effectiveness of our marketing campaigns</li>
    <li>Provide social media features</li>
</ul>

<p>You can control cookies through your browser settings. However, disabling cookies may limit your ability to use certain features of our platform. See our <a href="/legal/cookie-policy">Cookie Policy</a> for more details.</p>

<h2>7. Children's Privacy</h2>

<p>SisuKai is not intended for children under 13 years of age. We do not knowingly collect personal information from children under 13. If you are a parent or guardian and believe we have collected information from a child under 13, please contact us immediately at <a href="mailto:privacy@sisukai.com">privacy@sisukai.com</a>, and we will delete the information.</p>

<h2>8. International Data Transfers</h2>

<p>Your information may be transferred to and processed in countries other than your country of residence, including the United States. These countries may have different data protection laws than your jurisdiction.</p>

<p>We ensure appropriate safeguards are in place to protect your information, including:</p>
<ul>
    <li>Standard Contractual Clauses approved by the European Commission</li>
    <li>Privacy Shield certification (where applicable)</li>
    <li>Other legally recognized transfer mechanisms</li>
</ul>

<h2>9. Data Retention</h2>

<p>We retain your personal information for as long as necessary to:</p>
<ul>
    <li>Provide our services to you</li>
    <li>Comply with legal obligations (e.g., tax, accounting requirements)</li>
    <li>Resolve disputes and enforce our agreements</li>
</ul>

<p>Typical retention periods:</p>
<ul>
    <li><strong>Account data:</strong> Duration of your account plus 2 years</li>
    <li><strong>Payment records:</strong> 7 years for tax and accounting purposes</li>
    <li><strong>Marketing data:</strong> Until you opt out or request deletion</li>
    <li><strong>Analytics data:</strong> Aggregated data may be retained indefinitely</li>
</ul>

<h2>10. California Privacy Rights</h2>

<p>If you are a California resident, you have additional rights under the California Consumer Privacy Act (CCPA):</p>
<ul>
    <li>Right to know what personal information is collected, used, shared, or sold</li>
    <li>Right to delete personal information</li>
    <li>Right to opt-out of the sale of personal information (we do not sell personal information)</li>
    <li>Right to non-discrimination for exercising your privacy rights</li>
</ul>

<p>To exercise these rights, contact us at <a href="mailto:privacy@sisukai.com">privacy@sisukai.com</a> or call 1-800-SISUKAI.</p>

<h2>11. European Privacy Rights (GDPR)</h2>

<p>If you are located in the European Economic Area (EEA), UK, or Switzerland, you have rights under the General Data Protection Regulation (GDPR), including:</p>
<ul>
    <li>Right of access to your personal data</li>
    <li>Right to rectification of inaccurate data</li>
    <li>Right to erasure ("right to be forgotten")</li>
    <li>Right to restrict processing</li>
    <li>Right to data portability</li>
    <li>Right to object to processing</li>
    <li>Right to withdraw consent</li>
    <li>Right to lodge a complaint with a supervisory authority</li>
</ul>

<p>Our legal basis for processing your data includes:</p>
<ul>
    <li><strong>Contract performance:</strong> To provide our services</li>
    <li><strong>Legitimate interests:</strong> To improve our platform and prevent fraud</li>
    <li><strong>Consent:</strong> For marketing communications and optional features</li>
    <li><strong>Legal obligation:</strong> To comply with applicable laws</li>
</ul>

<h2>12. Changes to This Privacy Policy</h2>

<p>We may update this Privacy Policy from time to time to reflect changes in our practices, technology, legal requirements, or other factors. We will notify you of any material changes by:</p>
<ul>
    <li>Posting the new Privacy Policy on this page</li>
    <li>Updating the "Last Updated" date</li>
    <li>Sending an email notification (for significant changes)</li>
    <li>Displaying a prominent notice on our platform</li>
</ul>

<p>Your continued use of SisuKai after any changes constitutes your acceptance of the updated Privacy Policy.</p>

<h2>13. Contact Us</h2>

<p>If you have questions, concerns, or requests regarding this Privacy Policy or our data practices, please contact us:</p>

<ul>
    <li><strong>Email:</strong> <a href="mailto:privacy@sisukai.com">privacy@sisukai.com</a></li>
    <li><strong>Mail:</strong> SisuKai, Inc.<br>
        Attn: Privacy Officer<br>
        123 Tech Street, Suite 400<br>
        San Francisco, CA 94105<br>
        United States</li>
    <li><strong>Phone:</strong> 1-800-SISUKAI (1-800-747-8524)</li>
</ul>

<p>For GDPR-related inquiries, you may also contact our EU representative:</p>
<ul>
    <li><strong>Email:</strong> <a href="mailto:gdpr@sisukai.com">gdpr@sisukai.com</a></li>
</ul>
HTML;
    }

    private function getTermsOfServiceContent(): string
    {
        return <<<'HTML'
<h1>Terms of Service</h1>
<p><strong>Last Updated:</strong> November 10, 2025</p>

<p>Welcome to SisuKai! These Terms of Service ("Terms") govern your access to and use of the SisuKai platform and services. By accessing or using SisuKai, you agree to be bound by these Terms.</p>

<h2>1. Acceptance of Terms</h2>

<p>By creating an account, accessing our website, or using any of our services, you acknowledge that you have read, understood, and agree to be bound by these Terms and our <a href="/legal/privacy-policy">Privacy Policy</a>. If you do not agree to these Terms, you may not use our services.</p>

<p>We reserve the right to modify these Terms at any time. We will notify you of any material changes by posting the updated Terms on our website and updating the "Last Updated" date. Your continued use of SisuKai after such changes constitutes your acceptance of the modified Terms.</p>

<h2>2. Description of Services</h2>

<p>SisuKai provides an online platform for certification exam preparation, including:</p>
<ul>
    <li><strong>Practice exams and questions:</strong> Thousands of practice questions across multiple certification programs</li>
    <li><strong>Study guides and resources:</strong> Comprehensive study materials and learning paths</li>
    <li><strong>Performance analytics:</strong> Detailed progress tracking and performance insights</li>
    <li><strong>Adaptive learning:</strong> Personalized study recommendations based on your performance</li>
    <li><strong>Educational content:</strong> Blog articles, tips, and exam strategies</li>
    <li><strong>Community features:</strong> Discussion forums and peer support (where available)</li>
</ul>

<p>We reserve the right to modify, suspend, or discontinue any aspect of our services at any time, with or without notice.</p>

<h2>3. Account Registration</h2>

<h3>3.1 Eligibility</h3>
<p>You must be at least 13 years old to use SisuKai. By registering, you represent and warrant that:</p>
<ul>
    <li>You meet this minimum age requirement</li>
    <li>You have the legal capacity to enter into these Terms</li>
    <li>You will provide accurate and complete information</li>
    <li>You will comply with all applicable laws and regulations</li>
</ul>

<h3>3.2 Account Security</h3>
<p>You are responsible for:</p>
<ul>
    <li>Maintaining the confidentiality of your account credentials (username and password)</li>
    <li>All activities that occur under your account, whether authorized by you or not</li>
    <li>Notifying us immediately of any unauthorized access or security breach</li>
    <li>Using a strong, unique password and enabling two-factor authentication when available</li>
</ul>

<p>We are not liable for any loss or damage arising from your failure to protect your account credentials.</p>

<h3>3.3 Account Information</h3>
<p>You agree to:</p>
<ul>
    <li>Provide accurate, current, and complete information during registration</li>
    <li>Update your information promptly to keep it accurate and current</li>
    <li>Not impersonate any person or entity</li>
    <li>Not create multiple accounts for the same individual</li>
    <li>Not share your account with others</li>
</ul>

<p>We reserve the right to suspend or terminate accounts that contain false, misleading, or incomplete information.</p>

<h2>4. Subscription and Payment</h2>

<h3>4.1 Subscription Plans</h3>
<p>SisuKai offers various subscription plans with different features and pricing:</p>
<ul>
    <li><strong>Single Certification:</strong> Access to one certification program</li>
    <li><strong>All-Access Monthly:</strong> Unlimited access to all certifications, billed monthly</li>
    <li><strong>All-Access Annual:</strong> Unlimited access to all certifications, billed annually</li>
</ul>

<p>Current pricing and plan details are available on our <a href="/pricing">Pricing page</a>.</p>

<h3>4.2 Billing and Payment</h3>
<ul>
    <li><strong>Recurring charges:</strong> Subscriptions automatically renew at the end of each billing period unless canceled before the renewal date</li>
    <li><strong>Payment methods:</strong> We accept major credit cards, debit cards, and other payment methods through our payment processors (Stripe and Paddle)</li>
    <li><strong>Authorization:</strong> By providing payment information, you authorize us to charge your payment method for all fees incurred</li>
    <li><strong>Failed payments:</strong> If a payment fails, we may retry the charge or suspend your access until payment is received</li>
    <li><strong>Price changes:</strong> We reserve the right to change prices with at least 30 days' advance notice. Price changes will apply to subsequent billing periods</li>
</ul>

<h3>4.3 Free Trial</h3>
<p>We may offer free trials for new users:</p>
<ul>
    <li>Free trials typically last 7 days (duration may vary by promotion)</li>
    <li>You will not be charged during the trial period</li>
    <li>You must provide payment information to start a trial</li>
    <li>Your subscription will automatically begin at the end of the trial unless you cancel</li>
    <li>Free trials are limited to one per user</li>
    <li>We reserve the right to determine trial eligibility</li>
</ul>

<h3>4.4 Taxes</h3>
<p>All fees are exclusive of applicable taxes, duties, or similar governmental assessments. You are responsible for paying all taxes associated with your subscription.</p>

<h2>5. Cancellation and Refunds</h2>

<h3>5.1 Cancellation</h3>
<p>You may cancel your subscription at any time through:</p>
<ul>
    <li>Your account settings on our platform</li>
    <li>Contacting customer support at <a href="mailto:support@sisukai.com">support@sisukai.com</a></li>
</ul>

<p>Cancellation takes effect at the end of the current billing period. You will retain access to your subscription until that date. No refunds will be provided for partial billing periods.</p>

<h3>5.2 Refunds</h3>
<p>Refund requests are handled according to our <a href="/legal/refund-policy">Refund Policy</a>. Generally:</p>
<ul>
    <li><strong>30-day money-back guarantee:</strong> Full refund within 30 days of purchase if you are not satisfied</li>
    <li><strong>Eligibility:</strong> Refunds are subject to our refund policy terms and conditions</li>
    <li><strong>Processing time:</strong> Refunds are typically processed within 5-10 business days</li>
    <li><strong>No partial refunds:</strong> We do not provide refunds for unused portions of subscriptions</li>
</ul>

<h2>6. Acceptable Use</h2>

<p>You agree to use SisuKai only for lawful purposes and in accordance with these Terms. You agree NOT to:</p>

<h3>6.1 Prohibited Activities</h3>
<ul>
    <li>Share your account credentials with others or allow others to use your account</li>
    <li>Copy, reproduce, distribute, or create derivative works from our content without written permission</li>
    <li>Use automated tools (bots, scrapers, crawlers) to access our platform or extract data</li>
    <li>Attempt to hack, disrupt, or compromise our systems or security measures</li>
    <li>Upload or transmit viruses, malware, or other malicious code</li>
    <li>Violate any applicable laws, regulations, or third-party rights</li>
    <li>Impersonate others or provide false information</li>
    <li>Harass, abuse, or harm other users</li>
    <li>Interfere with or disrupt the operation of our services</li>
    <li>Use our services to cheat on actual certification exams</li>
    <li>Reverse engineer, decompile, or disassemble any part of our platform</li>
    <li>Remove or modify any copyright, trademark, or proprietary notices</li>
</ul>

<p>Violation of these terms may result in immediate termination of your account and legal action.</p>

<h2>7. Intellectual Property</h2>

<h3>7.1 Our Content</h3>
<p>All content on SisuKai, including but not limited to:</p>
<ul>
    <li>Practice questions and exams</li>
    <li>Study guides and educational materials</li>
    <li>Software, code, and algorithms</li>
    <li>Text, graphics, logos, and images</li>
    <li>Audio, video, and multimedia content</li>
    <li>Trademarks, service marks, and trade names</li>
</ul>

<p>is the exclusive property of SisuKai or its licensors and is protected by copyright, trademark, and other intellectual property laws.</p>

<h3>7.2 Limited License</h3>
<p>We grant you a limited, non-exclusive, non-transferable, revocable license to:</p>
<ul>
    <li>Access and use our services for your personal, non-commercial use</li>
    <li>View and practice with our exam questions and study materials</li>
    <li>Download materials explicitly marked as downloadable</li>
</ul>

<p>This license does not permit you to:</p>
<ul>
    <li>Resell, redistribute, or commercially exploit our content</li>
    <li>Create derivative works or modifications</li>
    <li>Use our content in any way that competes with SisuKai</li>
</ul>

<h3>7.3 User Content</h3>
<p>If you submit content to SisuKai (e.g., forum posts, feedback, suggestions), you grant us a worldwide, perpetual, irrevocable, royalty-free license to use, reproduce, modify, and display such content for any purpose.</p>

<h3>7.4 Trademarks</h3>
<p>SisuKai, our logo, and other marks are trademarks of SisuKai, Inc. You may not use our trademarks without our prior written permission.</p>

<h2>8. Third-Party Content and Links</h2>

<p>Our services may contain links to third-party websites, services, or content. We do not endorse, control, or assume responsibility for any third-party content. Your use of third-party services is at your own risk and subject to their terms and policies.</p>

<h2>9. Disclaimers and Limitations of Liability</h2>

<h3>9.1 No Guarantee of Exam Success</h3>
<p>SisuKai provides study materials and practice exams to help you prepare for certification exams. However:</p>
<ul>
    <li>We do not guarantee that you will pass any certification exam</li>
    <li>Exam success depends on many factors, including your effort, prior knowledge, and exam difficulty</li>
    <li>Our practice questions may not exactly match actual exam questions</li>
    <li>We are not affiliated with or endorsed by certification bodies unless explicitly stated</li>
</ul>

<h3>9.2 Service Availability</h3>
<p>We strive to provide reliable service, but we do not guarantee that:</p>
<ul>
    <li>Our services will be uninterrupted, timely, secure, or error-free</li>
    <li>Any defects or errors will be corrected</li>
    <li>Our services will meet your specific requirements</li>
</ul>

<p>Our services are provided "AS IS" and "AS AVAILABLE" without warranties of any kind, either express or implied.</p>

<h3>9.3 Limitation of Liability</h3>
<p>To the maximum extent permitted by law, SisuKai and its officers, directors, employees, and agents shall not be liable for:</p>
<ul>
    <li>Any indirect, incidental, special, consequential, or punitive damages</li>
    <li>Loss of profits, revenue, data, or use</li>
    <li>Damages arising from your use or inability to use our services</li>
    <li>Damages resulting from unauthorized access to your account</li>
</ul>

<p>Our total liability to you for any claims arising from these Terms or your use of our services shall not exceed the amount you paid to SisuKai in the 12 months preceding the claim.</p>

<h2>10. Indemnification</h2>

<p>You agree to indemnify, defend, and hold harmless SisuKai and its affiliates, officers, directors, employees, and agents from any claims, liabilities, damages, losses, costs, or expenses (including reasonable attorneys' fees) arising from:</p>
<ul>
    <li>Your use of our services</li>
    <li>Your violation of these Terms</li>
    <li>Your violation of any third-party rights</li>
    <li>Your violation of applicable laws or regulations</li>
</ul>

<h2>11. Termination</h2>

<h3>11.1 Termination by You</h3>
<p>You may terminate your account at any time by:</p>
<ul>
    <li>Canceling your subscription through account settings</li>
    <li>Contacting customer support to request account deletion</li>
</ul>

<h3>11.2 Termination by Us</h3>
<p>We reserve the right to suspend or terminate your account at any time, with or without notice, for:</p>
<ul>
    <li>Violation of these Terms</li>
    <li>Fraudulent or illegal activity</li>
    <li>Non-payment of fees</li>
    <li>Prolonged inactivity</li>
    <li>Any reason at our sole discretion</li>
</ul>

<h3>11.3 Effect of Termination</h3>
<p>Upon termination:</p>
<ul>
    <li>Your right to access and use our services will immediately cease</li>
    <li>We may delete your account data (subject to our data retention policies)</li>
    <li>You will not be entitled to any refunds (except as provided in our Refund Policy)</li>
    <li>Provisions that by their nature should survive termination will remain in effect</li>
</ul>

<h2>12. Dispute Resolution</h2>

<h3>12.1 Informal Resolution</h3>
<p>Before filing a claim, you agree to contact us at <a href="mailto:legal@sisukai.com">legal@sisukai.com</a> to attempt to resolve the dispute informally. We will work in good faith to resolve any disputes.</p>

<h3>12.2 Arbitration</h3>
<p>If informal resolution fails, any dispute arising from these Terms or your use of SisuKai shall be resolved through binding arbitration in accordance with the rules of the American Arbitration Association. Arbitration will take place in San Francisco, California.</p>

<h3>12.3 Class Action Waiver</h3>
<p>You agree to resolve disputes on an individual basis only. You waive any right to participate in class actions, class arbitrations, or representative actions.</p>

<h3>12.4 Exceptions</h3>
<p>Either party may seek injunctive relief in court for intellectual property infringement or unauthorized access to our systems.</p>

<h2>13. Governing Law</h2>

<p>These Terms are governed by the laws of the State of California, United States, without regard to its conflict of law provisions. Any legal action or proceeding shall be brought exclusively in the state or federal courts located in San Francisco County, California.</p>

<h2>14. Miscellaneous</h2>

<h3>14.1 Entire Agreement</h3>
<p>These Terms, together with our Privacy Policy and any other policies referenced herein, constitute the entire agreement between you and SisuKai.</p>

<h3>14.2 Severability</h3>
<p>If any provision of these Terms is found to be invalid or unenforceable, the remaining provisions will remain in full force and effect.</p>

<h3>14.3 Waiver</h3>
<p>Our failure to enforce any provision of these Terms does not constitute a waiver of that provision or any other provision.</p>

<h3>14.4 Assignment</h3>
<p>You may not assign or transfer these Terms or your account without our written consent. We may assign these Terms without restriction.</p>

<h3>14.5 Force Majeure</h3>
<p>We are not liable for any failure or delay in performance due to circumstances beyond our reasonable control, including natural disasters, war, terrorism, labor disputes, or internet disruptions.</p>

<h2>15. Contact Us</h2>

<p>If you have questions or concerns about these Terms, please contact us:</p>

<ul>
    <li><strong>Email:</strong> <a href="mailto:legal@sisukai.com">legal@sisukai.com</a></li>
    <li><strong>Support:</strong> <a href="mailto:support@sisukai.com">support@sisukai.com</a></li>
    <li><strong>Mail:</strong> SisuKai, Inc.<br>
        Attn: Legal Department<br>
        123 Tech Street, Suite 400<br>
        San Francisco, CA 94105<br>
        United States</li>
    <li><strong>Phone:</strong> 1-800-SISUKAI (1-800-747-8524)</li>
</ul>
HTML;
    }

    private function getCookiePolicyContent(): string
    {
        return <<<'HTML'
<h1>Cookie Policy</h1>
<p><strong>Last Updated:</strong> November 10, 2025</p>

<p>This Cookie Policy explains how SisuKai ("we", "us", or "our") uses cookies and similar tracking technologies when you visit our website and use our services.</p>

<h2>1. What Are Cookies?</h2>

<p>Cookies are small text files that are placed on your device (computer, smartphone, or tablet) when you visit a website. Cookies allow the website to recognize your device and remember information about your visit, such as your preferences and login status.</p>

<h3>Types of Cookies:</h3>
<ul>
    <li><strong>Session cookies:</strong> Temporary cookies that expire when you close your browser</li>
    <li><strong>Persistent cookies:</strong> Cookies that remain on your device for a set period or until you delete them</li>
    <li><strong>First-party cookies:</strong> Cookies set by SisuKai</li>
    <li><strong>Third-party cookies:</strong> Cookies set by external services we use (e.g., analytics providers)</li>
</ul>

<h2>2. How We Use Cookies</h2>

<p>We use cookies for the following purposes:</p>

<h3>2.1 Essential Cookies (Required)</h3>
<p>These cookies are necessary for our website to function properly. They enable core functionality such as:</p>
<ul>
    <li>User authentication and login sessions</li>
    <li>Security and fraud prevention</li>
    <li>Load balancing and performance optimization</li>
    <li>Remembering your cookie consent preferences</li>
</ul>

<p>You cannot opt out of essential cookies as they are required for the website to work.</p>

<h3>2.2 Performance and Analytics Cookies</h3>
<p>These cookies help us understand how visitors use our website by collecting anonymous information about:</p>
<ul>
    <li>Pages visited and time spent on each page</li>
    <li>Links clicked and navigation patterns</li>
    <li>Error messages encountered</li>
    <li>Device and browser information</li>
</ul>

<p>We use this information to improve our website and services. These cookies do not collect personal information that identifies you.</p>

<p><strong>Services we use:</strong></p>
<ul>
    <li>Google Analytics</li>
    <li>Hotjar (heatmaps and session recordings)</li>
</ul>

<h3>2.3 Functionality Cookies</h3>
<p>These cookies allow our website to remember your preferences and provide enhanced features, such as:</p>
<ul>
    <li>Language and region preferences</li>
    <li>Display settings (e.g., dark mode)</li>
    <li>Recently viewed certifications or study materials</li>
    <li>Personalized content recommendations</li>
</ul>

<h3>2.4 Advertising and Marketing Cookies</h3>
<p>These cookies are used to deliver relevant advertisements and measure the effectiveness of our marketing campaigns. They may:</p>
<ul>
    <li>Track your browsing activity across websites</li>
    <li>Build a profile of your interests</li>
    <li>Deliver targeted ads on third-party websites</li>
    <li>Measure ad performance and conversions</li>
</ul>

<p><strong>Services we use:</strong></p>
<ul>
    <li>Google Ads</li>
    <li>Facebook Pixel</li>
    <li>LinkedIn Insight Tag</li>
</ul>

<p>You can opt out of advertising cookies through your cookie preferences or by using industry opt-out tools.</p>

<h2>3. Other Tracking Technologies</h2>

<p>In addition to cookies, we may use other tracking technologies:</p>

<h3>3.1 Web Beacons (Pixels)</h3>
<p>Small invisible images embedded in web pages or emails that track user behavior, such as:</p>
<ul>
    <li>Email open rates</li>
    <li>Link clicks in emails</li>
    <li>Page views and conversions</li>
</ul>

<h3>3.2 Local Storage</h3>
<p>Browser storage mechanisms (e.g., localStorage, sessionStorage) used to store data locally on your device for:</p>
<ul>
    <li>Caching content for faster loading</li>
    <li>Saving user preferences</li>
    <li>Storing temporary data</li>
</ul>

<h3>3.3 Device Fingerprinting</h3>
<p>Collecting information about your device configuration (browser version, screen resolution, installed fonts) to create a unique identifier for fraud prevention and security purposes.</p>

<h2>4. Cookies We Use</h2>

<p>Below is a detailed list of cookies used on SisuKai:</p>

<h3>Essential Cookies</h3>
<table border="1" cellpadding="10" cellspacing="0" style="width: 100%; border-collapse: collapse;">
    <thead>
        <tr>
            <th>Cookie Name</th>
            <th>Purpose</th>
            <th>Duration</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>sisukai_session</td>
            <td>Maintains your login session</td>
            <td>Session</td>
        </tr>
        <tr>
            <td>XSRF-TOKEN</td>
            <td>Security token for CSRF protection</td>
            <td>Session</td>
        </tr>
        <tr>
            <td>cookie_consent</td>
            <td>Remembers your cookie preferences</td>
            <td>1 year</td>
        </tr>
    </tbody>
</table>

<h3>Analytics Cookies</h3>
<table border="1" cellpadding="10" cellspacing="0" style="width: 100%; border-collapse: collapse;">
    <thead>
        <tr>
            <th>Cookie Name</th>
            <th>Purpose</th>
            <th>Duration</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>_ga</td>
            <td>Google Analytics - distinguishes users</td>
            <td>2 years</td>
        </tr>
        <tr>
            <td>_gid</td>
            <td>Google Analytics - distinguishes users</td>
            <td>24 hours</td>
        </tr>
        <tr>
            <td>_gat</td>
            <td>Google Analytics - throttles request rate</td>
            <td>1 minute</td>
        </tr>
    </tbody>
</table>

<h3>Functionality Cookies</h3>
<table border="1" cellpadding="10" cellspacing="0" style="width: 100%; border-collapse: collapse;">
    <thead>
        <tr>
            <th>Cookie Name</th>
            <th>Purpose</th>
            <th>Duration</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>user_preferences</td>
            <td>Stores your display and language preferences</td>
            <td>1 year</td>
        </tr>
        <tr>
            <td>recent_certs</td>
            <td>Remembers recently viewed certifications</td>
            <td>30 days</td>
        </tr>
    </tbody>
</table>

<h2>5. Managing Your Cookie Preferences</h2>

<p>You have several options to control and manage cookies:</p>

<h3>5.1 Cookie Consent Banner</h3>
<p>When you first visit SisuKai, you will see a cookie consent banner allowing you to:</p>
<ul>
    <li>Accept all cookies</li>
    <li>Reject non-essential cookies</li>
    <li>Customize your cookie preferences</li>
</ul>

<p>You can change your preferences at any time by clicking the "Cookie Settings" link in our footer.</p>

<h3>5.2 Browser Settings</h3>
<p>Most web browsers allow you to control cookies through their settings. You can:</p>
<ul>
    <li>Block all cookies</li>
    <li>Block third-party cookies only</li>
    <li>Delete existing cookies</li>
    <li>Receive notifications when cookies are set</li>
</ul>

<p><strong>Browser-specific instructions:</strong></p>
<ul>
    <li><strong>Chrome:</strong> Settings > Privacy and security > Cookies and other site data</li>
    <li><strong>Firefox:</strong> Settings > Privacy & Security > Cookies and Site Data</li>
    <li><strong>Safari:</strong> Preferences > Privacy > Cookies and website data</li>
    <li><strong>Edge:</strong> Settings > Cookies and site permissions > Cookies and site data</li>
</ul>

<p>Note: Blocking or deleting cookies may affect your ability to use certain features of our website.</p>

<h3>5.3 Opt-Out Tools</h3>
<p>You can opt out of advertising cookies using industry tools:</p>
<ul>
    <li><strong>Digital Advertising Alliance (DAA):</strong> <a href="http://optout.aboutads.info/" target="_blank">optout.aboutads.info</a></li>
    <li><strong>Network Advertising Initiative (NAI):</strong> <a href="http://optout.networkadvertising.org/" target="_blank">optout.networkadvertising.org</a></li>
    <li><strong>European Interactive Digital Advertising Alliance (EDAA):</strong> <a href="http://www.youronlinechoices.com/" target="_blank">youronlinechoices.com</a></li>
</ul>

<h3>5.4 Google Analytics Opt-Out</h3>
<p>You can opt out of Google Analytics by installing the <a href="https://tools.google.com/dlpage/gaoptout" target="_blank">Google Analytics Opt-out Browser Add-on</a>.</p>

<h3>5.5 Do Not Track (DNT)</h3>
<p>Some browsers offer a "Do Not Track" (DNT) signal. Currently, there is no industry standard for how to respond to DNT signals. We do not currently respond to DNT signals, but we respect your cookie preferences set through our cookie consent banner.</p>

<h2>6. Third-Party Cookies</h2>

<p>We use third-party services that may set cookies on your device. These services have their own privacy policies and cookie policies:</p>

<ul>
    <li><strong>Google Analytics:</strong> <a href="https://policies.google.com/privacy" target="_blank">Google Privacy Policy</a></li>
    <li><strong>Stripe (payment processing):</strong> <a href="https://stripe.com/privacy" target="_blank">Stripe Privacy Policy</a></li>
    <li><strong>Paddle (payment processing):</strong> <a href="https://www.paddle.com/legal/privacy" target="_blank">Paddle Privacy Policy</a></li>
    <li><strong>Facebook:</strong> <a href="https://www.facebook.com/privacy/explanation" target="_blank">Facebook Privacy Policy</a></li>
    <li><strong>LinkedIn:</strong> <a href="https://www.linkedin.com/legal/privacy-policy" target="_blank">LinkedIn Privacy Policy</a></li>
</ul>

<p>We do not control these third-party cookies. Please review their policies for more information.</p>

<h2>7. Updates to This Cookie Policy</h2>

<p>We may update this Cookie Policy from time to time to reflect changes in our practices or applicable laws. We will notify you of any material changes by:</p>
<ul>
    <li>Posting the updated policy on this page</li>
    <li>Updating the "Last Updated" date</li>
    <li>Displaying a notice on our website</li>
</ul>

<p>Your continued use of SisuKai after any changes constitutes your acceptance of the updated Cookie Policy.</p>

<h2>8. Contact Us</h2>

<p>If you have questions or concerns about our use of cookies, please contact us:</p>

<ul>
    <li><strong>Email:</strong> <a href="mailto:privacy@sisukai.com">privacy@sisukai.com</a></li>
    <li><strong>Mail:</strong> SisuKai, Inc.<br>
        Attn: Privacy Officer<br>
        123 Tech Street, Suite 400<br>
        San Francisco, CA 94105<br>
        United States</li>
</ul>
HTML;
    }

    private function getAcceptableUsePolicyContent(): string
    {
        return <<<'HTML'
<h1>Acceptable Use Policy</h1>
<p><strong>Last Updated:</strong> November 10, 2025</p>

<p>This Acceptable Use Policy ("AUP") governs your use of SisuKai's services and defines prohibited activities. By using SisuKai, you agree to comply with this AUP.</p>

<h2>1. Purpose</h2>

<p>SisuKai provides certification exam preparation services to help professionals advance their careers. This AUP ensures that our platform remains a safe, secure, and productive environment for all users.</p>

<h2>2. Prohibited Activities</h2>

<p>You may NOT use SisuKai for any of the following purposes:</p>

<h3>2.1 Illegal Activities</h3>
<ul>
    <li>Violating any local, state, national, or international law or regulation</li>
    <li>Engaging in fraudulent activities or identity theft</li>
    <li>Infringing on intellectual property rights of others</li>
    <li>Distributing illegal or unauthorized content</li>
    <li>Facilitating illegal gambling, money laundering, or other criminal activities</li>
</ul>

<h3>2.2 Account Misuse</h3>
<ul>
    <li>Sharing your account credentials with others</li>
    <li>Creating multiple accounts for the same individual to circumvent trial or subscription limits</li>
    <li>Using another person's account without authorization</li>
    <li>Impersonating any person or entity</li>
    <li>Providing false or misleading information during registration</li>
    <li>Creating accounts for the purpose of abusing our services or violating this AUP</li>
</ul>

<h3>2.3 Content Violations</h3>
<ul>
    <li>Copying, reproducing, or distributing our practice questions, exams, or study materials without written permission</li>
    <li>Creating derivative works based on our content</li>
    <li>Selling, licensing, or commercializing our content</li>
    <li>Removing or modifying copyright notices, watermarks, or proprietary markings</li>
    <li>Using our content to create competing exam preparation services</li>
    <li>Sharing screenshots or copies of our questions on public forums, social media, or file-sharing sites</li>
</ul>

<h3>2.4 Technical Abuse</h3>
<ul>
    <li>Using automated tools (bots, scrapers, crawlers) to access our platform or extract data</li>
    <li>Attempting to hack, penetrate, or test the security of our systems without authorization</li>
    <li>Introducing viruses, malware, trojans, worms, or other malicious code</li>
    <li>Performing denial-of-service (DoS) or distributed denial-of-service (DDoS) attacks</li>
    <li>Attempting to gain unauthorized access to other users' accounts or data</li>
    <li>Reverse engineering, decompiling, or disassembling any part of our platform</li>
    <li>Interfering with or disrupting the operation of our services or servers</li>
    <li>Bypassing or circumventing security measures, rate limits, or access controls</li>
</ul>

<h3>2.5 Exam Cheating and Academic Dishonesty</h3>
<ul>
    <li>Using our services to cheat on actual certification exams</li>
    <li>Attempting to memorize our questions to reproduce them on real exams</li>
    <li>Sharing information about actual exam questions (brain dumps)</li>
    <li>Using unauthorized aids during certification exams</li>
    <li>Violating the terms and conditions of certification exam providers</li>
</ul>

<p><strong>Important:</strong> SisuKai is designed to help you <em>learn</em> and <em>prepare</em> for certification exams, not to provide shortcuts or enable cheating. Using our platform to cheat violates both this AUP and the policies of certification exam providers.</p>

<h3>2.6 Harassment and Abuse</h3>
<ul>
    <li>Harassing, threatening, or intimidating other users or our staff</li>
    <li>Posting or transmitting abusive, defamatory, or offensive content</li>
    <li>Engaging in hate speech or discrimination based on race, ethnicity, religion, gender, sexual orientation, disability, or other protected characteristics</li>
    <li>Stalking or doxxing (publishing private information about) other users</li>
    <li>Spamming or sending unsolicited commercial messages</li>
</ul>

<h3>2.7 Payment Fraud</h3>
<ul>
    <li>Using stolen credit cards or payment information</li>
    <li>Initiating chargebacks or payment disputes in bad faith</li>
    <li>Attempting to circumvent payment systems or billing processes</li>
    <li>Exploiting promotional codes or discounts in violation of their terms</li>
</ul>

<h3>2.8 Misrepresentation</h3>
<ul>
    <li>Falsely claiming affiliation with SisuKai</li>
    <li>Misrepresenting our services, features, or pricing</li>
    <li>Using our name, logo, or trademarks without permission</li>
    <li>Creating fake reviews or testimonials</li>
</ul>

<h2>3. Consequences of Violations</h2>

<p>If you violate this AUP, we may take the following actions:</p>

<h3>3.1 Warning</h3>
<p>For minor or first-time violations, we may issue a warning and request that you cease the prohibited activity.</p>

<h3>3.2 Suspension</h3>
<p>We may temporarily suspend your account while we investigate a violation or until you remedy the issue.</p>

<h3>3.3 Termination</h3>
<p>We may permanently terminate your account for:</p>
<ul>
    <li>Serious violations of this AUP</li>
    <li>Repeated violations after warnings</li>
    <li>Violations that cause harm to SisuKai, other users, or third parties</li>
</ul>

<p>Terminated accounts are not eligible for refunds.</p>

<h3>3.4 Legal Action</h3>
<p>We reserve the right to:</p>
<ul>
    <li>Report illegal activities to law enforcement</li>
    <li>Cooperate with legal investigations</li>
    <li>Pursue civil or criminal legal action for violations that cause financial or reputational harm</li>
    <li>Seek injunctive relief to prevent ongoing violations</li>
</ul>

<h3>3.5 Financial Liability</h3>
<p>You may be held financially liable for:</p>
<ul>
    <li>Damages caused by your violations</li>
    <li>Costs incurred in investigating and responding to violations</li>
    <li>Legal fees and expenses</li>
</ul>

<h2>4. Reporting Violations</h2>

<p>If you become aware of any violations of this AUP, please report them to us immediately:</p>

<ul>
    <li><strong>Email:</strong> <a href="mailto:abuse@sisukai.com">abuse@sisukai.com</a></li>
    <li><strong>Subject line:</strong> "AUP Violation Report"</li>
    <li><strong>Include:</strong> Detailed description of the violation, username (if known), and any supporting evidence</li>
</ul>

<p>We will investigate all reports and take appropriate action. We may not be able to provide updates on the status of investigations due to privacy considerations.</p>

<h2>5. Intellectual Property Infringement</h2>

<p>If you believe that content on SisuKai infringes your intellectual property rights, please submit a DMCA notice to:</p>

<ul>
    <li><strong>Email:</strong> <a href="mailto:dmca@sisukai.com">dmca@sisukai.com</a></li>
    <li><strong>Mail:</strong> SisuKai, Inc.<br>
        Attn: DMCA Agent<br>
        123 Tech Street, Suite 400<br>
        San Francisco, CA 94105<br>
        United States</li>
</ul>

<p>Your notice must include:</p>
<ul>
    <li>Identification of the copyrighted work claimed to be infringed</li>
    <li>Identification of the infringing material and its location on our platform</li>
    <li>Your contact information (name, address, phone, email)</li>
    <li>A statement that you have a good faith belief that the use is not authorized</li>
    <li>A statement that the information in the notice is accurate</li>
    <li>Your physical or electronic signature</li>
</ul>

<h2>6. Security Vulnerability Disclosure</h2>

<p>If you discover a security vulnerability in SisuKai, please report it responsibly:</p>

<ul>
    <li><strong>Email:</strong> <a href="mailto:security@sisukai.com">security@sisukai.com</a></li>
    <li><strong>Do NOT:</strong> Publicly disclose the vulnerability before we have had a chance to address it</li>
    <li><strong>Do NOT:</strong> Exploit the vulnerability or access data beyond what is necessary to demonstrate the issue</li>
</ul>

<p>We appreciate responsible disclosure and may offer recognition or rewards for valid security reports.</p>

<h2>7. Acceptable Use Examples</h2>

<p>To clarify what IS acceptable use of SisuKai:</p>

<h3>✅ Acceptable:</h3>
<ul>
    <li>Using our practice exams to prepare for certification exams</li>
    <li>Studying our materials to learn new skills and concepts</li>
    <li>Tracking your progress and performance over time</li>
    <li>Sharing your personal success stories (without revealing our content)</li>
    <li>Recommending SisuKai to friends and colleagues</li>
    <li>Providing feedback and suggestions for improvement</li>
    <li>Canceling your subscription if you are not satisfied</li>
</ul>

<h3>❌ NOT Acceptable:</h3>
<ul>
    <li>Copying our questions to share with others</li>
    <li>Using multiple accounts to get multiple free trials</li>
    <li>Attempting to hack our systems to get free access</li>
    <li>Sharing your login credentials with coworkers</li>
    <li>Using our content to create your own exam prep business</li>
    <li>Posting our questions on public forums or social media</li>
</ul>

<h2>8. Modifications to This Policy</h2>

<p>We may update this Acceptable Use Policy from time to time. We will notify you of any material changes by:</p>
<ul>
    <li>Posting the updated policy on this page</li>
    <li>Updating the "Last Updated" date</li>
    <li>Sending an email notification (for significant changes)</li>
</ul>

<p>Your continued use of SisuKai after any changes constitutes your acceptance of the updated AUP.</p>

<h2>9. Contact Us</h2>

<p>If you have questions about this Acceptable Use Policy, please contact us:</p>

<ul>
    <li><strong>General inquiries:</strong> <a href="mailto:support@sisukai.com">support@sisukai.com</a></li>
    <li><strong>AUP violations:</strong> <a href="mailto:abuse@sisukai.com">abuse@sisukai.com</a></li>
    <li><strong>Security issues:</strong> <a href="mailto:security@sisukai.com">security@sisukai.com</a></li>
    <li><strong>Legal matters:</strong> <a href="mailto:legal@sisukai.com">legal@sisukai.com</a></li>
</ul>
HTML;
    }

    private function getRefundPolicyContent(): string
    {
        return <<<'HTML'
<h1>Refund Policy</h1>
<p><strong>Last Updated:</strong> November 10, 2025</p>

<p>At SisuKai, we want you to be completely satisfied with our certification exam preparation services. This Refund Policy explains our refund process and your rights.</p>

<h2>1. 30-Day Money-Back Guarantee</h2>

<p>We offer a <strong>30-day money-back guarantee</strong> for all new subscriptions. If you are not satisfied with SisuKai for any reason, you may request a full refund within 30 days of your initial purchase.</p>

<h3>1.1 Eligibility</h3>
<p>To be eligible for a refund under our 30-day guarantee:</p>
<ul>
    <li>You must request the refund within 30 calendar days of your initial subscription purchase</li>
    <li>This applies to your first subscription only (not renewals)</li>
    <li>You must not have extensively used the service (see Section 1.2)</li>
    <li>Your account must not have violated our Terms of Service or Acceptable Use Policy</li>
</ul>

<h3>1.2 Excessive Use Limitation</h3>
<p>While we want you to try our services, the 30-day guarantee is not intended for users who consume the majority of our content and then request a refund. We reserve the right to deny refunds if:</p>
<ul>
    <li>You have completed more than 70% of available practice questions for a certification</li>
    <li>You have taken more than 10 full-length practice exams</li>
    <li>Your usage pattern suggests abuse of the refund policy</li>
</ul>

<p>This limitation ensures fairness for all users and prevents abuse of our generous refund policy.</p>

<h2>2. Subscription Renewals</h2>

<h3>2.1 No Refunds for Renewals</h3>
<p>Subscription renewals (monthly or annual) are <strong>not eligible for refunds</strong>. This includes:</p>
<ul>
    <li>Automatic renewals of monthly subscriptions</li>
    <li>Automatic renewals of annual subscriptions</li>
    <li>Manual renewals after cancellation</li>
</ul>

<h3>2.2 Cancellation Before Renewal</h3>
<p>To avoid being charged for a renewal:</p>
<ul>
    <li>Cancel your subscription at least 24 hours before the renewal date</li>
    <li>You can cancel anytime through your account settings</li>
    <li>After cancellation, you will retain access until the end of your current billing period</li>
</ul>

<h2>3. Partial Refunds</h2>

<p>We generally do not provide partial refunds or prorated refunds for:</p>
<ul>
    <li>Unused portions of monthly subscriptions</li>
    <li>Unused portions of annual subscriptions</li>
    <li>Downgrading from a higher-tier plan to a lower-tier plan</li>
    <li>Cancellations in the middle of a billing period</li>
</ul>

<p><strong>Exception:</strong> We may provide prorated refunds on a case-by-case basis for extenuating circumstances (e.g., serious illness, death in family, military deployment). Please contact our support team to discuss your situation.</p>

<h2>4. Free Trials</h2>

<h3>4.1 Trial Period</h3>
<p>We offer a <strong>7-day free trial</strong> for new users (trial duration may vary by promotion). During the trial:</p>
<ul>
    <li>You have full access to all features</li>
    <li>You will not be charged</li>
    <li>You can cancel anytime without penalty</li>
</ul>

<h3>4.2 Trial to Paid Conversion</h3>
<p>If you do not cancel before the trial ends:</p>
<ul>
    <li>Your subscription will automatically begin</li>
    <li>Your payment method will be charged</li>
    <li>The 30-day money-back guarantee will apply from the date of the first charge</li>
</ul>

<h3>4.3 One Trial Per User</h3>
<p>Free trials are limited to one per user. Creating multiple accounts to obtain additional free trials violates our Terms of Service and may result in account termination without refund.</p>

<h2>5. Refund Process</h2>

<h3>5.1 How to Request a Refund</h3>
<p>To request a refund:</p>
<ol>
    <li>Contact our support team at <a href="mailto:support@sisukai.com">support@sisukai.com</a></li>
    <li>Include your account email address and reason for the refund request</li>
    <li>Provide your order number or transaction ID (if available)</li>
</ol>

<p>Alternatively, you can submit a refund request through your account settings under "Billing > Request Refund".</p>

<h3>5.2 Review Process</h3>
<p>Once we receive your refund request:</p>
<ul>
    <li>We will review your request within 2-3 business days</li>
    <li>We may contact you for additional information</li>
    <li>We will verify your eligibility based on this policy</li>
    <li>You will receive an email notification of our decision</li>
</ul>

<h3>5.3 Refund Processing Time</h3>
<p>If your refund is approved:</p>
<ul>
    <li>We will process the refund within 5-10 business days</li>
    <li>The refund will be issued to your original payment method</li>
    <li>Depending on your bank or card issuer, it may take an additional 5-10 business days for the refund to appear in your account</li>
</ul>

<h3>5.4 Account Access After Refund</h3>
<p>Once a refund is processed:</p>
<ul>
    <li>Your subscription will be canceled</li>
    <li>You will lose access to all premium features</li>
    <li>Your account data may be deleted (subject to our data retention policy)</li>
</ul>

<h2>6. Special Circumstances</h2>

<h3>6.1 Technical Issues</h3>
<p>If you experience technical issues that prevent you from using SisuKai:</p>
<ul>
    <li>Contact our support team immediately</li>
    <li>We will work to resolve the issue as quickly as possible</li>
    <li>If we cannot resolve the issue within a reasonable time, we may offer a refund or account credit</li>
</ul>

<h3>6.2 Billing Errors</h3>
<p>If you were charged incorrectly due to a billing error:</p>
<ul>
    <li>Contact us within 60 days of the charge</li>
    <li>We will investigate and correct any errors</li>
    <li>If an error is confirmed, we will issue a full refund</li>
</ul>

<h3>6.3 Duplicate Charges</h3>
<p>If you were charged multiple times for the same subscription:</p>
<ul>
    <li>Contact us immediately</li>
    <li>We will refund any duplicate charges</li>
    <li>This typically occurs due to payment processing errors and is resolved quickly</li>
</ul>

<h3>6.4 Unauthorized Charges</h3>
<p>If you believe a charge was unauthorized:</p>
<ul>
    <li>Contact us immediately at <a href="mailto:support@sisukai.com">support@sisukai.com</a></li>
    <li>We will investigate the charge</li>
    <li>If the charge was unauthorized, we will issue a full refund and secure your account</li>
    <li>We may also recommend you contact your bank or card issuer</li>
</ul>

<h2>7. Chargebacks and Disputes</h2>

<h3>7.1 Contact Us First</h3>
<p>Before initiating a chargeback or payment dispute with your bank:</p>
<ul>
    <li>Please contact us first to resolve the issue</li>
    <li>Most issues can be resolved quickly without a chargeback</li>
    <li>Chargebacks can result in additional fees and account termination</li>
</ul>

<h3>7.2 Chargeback Consequences</h3>
<p>If you initiate a chargeback:</p>
<ul>
    <li>Your account will be immediately suspended pending investigation</li>
    <li>If the chargeback is found to be unjustified, your account may be permanently terminated</li>
    <li>You may be liable for chargeback fees and legal costs</li>
    <li>Future purchases may be restricted</li>
</ul>

<h3>7.3 Fraudulent Chargebacks</h3>
<p>Initiating a chargeback for a service you received and used constitutes fraud. We reserve the right to:</p>
<ul>
    <li>Report fraudulent chargebacks to credit bureaus</li>
    <li>Pursue legal action to recover losses</li>
    <li>Ban you from using SisuKai in the future</li>
</ul>

<h2>8. Exceptions and Limitations</h2>

<h3>8.1 Non-Refundable Items</h3>
<p>The following are <strong>not eligible for refunds</strong> under any circumstances:</p>
<ul>
    <li>One-time certification purchases after you have accessed the content</li>
    <li>Promotional or discounted subscriptions obtained through special offers (unless otherwise stated)</li>
    <li>Gift subscriptions (refunds must be requested by the purchaser, not the recipient)</li>
    <li>Subscriptions purchased through third-party platforms (e.g., app stores) - refund policies of those platforms apply</li>
</ul>

<h3>8.2 Refund Abuse</h3>
<p>We reserve the right to deny refunds or ban users who:</p>
<ul>
    <li>Repeatedly subscribe and request refunds</li>
    <li>Use our service extensively and then request a refund</li>
    <li>Provide false information to obtain a refund</li>
    <li>Violate our Terms of Service or Acceptable Use Policy</li>
</ul>

<h2>9. Currency and Exchange Rates</h2>

<p>Refunds are processed in the same currency as the original purchase. If your bank or card issuer applies currency conversion:</p>
<ul>
    <li>The refund amount may differ slightly due to exchange rate fluctuations</li>
    <li>We are not responsible for currency conversion fees or rate differences</li>
    <li>Contact your bank if you have questions about conversion rates</li>
</ul>

<h2>10. Taxes</h2>

<p>If taxes were included in your original purchase:</p>
<ul>
    <li>Taxes will be refunded along with the subscription fee</li>
    <li>You are responsible for any tax implications of the refund in your jurisdiction</li>
    <li>Consult a tax professional if you have questions</li>
</ul>

<h2>11. Contact Us</h2>

<p>If you have questions about our Refund Policy or need to request a refund, please contact us:</p>

<ul>
    <li><strong>Email:</strong> <a href="mailto:support@sisukai.com">support@sisukai.com</a></li>
    <li><strong>Subject line:</strong> "Refund Request" or "Refund Policy Question"</li>
    <li><strong>Phone:</strong> 1-800-SISUKAI (1-800-747-8524)</li>
    <li><strong>Hours:</strong> Monday-Friday, 9 AM - 6 PM PST</li>
</ul>

<p>We strive to respond to all refund requests within 2-3 business days.</p>

<h2>12. Changes to This Policy</h2>

<p>We may update this Refund Policy from time to time. Any changes will:</p>
<ul>
    <li>Be posted on this page with an updated "Last Updated" date</li>
    <li>Apply to purchases made after the effective date of the change</li>
    <li>Not affect refund requests for purchases made before the change</li>
</ul>

<p>We encourage you to review this policy periodically.</p>
HTML;
    }
}
