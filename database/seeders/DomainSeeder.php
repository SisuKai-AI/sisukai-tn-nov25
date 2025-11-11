<?php

namespace Database\Seeders;

use App\Models\Certification;
use App\Models\Domain;
use Illuminate\Database\Seeder;

class DomainSeeder extends Seeder
{
    public function run(): void
    {
        $domains = $this->getDomainsData();

        foreach ($domains as $certSlug => $certDomains) {
            $certification = Certification::where('slug', $certSlug)->first();
            
            if (!$certification) {
                $this->command->warn("Certification not found: {$certSlug}");
                continue;
            }

            foreach ($certDomains as $index => $domainData) {
                Domain::updateOrCreate(
                    [
                        'certification_id' => $certification->id,
                        'name' => $domainData['name'],
                    ],
                    [
                        'description' => $domainData['description'],
                        'order' => $index + 1,
                    ]
                );
            }
        }

        $this->command->info('Domains seeded successfully.');
    }

    private function getDomainsData(): array
    {
        return [
            'aws-certified-cloud-practitioner' => [
                ['name' => 'Cloud Concepts', 'description' => 'Knowledge domain covering cloud concepts concepts and practices'],
                ['name' => 'Security and Compliance', 'description' => 'Knowledge domain covering security and compliance concepts and practices'],
                ['name' => 'Cloud Technology and Services', 'description' => 'Knowledge domain covering cloud technology and services concepts and practices'],
                ['name' => 'Billing, Pricing, and Support', 'description' => 'Knowledge domain covering billing, pricing, and support concepts and practices'],
            ],

            'aws-certified-solutions-architect-associate' => [
                ['name' => 'Design Resilient Architectures', 'description' => 'Knowledge domain covering design resilient architectures concepts and practices'],
                ['name' => 'Design High-Performing Architectures', 'description' => 'Knowledge domain covering design high-performing architectures concepts and practices'],
                ['name' => 'Design Secure Applications and Architectures', 'description' => 'Knowledge domain covering design secure applications and architectures concepts and practices'],
                ['name' => 'Design Cost-Optimized Architectures', 'description' => 'Knowledge domain covering design cost-optimized architectures concepts and practices'],
            ],

            'certified-ethical-hacker-ceh' => [
                ['name' => 'Introduction to Ethical Hacking', 'description' => 'Knowledge domain covering introduction to ethical hacking concepts and practices'],
                ['name' => 'Footprinting and Reconnaissance', 'description' => 'Knowledge domain covering footprinting and reconnaissance concepts and practices'],
                ['name' => 'Scanning and Enumeration', 'description' => 'Knowledge domain covering scanning and enumeration concepts and practices'],
                ['name' => 'System Hacking', 'description' => 'Knowledge domain covering system hacking concepts and practices'],
                ['name' => 'Malware Threats', 'description' => 'Knowledge domain covering malware threats concepts and practices'],
                ['name' => 'Web Application Security', 'description' => 'Knowledge domain covering web application security concepts and practices'],
                ['name' => 'Wireless Network Security', 'description' => 'Knowledge domain covering wireless network security concepts and practices'],
            ],

            'certified-kubernetes-administrator-cka' => [
                ['name' => 'Cluster Architecture, Installation & Configuration', 'description' => 'Knowledge domain covering cluster architecture, installation & configuration concepts and practices'],
                ['name' => 'Workloads & Scheduling', 'description' => 'Knowledge domain covering workloads & scheduling concepts and practices'],
                ['name' => 'Services & Networking', 'description' => 'Knowledge domain covering services & networking concepts and practices'],
                ['name' => 'Storage', 'description' => 'Knowledge domain covering storage concepts and practices'],
                ['name' => 'Troubleshooting', 'description' => 'Knowledge domain covering troubleshooting concepts and practices'],
            ],

            'certified-scrummaster-csm' => [
                ['name' => 'Scrum Framework and Theory', 'description' => 'Knowledge domain covering scrum framework and theory concepts and practices'],
                ['name' => 'Scrum Master Role', 'description' => 'Knowledge domain covering scrum master role concepts and practices'],
            ],

            'cisco-ccna' => [
                ['name' => 'Network Fundamentals', 'description' => 'Knowledge domain covering network fundamentals concepts and practices'],
                ['name' => 'Network Access', 'description' => 'Knowledge domain covering network access concepts and practices'],
                ['name' => 'IP Connectivity', 'description' => 'Knowledge domain covering ip connectivity concepts and practices'],
                ['name' => 'IP Services', 'description' => 'Knowledge domain covering ip services concepts and practices'],
                ['name' => 'Security Fundamentals', 'description' => 'Knowledge domain covering security fundamentals concepts and practices'],
                ['name' => 'Automation and Programmability', 'description' => 'Knowledge domain covering automation and programmability concepts and practices'],
            ],

            'cissp' => [
                ['name' => 'Security and Risk Management', 'description' => 'Knowledge domain covering security and risk management concepts and practices'],
                ['name' => 'Asset Security', 'description' => 'Knowledge domain covering asset security concepts and practices'],
                ['name' => 'Security Architecture and Engineering', 'description' => 'Knowledge domain covering security architecture and engineering concepts and practices'],
                ['name' => 'Communication and Network Security', 'description' => 'Knowledge domain covering communication and network security concepts and practices'],
                ['name' => 'Identity and Access Management (IAM)', 'description' => 'Knowledge domain covering identity and access management (iam) concepts and practices'],
                ['name' => 'Security Assessment and Testing', 'description' => 'Knowledge domain covering security assessment and testing concepts and practices'],
                ['name' => 'Security Operations', 'description' => 'Knowledge domain covering security operations concepts and practices'],
                ['name' => 'Software Development Security', 'description' => 'Knowledge domain covering software development security concepts and practices'],
            ],

            'comptia-a-plus' => [
                ['name' => 'Hardware', 'description' => 'Knowledge domain covering hardware concepts and practices'],
                ['name' => 'Networking', 'description' => 'Knowledge domain covering networking concepts and practices'],
                ['name' => 'Mobile Devices', 'description' => 'Knowledge domain covering mobile devices concepts and practices'],
                ['name' => 'Virtualization and Cloud Computing', 'description' => 'Knowledge domain covering virtualization and cloud computing concepts and practices'],
                ['name' => 'Hardware and Network Troubleshooting', 'description' => 'Knowledge domain covering hardware and network troubleshooting concepts and practices'],
            ],

            'comptia-cysa-plus' => [
                ['name' => 'Threat and Vulnerability Management', 'description' => 'Knowledge domain covering threat and vulnerability management concepts and practices'],
                ['name' => 'Software and Systems Security', 'description' => 'Knowledge domain covering software and systems security concepts and practices'],
                ['name' => 'Security Operations and Monitoring', 'description' => 'Knowledge domain covering security operations and monitoring concepts and practices'],
                ['name' => 'Incident Response', 'description' => 'Knowledge domain covering incident response concepts and practices'],
                ['name' => 'Compliance and Assessment', 'description' => 'Knowledge domain covering compliance and assessment concepts and practices'],
            ],

            'comptia-network-plus' => [
                ['name' => 'Networking Fundamentals', 'description' => 'Knowledge domain covering networking fundamentals concepts and practices'],
                ['name' => 'Network Implementations', 'description' => 'Knowledge domain covering network implementations concepts and practices'],
                ['name' => 'Network Operations', 'description' => 'Knowledge domain covering network operations concepts and practices'],
                ['name' => 'Network Security', 'description' => 'Knowledge domain covering network security concepts and practices'],
                ['name' => 'Network Troubleshooting', 'description' => 'Knowledge domain covering network troubleshooting concepts and practices'],
            ],

            'comptia-security-plus' => [
                ['name' => 'Threats, Attacks and Vulnerabilities', 'description' => 'Knowledge domain covering threats, attacks and vulnerabilities concepts and practices'],
                ['name' => 'Architecture and Design', 'description' => 'Knowledge domain covering architecture and design concepts and practices'],
                ['name' => 'Implementation', 'description' => 'Knowledge domain covering implementation concepts and practices'],
                ['name' => 'Operations and Incident Response', 'description' => 'Knowledge domain covering operations and incident response concepts and practices'],
                ['name' => 'Governance, Risk, and Compliance', 'description' => 'Knowledge domain covering governance, risk, and compliance concepts and practices'],
            ],

            'giac-security-essentials-gsec' => [
                ['name' => 'Access Controls and Password Management', 'description' => 'Knowledge domain covering access controls and password management concepts and practices'],
                ['name' => 'Cryptography', 'description' => 'Knowledge domain covering cryptography concepts and practices'],
                ['name' => 'Network Security', 'description' => 'Knowledge domain covering network security concepts and practices'],
                ['name' => 'Incident Handling and Response', 'description' => 'Knowledge domain covering incident handling and response concepts and practices'],
                ['name' => 'Defensive Security Operations', 'description' => 'Knowledge domain covering defensive security operations concepts and practices'],
            ],

            'google-cloud-digital-leader' => [
                ['name' => 'Digital Transformation with Google Cloud', 'description' => 'Knowledge domain covering digital transformation with google cloud concepts and practices'],
                ['name' => 'Google Cloud Products and Services', 'description' => 'Knowledge domain covering google cloud products and services concepts and practices'],
                ['name' => 'Security and Compliance', 'description' => 'Knowledge domain covering security and compliance concepts and practices'],
                ['name' => 'Pricing and Billing', 'description' => 'Knowledge domain covering pricing and billing concepts and practices'],
            ],

            'itil-4-foundation' => [
                ['name' => 'Key Concepts of Service Management', 'description' => 'Knowledge domain covering key concepts of service management concepts and practices'],
                ['name' => 'The ITIL Service Value System', 'description' => 'Knowledge domain covering the itil service value system concepts and practices'],
                ['name' => 'ITIL Management Practices', 'description' => 'Knowledge domain covering itil management practices concepts and practices'],
            ],

            'microsoft-azure-data-fundamentals-dp-900' => [
                ['name' => 'Core Data Concepts', 'description' => 'Knowledge domain covering core data concepts concepts and practices'],
                ['name' => 'Relational Data in Azure', 'description' => 'Knowledge domain covering relational data in azure concepts and practices'],
                ['name' => 'Non-Relational Data in Azure', 'description' => 'Knowledge domain covering non-relational data in azure concepts and practices'],
                ['name' => 'Analytics Workloads in Azure', 'description' => 'Knowledge domain covering analytics workloads in azure concepts and practices'],
            ],

            'microsoft-azure-fundamentals-az-900' => [
                ['name' => 'Cloud Concepts', 'description' => 'Knowledge domain covering cloud concepts concepts and practices'],
                ['name' => 'Azure Architecture and Services', 'description' => 'Knowledge domain covering azure architecture and services concepts and practices'],
            ],

            'oracle-java-se-programmer' => [
                ['name' => 'Java Fundamentals', 'description' => 'Knowledge domain covering java fundamentals concepts and practices'],
                ['name' => 'Object-Oriented Programming', 'description' => 'Knowledge domain covering object-oriented programming concepts and practices'],
                ['name' => 'Working with Java APIs', 'description' => 'Knowledge domain covering working with java apis concepts and practices'],
                ['name' => 'Exception Handling and Concurrency', 'description' => 'Knowledge domain covering exception handling and concurrency concepts and practices'],
            ],

            'pmp' => [
                ['name' => 'People', 'description' => 'Knowledge domain covering people concepts and practices'],
                ['name' => 'Process', 'description' => 'Knowledge domain covering process concepts and practices'],
                ['name' => 'Business Environment', 'description' => 'Knowledge domain covering business environment concepts and practices'],
            ],

        ];
    }
}
