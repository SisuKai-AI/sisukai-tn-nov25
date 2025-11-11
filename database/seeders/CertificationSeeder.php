<?php

namespace Database\Seeders;

use App\Models\Certification;
use Illuminate\Database\Seeder;

class CertificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $certifications = [
            // Cloud Computing & DevOps
            [
                'name' => 'AWS Certified Cloud Practitioner',
                'slug' => 'aws-certified-cloud-practitioner',
                'provider' => 'Amazon Web Services',
                'description' => 'The AWS Certified Cloud Practitioner exam is intended for individuals who can effectively demonstrate an overall knowledge of the AWS Cloud, independent of a specific job role. The exam validates a candidate\'s ability to understand AWS Cloud concepts, AWS services, security, architecture, pricing, and support.',
                'exam_question_count' => 65,
                'exam_duration_minutes' => 90,
                'passing_score' => 70,
                'price_single_cert' => 100.00,
                'is_active' => true,
            ],
            [
                'name' => 'AWS Certified Solutions Architect - Associate',
                'slug' => 'aws-certified-solutions-architect-associate',
                'provider' => 'Amazon Web Services',
                'description' => 'The AWS Certified Solutions Architect - Associate exam is intended for individuals who perform a solutions architect role. The exam validates a candidate\'s ability to design distributed systems on AWS, including selecting appropriate AWS services, defining technical requirements, and designing resilient and cost-optimized architectures.',
                'exam_question_count' => 65,
                'exam_duration_minutes' => 130,
                'passing_score' => 72,
                'price_single_cert' => 150.00,
                'is_active' => true,
            ],
            [
                'name' => 'Microsoft Azure Fundamentals (AZ-900)',
                'slug' => 'microsoft-azure-fundamentals-az-900',
                'provider' => 'Microsoft',
                'description' => 'The Azure Fundamentals exam is an opportunity to prove knowledge of cloud concepts, Azure services, Azure workloads, security and privacy in Azure, as well as Azure pricing and support. Candidates should be familiar with the general technology concepts, including concepts of networking, storage, compute, application support, and application development.',
                'exam_question_count' => 50,
                'exam_duration_minutes' => 60,
                'passing_score' => 70,
                'price_single_cert' => 99.00,
                'is_active' => true,
            ],
            [
                'name' => 'Google Cloud Digital Leader',
                'slug' => 'google-cloud-digital-leader',
                'provider' => 'Google Cloud',
                'description' => 'The Cloud Digital Leader certification demonstrates your knowledge of cloud computing basics and how Google Cloud products and services can be used to achieve an organization\'s goals. This certification is intended for individuals who can articulate the capabilities of Google Cloud core products and services and how they benefit organizations.',
                'exam_question_count' => 55,
                'exam_duration_minutes' => 90,
                'passing_score' => 70,
                'price_single_cert' => 99.00,
                'is_active' => true,
            ],
            [
                'name' => 'Certified Kubernetes Administrator (CKA)',
                'slug' => 'certified-kubernetes-administrator-cka',
                'provider' => 'Cloud Native Computing Foundation',
                'description' => 'The Certified Kubernetes Administrator (CKA) program provides assurance that CKAs have the skills, knowledge, and competency to perform the responsibilities of Kubernetes administrators. The exam is performance-based and requires solving multiple tasks from a command line running Kubernetes.',
                'exam_question_count' => 17,
                'exam_duration_minutes' => 120,
                'passing_score' => 66,
                'price_single_cert' => 395.00,
                'is_active' => true,
            ],

            // Cybersecurity
            [
                'name' => 'CompTIA Security+',
                'slug' => 'comptia-security-plus',
                'provider' => 'CompTIA',
                'description' => 'The CompTIA Security+ certification is a global certification that validates the baseline skills necessary to perform core security functions and pursue an IT security career. It establishes the core knowledge required of any cybersecurity role and provides a springboard to intermediate-level cybersecurity jobs.',
                'exam_question_count' => 90,
                'exam_duration_minutes' => 90,
                'passing_score' => 75,
                'price_single_cert' => 392.00,
                'is_active' => true,
            ],
            [
                'name' => 'Certified Information Systems Security Professional (CISSP)',
                'slug' => 'cissp',
                'provider' => '(ISC)²',
                'description' => 'The CISSP certification is an internationally recognized standard of achievement that confirms an individual\'s knowledge in the field of information security. CISSP professionals are information assurance leaders who design, engineer, implement, and manage their overall information security program.',
                'exam_question_count' => 150,
                'exam_duration_minutes' => 180,
                'passing_score' => 70,
                'price_single_cert' => 749.00,
                'is_active' => true,
            ],
            [
                'name' => 'Certified Ethical Hacker (CEH)',
                'slug' => 'certified-ethical-hacker-ceh',
                'provider' => 'EC-Council',
                'description' => 'The Certified Ethical Hacker (CEH) certification validates your ability to think like a hacker and use the same tools and techniques to identify and fix vulnerabilities. CEH professionals understand attack strategies, use of penetration testing tools, and vulnerability assessment methodologies.',
                'exam_question_count' => 125,
                'exam_duration_minutes' => 240,
                'passing_score' => 70,
                'price_single_cert' => 1199.00,
                'is_active' => true,
            ],
            [
                'name' => 'CompTIA CySA+ (Cybersecurity Analyst)',
                'slug' => 'comptia-cysa-plus',
                'provider' => 'CompTIA',
                'description' => 'CompTIA CySA+ is a certification for cyber professionals tasked with incident detection, prevention and response through continuous security monitoring. The exam validates an IT professional\'s ability to proactively defend and continuously improve the security of an organization.',
                'exam_question_count' => 85,
                'exam_duration_minutes' => 165,
                'passing_score' => 75,
                'price_single_cert' => 392.00,
                'is_active' => true,
            ],
            [
                'name' => 'GIAC Security Essentials (GSEC)',
                'slug' => 'giac-security-essentials-gsec',
                'provider' => 'GIAC',
                'description' => 'The GIAC Security Essentials certification validates a practitioner\'s knowledge of information security beyond simple terminology and concepts. GSEC certification holders are demonstrating that they are qualified for hands-on IT systems roles with respect to security tasks.',
                'exam_question_count' => 143,
                'exam_duration_minutes' => 240,
                'passing_score' => 73,
                'price_single_cert' => 949.00,
                'is_active' => true,
            ],

            // IT Fundamentals & Networking
            [
                'name' => 'CompTIA A+',
                'slug' => 'comptia-a-plus',
                'provider' => 'CompTIA',
                'description' => 'CompTIA A+ is the industry standard for launching IT careers into today\'s digital world. It is the only industry recognized credential with performance testing to prove pros can think on their feet to perform critical IT support tasks. CompTIA A+ is trusted by employers around the world to identify the go-to person in end point management and technical support roles.',
                'exam_question_count' => 90,
                'exam_duration_minutes' => 90,
                'passing_score' => 75,
                'price_single_cert' => 246.00,
                'is_active' => true,
            ],
            [
                'name' => 'CompTIA Network+',
                'slug' => 'comptia-network-plus',
                'provider' => 'CompTIA',
                'description' => 'CompTIA Network+ validates the technical skills needed to securely establish, maintain and troubleshoot the essential networks that businesses rely on. Unlike other vendor-specific networking certifications, CompTIA Network+ prepares candidates to support networks on any platform.',
                'exam_question_count' => 90,
                'exam_duration_minutes' => 90,
                'passing_score' => 72,
                'price_single_cert' => 358.00,
                'is_active' => true,
            ],
            [
                'name' => 'Cisco Certified Network Associate (CCNA)',
                'slug' => 'cisco-ccna',
                'provider' => 'Cisco',
                'description' => 'The CCNA certification validates your ability to install, configure, operate, and troubleshoot medium-size routed and switched networks. This includes implementation and verification of connections to remote sites in a WAN, basic security threats mitigation, and understanding of wireless networking concepts.',
                'exam_question_count' => 120,
                'exam_duration_minutes' => 120,
                'passing_score' => 83,
                'price_single_cert' => 300.00,
                'is_active' => true,
            ],

            // Project Management & Business
            [
                'name' => 'Project Management Professional (PMP)',
                'slug' => 'pmp',
                'provider' => 'PMI',
                'description' => 'The Project Management Professional (PMP) certification is the most important industry-recognized certification for project managers. The PMP demonstrates that you have the experience, education and competency to lead and direct projects. It is recognized and demanded by organizations worldwide.',
                'exam_question_count' => 180,
                'exam_duration_minutes' => 230,
                'passing_score' => 70,
                'price_single_cert' => 555.00,
                'is_active' => true,
            ],
            [
                'name' => 'Certified ScrumMaster (CSM)',
                'slug' => 'certified-scrummaster-csm',
                'provider' => 'Scrum Alliance',
                'description' => 'The Certified ScrumMaster certification validates your knowledge of Scrum practices and principles and your ability to apply them in real-world situations. As a CSM, you will be able to fill the role of ScrumMaster for your team, increasing the likelihood of your team\'s overall success.',
                'exam_question_count' => 50,
                'exam_duration_minutes' => 60,
                'passing_score' => 74,
                'price_single_cert' => 1495.00,
                'is_active' => true,
            ],
            [
                'name' => 'ITIL 4 Foundation',
                'slug' => 'itil-4-foundation',
                'provider' => 'AXELOS',
                'description' => 'ITIL 4 Foundation introduces candidates to the management of modern IT-enabled services, providing them with an understanding of the common language and key concepts, and shows them how they can improve their work and the work of their organization with ITIL 4 guidance.',
                'exam_question_count' => 40,
                'exam_duration_minutes' => 60,
                'passing_score' => 65,
                'price_single_cert' => 350.00,
                'is_active' => true,
            ],

            // Development & Data
            [
                'name' => 'Oracle Certified Professional: Java SE Programmer',
                'slug' => 'oracle-java-se-programmer',
                'provider' => 'Oracle',
                'description' => 'The Oracle Certified Professional: Java SE Programmer certification validates your expertise in Java programming and demonstrates that you have the skills required to be a professional Java developer. This certification covers core Java concepts, object-oriented programming, exception handling, and more.',
                'exam_question_count' => 65,
                'exam_duration_minutes' => 180,
                'passing_score' => 65,
                'price_single_cert' => 245.00,
                'is_active' => true,
            ],
            [
                'name' => 'Microsoft Certified: Azure Data Fundamentals (DP-900)',
                'slug' => 'microsoft-azure-data-fundamentals-dp-900',
                'provider' => 'Microsoft',
                'description' => 'The Azure Data Fundamentals certification demonstrates foundational knowledge of core data concepts and how they are implemented using Microsoft Azure data services. Candidates should be familiar with the concepts of relational and non-relational data, and different types of data workloads such as transactional or analytical.',
                'exam_question_count' => 50,
                'exam_duration_minutes' => 60,
                'passing_score' => 70,
                'price_single_cert' => 99.00,
                'is_active' => true,
            ],
        ];

        foreach ($certifications as $certification) {
            Certification::create($certification);
        }

        $this->command->info('✓ Created ' . count($certifications) . ' certifications successfully!');
    }
}
