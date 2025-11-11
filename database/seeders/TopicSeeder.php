<?php

namespace Database\Seeders;

use App\Models\Domain;
use App\Models\Topic;
use Illuminate\Database\Seeder;

class TopicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Seeding topics...');

        $topicsByDomain = $this->getTopicsByDomain();
        
        $totalTopics = 0;

        foreach ($topicsByDomain as $certificationSlug => $domains) {
            foreach ($domains as $domainName => $topics) {
                $domain = Domain::whereHas('certification', function ($query) use ($certificationSlug) {
                    $query->where('slug', $certificationSlug);
                })->where('name', $domainName)->first();

                if (!$domain) {
                    $this->command->warn("Domain not found: {$domainName} for certification {$certificationSlug}");
                    continue;
                }

                foreach ($topics as $index => $topicName) {
                    Topic::create([
                        'domain_id' => $domain->id,
                        'name' => $topicName,
                        'order' => $index + 1,
                    ]);
                    $totalTopics++;
                }
            }
        }

        $this->command->info("✓ Created {$totalTopics} topics");
    }

    /**
     * Get topics organized by certification and domain
     */
    private function getTopicsByDomain(): array
    {
        return [
            'aws-certified-cloud-practitioner' => [
                'Cloud Concepts' => [
                    'Define the AWS Cloud and Value Proposition',
                    'Cloud Computing Models',
                    'Cloud Deployment Models',
                    'AWS Well-Architected Framework',
                    'Total Cost of Ownership (TCO)',
                ],
                'Security and Compliance' => [
                    'AWS Shared Responsibility Model',
                    'AWS Identity and Access Management (IAM)',
                    'Security Groups and Network ACLs',
                    'Data Encryption and Key Management',
                    'Compliance and Governance',
                ],
                'Cloud Technology and Services' => [
                    'Compute Services',
                    'Storage Services',
                    'Database Services',
                    'Networking and Content Delivery',
                    'Management and Monitoring',
                ],
                'Billing, Pricing, and Support' => [
                    'AWS Pricing Models',
                    'Billing and Cost Management Tools',
                    'AWS Support Plans',
                    'AWS Marketplace and Partner Network',
                ],
            ],

            'aws-certified-solutions-architect-associate' => [
                'Design Resilient Architectures' => [
                    'High Availability Architecture',
                    'Disaster Recovery Strategies',
                    'Decoupling Mechanisms',
                    'Scalability and Elasticity',
                ],
                'Design High-Performing Architectures' => [
                    'Compute Solutions',
                    'Storage Solutions',
                    'Database Solutions',
                    'Network Design',
                ],
                'Design Secure Applications and Architectures' => [
                    'Identity and Access Management',
                    'Data Encryption',
                    'Network Security',
                ],
                'Design Cost-Optimized Architectures' => [
                    'Cost-Effective Storage',
                    'Cost-Effective Compute',
                ],
            ],

            'microsoft-azure-fundamentals-az-900' => [
                'Cloud Concepts' => [
                    'Cloud Computing Fundamentals',
                    'Benefits of Cloud Services',
                ],
                'Azure Architecture and Services' => [
                    'Infrastructure as a Service (IaaS)',
                    'Platform as a Service (PaaS)',
                ],
            ],

            'google-cloud-digital-leader' => [
                'Digital Transformation with Google Cloud' => [
                    'Cloud Transformation Benefits',
                    'Infrastructure Modernization',
                    'Data-Driven Innovation',
                    'Collaboration and Productivity',
                ],
                'Google Cloud Products and Services' => [
                    'Compute Services',
                    'Storage Services',
                    'Database Services',
                    'Networking Services',
                ],
                'Security and Compliance' => [
                    'Identity and Access Management',
                    'Data Security',
                    'Compliance',
                ],
                'Pricing and Billing' => [
                    'Cloud Pricing Models',
                    'Cost Optimization',
                ],
            ],

            'comptia-security-plus' => [
                'Threats, Attacks and Vulnerabilities' => [
                    'Social Engineering',
                    'Malware Types',
                    'Attack Types',
                    'Vulnerability Assessment',
                ],
                'Architecture and Design' => [
                    'Security Frameworks',
                    'Network Security Design',
                    'Cryptography Concepts',
                    'Access Control',
                ],
                'Implementation' => [
                    'Security Technologies',
                    'Secure Protocols',
                ],
                'Operations and Incident Response' => [
                    'Incident Response',
                    'Security Monitoring',
                ],
                'Governance, Risk, and Compliance' => [
                    'Security Policies',
                    'Risk Management',
                ],
            ],

            'certified-kubernetes-administrator-cka' => [
                'Cluster Architecture, Installation & Configuration' => [
                    'Kubernetes Architecture',
                    'Cluster Installation',
                    'RBAC and Security',
                    'Networking Fundamentals',
                ],
                'Workloads & Scheduling' => [
                    'Pods and Deployments',
                    'ConfigMaps and Secrets',
                    'Resource Management',
                    'Scheduling',
                ],
                'Services & Networking' => [
                    'Ingress',
                    'Network Policies',
                    'DNS and Service Discovery',
                ],
                'Storage' => [
                    'Persistent Volumes',
                    'Storage Classes',
                ],
                'Troubleshooting' => [
                    'Debugging',
                    'Cluster Troubleshooting',
                ],
            ],

            'comptia-a-plus' => [
                'Hardware' => [
                    'Hardware',
                ],
                'Networking' => [
                    'Networking',
                ],
                'Mobile Devices' => [
                    'Mobile Devices',
                ],
                'Virtualization and Cloud Computing' => [
                    'Virtualization and Cloud',
                ],
                'Hardware and Network Troubleshooting' => [
                    'Hardware and Network Troubleshooting',
                ],
            ],

            'comptia-network-plus' => [
                'Networking Fundamentals' => [
                    'Networking Concepts',
                ],
                'Network Implementations' => [
                    'Network Infrastructure',
                ],
                'Network Operations' => [
                    'Network Operations',
                ],
                'Network Security' => [
                    'Network Security',
                ],
                'Network Troubleshooting' => [
                    'Network Troubleshooting',
                ],
            ],

            'cisco-ccna' => [
                'Network Fundamentals' => [
                    'Network Fundamentals',
                ],
                'Network Access' => [
                    'Network Access',
                ],
                'IP Connectivity' => [
                    'IP Connectivity',
                ],
                'IP Services' => [
                    'IP Services',
                ],
                'Security Fundamentals' => [
                    'Security Fundamentals',
                ],
                'Automation and Programmability' => [
                    'Automation and Programmability',
                ],
            ],

            'comptia-cysa-plus' => [
                'Threat and Vulnerability Management' => [
                    'Threat and Vulnerability Management',
                ],
                'Software and Systems Security' => [
                    'Software and Systems Security',
                ],
                'Security Operations and Monitoring' => [
                    'Security Operations and Monitoring',
                ],
                'Incident Response' => [
                    'Incident Response',
                ],
                'Compliance and Assessment' => [
                    'Compliance and Assessment',
                ],
            ],

            'giac-security-essentials-gsec' => [
                'Access Controls and Password Management' => [
                    'Access Control and Password Management',
                ],
                'Cryptography' => [
                    'Cryptography',
                ],
                'Network Security' => [
                    'Network Security',
                ],
                'Incident Handling and Response' => [
                    'Incident Handling',
                ],
                'Defensive Security Operations' => [
                    'Defensive Security Operations',
                ],
            ],

            'certified-ethical-hacker-ceh' => [
                'Introduction to Ethical Hacking' => [
                    'Introduction to Ethical Hacking',
                ],
                'Footprinting and Reconnaissance' => [
                    'Footprinting and Reconnaissance',
                ],
                'Scanning and Enumeration' => [
                    'Scanning and Enumeration',
                ],
                'System Hacking' => [
                    'System Hacking',
                ],
                'Malware Threats' => [
                    'Malware and Social Engineering',
                ],
                'Web Application Security' => [
                    'Web Application Hacking',
                ],
                'Wireless Network Security' => [
                    'Wireless Network Hacking',
                ],
            ],

            'cissp' => [
                'Security and Risk Management' => [
                    'Security Governance Principles',
                    'Compliance and Legal Requirements',
                    'Professional Ethics',
                    'Risk Management Concepts',
                    'Business Continuity Planning',
                ],
                'Asset Security' => [
                    'Information and Asset Classification',
                    'Ownership and Accountability',
                    'Privacy Protection',
                    'Data Retention and Disposal',
                    'Data Security Controls',
                ],
                'Security Architecture and Engineering' => [
                    'Secure Design Principles',
                    'Security Models',
                    'Security Evaluation Models',
                    'Cryptographic Systems',
                    'Physical Security',
                ],
                'Communication and Network Security' => [
                    'Network Architecture',
                    'Secure Network Components',
                    'Secure Communication Channels',
                    'Network Attacks',
                    'Wireless Security',
                ],
                'Identity and Access Management (IAM)' => [
                    'Physical Access Control',
                    'Logical Access Control',
                    'Identity Management',
                    'Access Control Models',
                    'Single Sign-On and Federation',
                ],
                'Security Assessment and Testing' => [
                    'Assessment and Testing Strategies',
                    'Security Control Testing',
                    'Security Audits',
                    'Vulnerability Assessment Tools',
                    'Test Output Analysis',
                ],
                'Security Operations' => [
                    'Investigations',
                    'Logging and Monitoring',
                    'Resource Provisioning',
                    'Foundational Security Operations',
                    'Incident Management',
                ],
                'Software Development Security' => [
                    'Secure SDLC',
                    'Development Environments',
                    'Software Security Effectiveness',
                    'Acquired Software Security',
                    'Database Security',
                ],
            ],

            'microsoft-azure-data-fundamentals-dp-900' => [
                'Core Data Concepts' => [
                    'Core Data Concepts',
                ],
                'Relational Data in Azure' => [
                    'Relational Data in Azure',
                ],
                'Non-Relational Data in Azure' => [
                    'Non-Relational Data in Azure',
                ],
                'Analytics Workloads in Azure' => [
                    'Analytics Workloads in Azure',
                ],
            ],

            'oracle-java-se-programmer' => [
                'Java Fundamentals' => [
                    'Java Basics',
                ],
                'Object-Oriented Programming' => [
                    'Object-Oriented Programming',
                ],
                'Working with Java APIs' => [
                    'Collections Framework',
                ],
                'Exception Handling and Concurrency' => [
                    'Exception Handling',
                    'Concurrency',
                ],
            ],

            'pmp' => [
                'People' => [
                    'Stakeholder Management',
                ],
                'Process' => [
                    'Project Management Fundamentals',
                    'Scope Management',
                    'Schedule Management',
                    'Cost Management',
                    'Quality Management',
                    'Risk Management',
                ],
                'Business Environment' => [
                    'Agile and Hybrid Approaches',
                ],
            ],

            'certified-scrummaster-csm' => [
                'Scrum Framework and Theory' => [
                    'Scrum Framework',
                    'Scrum Roles',
                    'Scrum Events',
                    'Scrum Artifacts',
                ],
                'Scrum Master Role' => [
                    'Scrum Master Responsibilities',
                ],
            ],

            'itil-4-foundation' => [
                'Key Concepts of Service Management' => [
                    'Key Concepts of Service Management',
                ],
                'The ITIL Service Value System' => [
                    'The Service Value System',
                    'The Seven Guiding Principles',
                    'Service Value Chain',
                ],
                'ITIL Management Practices' => [
                    'ITIL Practices',
                    'Additional ITIL Practices',
                ],
            ],
        ];
    }
}
