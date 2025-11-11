<?php

namespace Database\Seeders\Questions;

class AWSCertifiedSolutionsArchitectAssociateQuestionSeeder extends BaseQuestionSeeder
{
    protected function getCertificationSlug(): string
    {
        return 'aws-certified-solutions-architect-associate';
    }

    protected function getQuestionsData(): array
    {
        return [
            // Domain 1: Design Resilient Architectures
            'High Availability Architecture' => [
                $this->q(
                    'A company needs to ensure their application remains available even if an entire Availability Zone fails. Which approach should they use?',
                    [
                        $this->correct('Deploy the application across multiple Availability Zones using an Application Load Balancer'),
                        $this->wrong('Deploy the application in a single Availability Zone with multiple EC2 instances'),
                        $this->wrong('Use Amazon Route 53 health checks with a single EC2 instance'),
                        $this->wrong('Deploy the application in multiple regions without load balancing'),
                    ],
                    'High availability is achieved by distributing resources across multiple Availability Zones. An Application Load Balancer automatically distributes traffic across healthy targets in multiple AZs.',
                    'medium', 'approved'),
                $this->q(
                    'What is the minimum number of Availability Zones recommended for a highly available architecture?',
                    [
                        $this->correct('2'),
                        $this->wrong('1'),
                        $this->wrong('3'),
                        $this->wrong('4'),
                    ],
                    'AWS recommends using at least 2 Availability Zones for high availability. This protects against AZ-level failures while balancing cost and complexity.',
                    'easy', 'approved'),
                $this->q(
                    'Which AWS service automatically distributes incoming application traffic across multiple targets in multiple Availability Zones?',
                    [
                        $this->correct('Elastic Load Balancing'),
                        $this->wrong('Amazon CloudFront'),
                        $this->wrong('AWS Direct Connect'),
                        $this->wrong('Amazon Route 53'),
                    ],
                    'Elastic Load Balancing (ELB) automatically distributes incoming traffic across multiple targets (EC2 instances, containers, IP addresses) in one or more Availability Zones.',
                    'easy', 'approved'),
            ],

            'Disaster Recovery Strategies' => [
                $this->q(
                    'Which disaster recovery strategy has the lowest RTO (Recovery Time Objective) and RPO (Recovery Point Objective)?',
                    [
                        $this->correct('Multi-site active-active'),
                        $this->wrong('Pilot light'),
                        $this->wrong('Warm standby'),
                        $this->wrong('Backup and restore'),
                    ],
                    'Multi-site active-active has near-zero RTO and RPO because the workload is running simultaneously in multiple locations. Traffic can be immediately redirected if one site fails.',
                    'medium', 'approved'),
                $this->q(
                    'A company wants to minimize costs while maintaining the ability to recover from disasters within 24 hours. Which strategy should they choose?',
                    [
                        $this->correct('Backup and restore'),
                        $this->wrong('Multi-site active-active'),
                        $this->wrong('Warm standby'),
                        $this->wrong('Pilot light'),
                    ],
                    'Backup and restore is the most cost-effective DR strategy, suitable when you can tolerate longer recovery times (hours to days). Data is backed up regularly and restored when needed.',
                    'medium', 'approved'),
                $this->q(
                    'What is the pilot light disaster recovery strategy?',
                    [
                        $this->correct('A minimal version of the environment is always running in the cloud, ready to be scaled up during a disaster'),
                        $this->wrong('A complete duplicate environment runs continuously in parallel'),
                        $this->wrong('All data is backed up to S3 and restored when needed'),
                        $this->wrong('The environment is completely shut down and recreated from scratch during recovery'),
                    ],
                    'Pilot light maintains a minimal version of core infrastructure (like databases) running continuously. During a disaster, you quickly provision additional resources around this core.',
                    'medium', 'approved'),
            ],

            'Decoupling Mechanisms' => [
                $this->q(
                    'Which AWS service should be used to decouple components of a microservices architecture?',
                    [
                        $this->correct('Amazon SQS'),
                        $this->wrong('Amazon EC2 Auto Scaling'),
                        $this->wrong('AWS Lambda'),
                        $this->wrong('Amazon RDS'),
                    ],
                    'Amazon Simple Queue Service (SQS) is a fully managed message queuing service that enables you to decouple and scale microservices, distributed systems, and serverless applications.',
                    'easy', 'approved'),
                $this->q(
                    'A company needs to send notifications to multiple subscribers when events occur. Which AWS service is most appropriate?',
                    [
                        $this->correct('Amazon SNS'),
                        $this->wrong('Amazon SQS'),
                        $this->wrong('Amazon EventBridge'),
                        $this->wrong('AWS Step Functions'),
                    ],
                    'Amazon Simple Notification Service (SNS) is a pub/sub messaging service that enables you to send messages to multiple subscribers (email, SMS, HTTP endpoints, SQS queues, Lambda functions).',
                    'easy', 'approved'),
                $this->q(
                    'What is the benefit of using Amazon SQS between application components?',
                    [
                        $this->correct('It allows components to operate independently and handle failures gracefully'),
                        $this->wrong('It increases the speed of data processing'),
                        $this->wrong('It reduces the cost of running EC2 instances'),
                        $this->wrong('It automatically scales EC2 instances'),
                    ],
                    'SQS decouples components so they can operate independently. If one component fails or slows down, messages queue up and are processed when the component recovers, preventing cascading failures.',
                    'medium', 'approved'),
            ],

            'Scalability and Elasticity' => [
                $this->q(
                    'Which type of scaling adds more instances of the same size to handle increased load?',
                    [
                        $this->correct('Horizontal scaling'),
                        $this->wrong('Vertical scaling'),
                        $this->wrong('Diagonal scaling'),
                        $this->wrong('Elastic scaling'),
                    ],
                    'Horizontal scaling (scaling out) adds more instances of the same size. This is the preferred approach in AWS as it provides better fault tolerance and is more cost-effective.',
                    'easy', 'approved'),
                $this->q(
                    'A web application experiences predictable traffic spikes every Monday at 9 AM. Which Auto Scaling feature should be used?',
                    [
                        $this->correct('Scheduled scaling'),
                        $this->wrong('Target tracking scaling'),
                        $this->wrong('Step scaling'),
                        $this->wrong('Simple scaling'),
                    ],
                    'Scheduled scaling allows you to scale your application in response to predictable load changes by setting up scaling actions to occur at specific times.',
                    'medium', 'approved'),
                $this->q(
                    'What is the difference between scalability and elasticity?',
                    [
                        $this->correct('Scalability is the ability to handle growth; elasticity is the ability to scale up and down automatically based on demand'),
                        $this->wrong('Scalability is automatic; elasticity is manual'),
                        $this->wrong('Scalability is for compute; elasticity is for storage'),
                        $this->wrong('They are the same thing'),
                    ],
                    'Scalability is the capability to handle increased load by adding resources. Elasticity goes further by automatically scaling resources up or down based on current demand, optimizing costs.',
                    'medium', 'approved'),
            ],

            // Domain 2: Design High-Performing Architectures
            'Compute Solutions' => [
                $this->q(
                    'Which EC2 instance type is best suited for high-performance databases and in-memory caching?',
                    [
                        $this->correct('Memory optimized (R, X, z instances)'),
                        $this->wrong('Compute optimized (C instances)'),
                        $this->wrong('General purpose (T, M instances)'),
                        $this->wrong('Storage optimized (I, D instances)'),
                    ],
                    'Memory optimized instances are designed for memory-intensive applications like high-performance databases, in-memory caches, and real-time big data analytics.',
                    'easy', 'approved'),
                $this->q(
                    'A company needs to run batch processing jobs that can be interrupted. Which EC2 pricing model should they use?',
                    [
                        $this->correct('Spot Instances'),
                        $this->wrong('On-Demand Instances'),
                        $this->wrong('Reserved Instances'),
                        $this->wrong('Dedicated Hosts'),
                    ],
                    'Spot Instances offer up to 90% discount compared to On-Demand prices and are ideal for fault-tolerant, flexible workloads like batch processing that can handle interruptions.',
                    'medium', 'approved'),
                $this->q(
                    'Which AWS compute service automatically scales and manages the infrastructure for your code?',
                    [
                        $this->correct('AWS Lambda'),
                        $this->wrong('Amazon EC2'),
                        $this->wrong('Amazon ECS'),
                        $this->wrong('AWS Elastic Beanstalk'),
                    ],
                    'AWS Lambda is a serverless compute service that runs your code in response to events and automatically manages the compute resources, including scaling.',
                    'easy', 'approved'),
            ],

            'Storage Solutions' => [
                $this->q(
                    'Which S3 storage class is most cost-effective for data that is accessed infrequently but requires rapid access when needed?',
                    [
                        $this->correct('S3 Standard-Infrequent Access (S3 Standard-IA)'),
                        $this->wrong('S3 Standard'),
                        $this->wrong('S3 Glacier'),
                        $this->wrong('S3 One Zone-IA'),
                    ],
                    'S3 Standard-IA is designed for data that is accessed less frequently but requires rapid access when needed. It offers lower storage costs than S3 Standard with the same performance.',
                    'medium', 'approved'),
                $this->q(
                    'A company needs block storage for their EC2 instances that persists independently of the instance lifecycle. Which service should they use?',
                    [
                        $this->correct('Amazon EBS'),
                        $this->wrong('Amazon S3'),
                        $this->wrong('Amazon EFS'),
                        $this->wrong('Instance Store'),
                    ],
                    'Amazon Elastic Block Store (EBS) provides persistent block storage volumes for EC2 instances. The data persists independently of the instance lifecycle.',
                    'easy', 'approved'),
                $this->q(
                    'Which storage service provides a fully managed NFS file system that can be mounted on multiple EC2 instances simultaneously?',
                    [
                        $this->correct('Amazon EFS'),
                        $this->wrong('Amazon EBS'),
                        $this->wrong('Amazon S3'),
                        $this->wrong('AWS Storage Gateway'),
                    ],
                    'Amazon Elastic File System (EFS) provides a simple, scalable, elastic NFS file system that can be mounted on multiple EC2 instances across multiple Availability Zones simultaneously.',
                    'medium', 'approved'),
            ],

            'Database Solutions' => [
                $this->q(
                    'Which database service is best suited for OLTP (Online Transaction Processing) workloads?',
                    [
                        $this->correct('Amazon RDS'),
                        $this->wrong('Amazon Redshift'),
                        $this->wrong('Amazon EMR'),
                        $this->wrong('Amazon Athena'),
                    ],
                    'Amazon RDS is optimized for OLTP workloads, providing fast query processing and high transaction throughput for relational databases.',
                    'easy', 'approved'),
                $this->q(
                    'A company needs a NoSQL database with single-digit millisecond latency at any scale. Which service should they use?',
                    [
                        $this->correct('Amazon DynamoDB'),
                        $this->wrong('Amazon RDS'),
                        $this->wrong('Amazon Aurora'),
                        $this->wrong('Amazon DocumentDB'),
                    ],
                    'Amazon DynamoDB is a fully managed NoSQL database that provides fast and predictable performance with seamless scalability and single-digit millisecond latency.',
                    'easy', 'approved'),
                $this->q(
                    'Which AWS database service is best for data warehousing and analytics on petabyte-scale data?',
                    [
                        $this->correct('Amazon Redshift'),
                        $this->wrong('Amazon RDS'),
                        $this->wrong('Amazon DynamoDB'),
                        $this->wrong('Amazon ElastiCache'),
                    ],
                    'Amazon Redshift is a fast, fully managed data warehouse that makes it simple and cost-effective to analyze data using standard SQL and existing BI tools.',
                    'medium', 'approved'),
            ],

            'Network Design' => [
                $this->q(
                    'What is the maximum number of VPCs allowed per region by default?',
                    [
                        $this->correct('5'),
                        $this->wrong('10'),
                        $this->wrong('20'),
                        $this->wrong('Unlimited'),
                    ],
                    'The default limit is 5 VPCs per region, but this is a soft limit that can be increased by contacting AWS Support.',
                    'easy', 'approved'),
                $this->q(
                    'Which component controls inbound and outbound traffic at the subnet level?',
                    [
                        $this->correct('Network ACL'),
                        $this->wrong('Security Group'),
                        $this->wrong('Route Table'),
                        $this->wrong('Internet Gateway'),
                    ],
                    'Network Access Control Lists (NACLs) act as a firewall for controlling traffic in and out of subnets. They are stateless and evaluate rules in order.',
                    'medium', 'approved'),
                $this->q(
                    'A company wants to connect their on-premises data center to AWS with a dedicated private connection. Which service should they use?',
                    [
                        $this->correct('AWS Direct Connect'),
                        $this->wrong('AWS VPN'),
                        $this->wrong('Amazon VPC Peering'),
                        $this->wrong('AWS Transit Gateway'),
                    ],
                    'AWS Direct Connect provides a dedicated network connection from your premises to AWS, offering more consistent network performance than internet-based connections.',
                    'medium', 'approved'),
            ],

            // Domain 3: Design Secure Applications and Architectures
            'Identity and Access Management' => [
                $this->q(
                    'Which IAM entity should be used to grant permissions to an EC2 instance to access S3?',
                    [
                        $this->correct('IAM Role'),
                        $this->wrong('IAM User'),
                        $this->wrong('IAM Group'),
                        $this->wrong('IAM Policy'),
                    ],
                    'IAM Roles should be used for EC2 instances to access AWS services. Roles provide temporary credentials and are more secure than embedding access keys in the instance.',
                    'easy', 'approved'),
                $this->q(
                    'What is the AWS best practice for the root account?',
                    [
                        $this->correct('Enable MFA and do not use it for everyday tasks'),
                        $this->wrong('Use it for all administrative tasks'),
                        $this->wrong('Share the credentials with the team'),
                        $this->wrong('Delete it after creating IAM users'),
                    ],
                    'AWS recommends enabling MFA on the root account and using it only for tasks that specifically require root credentials. Create IAM users for daily administrative tasks.',
                    'easy', 'approved'),
                $this->q(
                    'Which IAM policy type is attached directly to a user, group, or role?',
                    [
                        $this->correct('Identity-based policy'),
                        $this->wrong('Resource-based policy'),
                        $this->wrong('Service control policy'),
                        $this->wrong('Permission boundary'),
                    ],
                    'Identity-based policies are attached to IAM identities (users, groups, or roles) and specify what actions the identity can perform on which resources.',
                    'medium', 'approved'),
            ],

            'Data Encryption' => [
                $this->q(
                    'Which AWS service manages encryption keys for you?',
                    [
                        $this->correct('AWS KMS (Key Management Service)'),
                        $this->wrong('AWS CloudHSM'),
                        $this->wrong('AWS Certificate Manager'),
                        $this->wrong('AWS Secrets Manager'),
                    ],
                    'AWS KMS is a managed service that makes it easy to create and control the encryption keys used to encrypt your data across AWS services and applications.',
                    'easy', 'approved'),
                $this->q(
                    'What type of encryption protects data while it is being transmitted over a network?',
                    [
                        $this->correct('Encryption in transit'),
                        $this->wrong('Encryption at rest'),
                        $this->wrong('Client-side encryption'),
                        $this->wrong('Server-side encryption'),
                    ],
                    'Encryption in transit protects data as it travels between systems, typically using TLS/SSL protocols. This prevents interception and eavesdropping.',
                    'easy', 'approved'),
                $this->q(
                    'Which S3 encryption option uses AWS-managed keys?',
                    [
                        $this->correct('SSE-S3'),
                        $this->wrong('SSE-C'),
                        $this->wrong('Client-side encryption'),
                        $this->wrong('SSE-KMS with customer-managed keys'),
                    ],
                    'SSE-S3 (Server-Side Encryption with S3-Managed Keys) uses AWS-managed keys to encrypt objects. AWS handles all key management automatically.',
                    'medium', 'approved'),
            ],

            'Network Security' => [
                $this->q(
                    'Which security component is stateful and operates at the instance level?',
                    [
                        $this->correct('Security Group'),
                        $this->wrong('Network ACL'),
                        $this->wrong('Route Table'),
                        $this->wrong('Internet Gateway'),
                    ],
                    'Security Groups are stateful firewalls that control inbound and outbound traffic at the instance level. If you allow inbound traffic, the response is automatically allowed.',
                    'medium', 'approved'),
                $this->q(
                    'A company wants to protect their web application from common web exploits. Which AWS service should they use?',
                    [
                        $this->correct('AWS WAF (Web Application Firewall)'),
                        $this->wrong('AWS Shield'),
                        $this->wrong('Amazon GuardDuty'),
                        $this->wrong('AWS Security Hub'),
                    ],
                    'AWS WAF helps protect web applications from common web exploits like SQL injection and cross-site scripting that could affect availability, compromise security, or consume resources.',
                    'medium', 'approved'),
                $this->q(
                    'Which AWS service provides DDoS protection?',
                    [
                        $this->correct('AWS Shield'),
                        $this->wrong('AWS WAF'),
                        $this->wrong('Amazon GuardDuty'),
                        $this->wrong('AWS Firewall Manager'),
                    ],
                    'AWS Shield is a managed DDoS protection service. Shield Standard is automatically enabled for all AWS customers at no additional cost.',
                    'easy', 'approved'),
            ],

            // Domain 4: Design Cost-Optimized Architectures
            'Cost-Effective Storage' => [
                $this->q(
                    'Which S3 feature automatically moves objects between storage classes based on access patterns?',
                    [
                        $this->correct('S3 Lifecycle policies'),
                        $this->wrong('S3 Versioning'),
                        $this->wrong('S3 Replication'),
                        $this->wrong('S3 Inventory'),
                    ],
                    'S3 Lifecycle policies allow you to automatically transition objects to different storage classes or delete them after a specified time period, optimizing costs.',
                    'medium', 'approved'),
                $this->q(
                    'Which S3 storage class is designed for long-term archive with retrieval times of 12 hours?',
                    [
                        $this->correct('S3 Glacier Deep Archive'),
                        $this->wrong('S3 Glacier'),
                        $this->wrong('S3 Standard-IA'),
                        $this->wrong('S3 One Zone-IA'),
                    ],
                    'S3 Glacier Deep Archive is the lowest-cost storage class, designed for long-term retention of data that is accessed once or twice a year with retrieval times of 12 hours.',
                    'easy', 'approved'),
                $this->q(
                    'What is the minimum storage duration charge for S3 Standard-IA?',
                    [
                        $this->correct('30 days'),
                        $this->wrong('7 days'),
                        $this->wrong('90 days'),
                        $this->wrong('180 days'),
                    ],
                    'S3 Standard-IA has a minimum storage duration charge of 30 days. If you delete an object before 30 days, you are charged for the full 30 days.',
                    'medium', 'approved'),
            ],

            'Cost-Effective Compute' => [
                $this->q(
                    'Which EC2 pricing model offers up to 72% discount for a 1 or 3-year commitment?',
                    [
                        $this->correct('Reserved Instances'),
                        $this->wrong('Spot Instances'),
                        $this->wrong('On-Demand Instances'),
                        $this->wrong('Dedicated Hosts'),
                    ],
                    'Reserved Instances provide a significant discount (up to 72%) compared to On-Demand pricing in exchange for a 1 or 3-year commitment.',
                    'easy', 'approved'),
                $this->q(
                    'Which AWS service can help identify underutilized EC2 instances?',
                    [
                        $this->correct('AWS Trusted Advisor'),
                        $this->wrong('AWS CloudTrail'),
                        $this->wrong('Amazon CloudWatch'),
                        $this->wrong('AWS Config'),
                    ],
                    'AWS Trusted Advisor provides recommendations to help optimize AWS resources, including identifying underutilized EC2 instances that could be downsized or terminated.',
                    'medium', 'approved'),
                $this->q(
                    'What is the benefit of using Auto Scaling for cost optimization?',
                    [
                        $this->correct('It automatically adjusts capacity to maintain performance at the lowest possible cost'),
                        $this->wrong('It always runs the maximum number of instances'),
                        $this->wrong('It eliminates the need for load balancing'),
                        $this->wrong('It provides free compute capacity'),
                    ],
                    'Auto Scaling helps optimize costs by automatically scaling capacity up during demand spikes and scaling down during quiet periods, ensuring you only pay for what you need.',
                    'medium', 'approved'),
            ],
        ];
    }
}

