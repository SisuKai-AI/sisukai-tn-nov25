<?php

namespace Database\Seeders\Questions;

class MicrosoftAzureFundamentalsAZ900QuestionSeeder extends BaseQuestionSeeder
{
    protected function getCertificationSlug(): string
    {
        return 'microsoft-azure-fundamentals-az-900';
    }

    protected function getQuestionsData(): array
    {
        return [
            // Domain 1: Cloud Concepts
            'Cloud Computing Fundamentals' => [
                $this->q(
                    'What is cloud computing?',
                    [
                        $this->correct('The delivery of computing services over the internet'),
                        $this->wrong('A physical server in your data center'),
                        $this->wrong('A type of network cable'),
                        $this->wrong('A software development methodology'),
                    ],
                    'Cloud computing is the delivery of computing services—including servers, storage, databases, networking, software, analytics, and intelligence—over the Internet ("the cloud").',
                    'easy', 'approved'),
                $this->q(
                    'Which cloud deployment model uses both on-premises infrastructure and cloud services?',
                    [
                        $this->correct('Hybrid cloud'),
                        $this->wrong('Public cloud'),
                        $this->wrong('Private cloud'),
                        $this->wrong('Community cloud'),
                    ],
                    'A hybrid cloud combines public cloud and on-premises infrastructure, allowing data and applications to be shared between them.',
                    'easy', 'approved'),
                $this->q(
                    'What does CapEx stand for in cloud computing?',
                    [
                        $this->correct('Capital Expenditure'),
                        $this->wrong('Capacity Expansion'),
                        $this->wrong('Capital Exchange'),
                        $this->wrong('Capacity Expenditure'),
                    ],
                    'CapEx (Capital Expenditure) refers to upfront spending on physical infrastructure. Cloud computing shifts this to OpEx (Operational Expenditure) with pay-as-you-go pricing.',
                    'easy', 'approved'),
            ],

            'Benefits of Cloud Services' => [
                $this->q(
                    'Which cloud benefit allows you to quickly increase or decrease resources as needed?',
                    [
                        $this->correct('Elasticity'),
                        $this->wrong('Reliability'),
                        $this->wrong('Predictability'),
                        $this->wrong('Security'),
                    ],
                    'Elasticity is the ability to quickly expand or decrease computer processing, memory, and storage resources to meet changing demands without worrying about capacity planning.',
                    'easy', 'approved'),
                $this->q(
                    'What is the benefit of economies of scale in cloud computing?',
                    [
                        $this->correct('Lower costs due to cloud providers purchasing in bulk'),
                        $this->wrong('Faster internet speeds'),
                        $this->wrong('Better security'),
                        $this->wrong('More storage capacity'),
                    ],
                    'Cloud providers can achieve lower costs through economies of scale by purchasing hardware and services in bulk, and these savings are passed on to customers.',
                    'medium', 'approved'),
                $this->q(
                    'Which cloud characteristic ensures services remain available even during failures?',
                    [
                        $this->correct('Reliability'),
                        $this->wrong('Scalability'),
                        $this->wrong('Agility'),
                        $this->wrong('Geo-distribution'),
                    ],
                    'Reliability ensures that cloud services remain available even when failures occur, through redundancy and failover mechanisms.',
                    'easy', 'approved'),
            ],

            'Infrastructure as a Service (IaaS)' => [
                $this->q(
                    'Which cloud service model provides the most control over the operating system?',
                    [
                        $this->correct('Infrastructure as a Service (IaaS)'),
                        $this->wrong('Platform as a Service (PaaS)'),
                        $this->wrong('Software as a Service (SaaS)'),
                        $this->wrong('Function as a Service (FaaS)'),
                    ],
                    'IaaS provides the most control, allowing you to manage the operating system, middleware, and applications while the cloud provider manages the physical infrastructure.',
                    'medium', 'approved'),
                $this->q(
                    'Which service model is Microsoft Office 365 an example of?',
                    [
                        $this->correct('Software as a Service (SaaS)'),
                        $this->wrong('Platform as a Service (PaaS)'),
                        $this->wrong('Infrastructure as a Service (IaaS)'),
                        $this->wrong('Desktop as a Service (DaaS)'),
                    ],
                    'Office 365 is a SaaS offering where Microsoft manages everything and you simply use the software through a web browser or app.',
                    'easy', 'approved'),
                $this->q(
                    'In which service model does the cloud provider manage the runtime, middleware, and operating system?',
                    [
                        $this->correct('Platform as a Service (PaaS)'),
                        $this->wrong('Infrastructure as a Service (IaaS)'),
                        $this->wrong('Software as a Service (SaaS)'),
                        $this->wrong('Container as a Service (CaaS)'),
                    ],
                    'In PaaS, the cloud provider manages the infrastructure, operating system, middleware, and runtime, while you focus on deploying and managing your applications.',
                    'medium', 'approved'),
            ],

            'Platform as a Service (PaaS)' => [
                $this->q(
                    'What is an Azure region?',
                    [
                        $this->correct('A geographical area containing one or more datacenters'),
                        $this->wrong('A single datacenter'),
                        $this->wrong('A virtual network'),
                        $this->wrong('A resource group'),
                    ],
                    'An Azure region is a set of datacenters deployed within a latency-defined perimeter and connected through a dedicated regional low-latency network.',
                    'easy', 'approved'),
                $this->q(
                    'What is the purpose of Availability Zones?',
                    [
                        $this->correct('To provide high availability by protecting against datacenter failures'),
                        $this->wrong('To reduce costs'),
                        $this->wrong('To improve network speed'),
                        $this->wrong('To simplify management'),
                    ],
                    'Availability Zones are physically separate locations within an Azure region, each with independent power, cooling, and networking to protect against datacenter failures.',
                    'medium', 'approved'),
                $this->q(
                    'How many Availability Zones does each Azure region that supports them have?',
                    [
                        $this->correct('A minimum of 3'),
                        $this->wrong('Exactly 2'),
                        $this->wrong('At least 5'),
                        $this->wrong('It varies by region'),
                    ],
                    'Each Azure region that supports Availability Zones has a minimum of three separate zones to ensure resiliency.',
                    'easy', 'approved'),
            ],
        ];
    }
}

