<?php

namespace Database\Seeders\Questions;

class AWSCertifiedCloudPractitionerQuestionSeeder extends BaseQuestionSeeder
{
    protected function getCertificationSlug(): string
    {
        return 'aws-certified-cloud-practitioner';
    }

    protected function getQuestionsData(): array
    {
        return [
            // Domain 1: Cloud Concepts
            'Define the AWS Cloud and Value Proposition' => [
                $this->q(
                    'What is cloud computing?',
                    [
                        $this->correct('The on-demand delivery of IT resources over the Internet with pay-as-you-go pricing'),
                        $this->wrong('A physical data center that you own and manage'),
                        $this->wrong('A service that requires you to purchase servers upfront'),
                        $this->wrong('A type of software that runs only on local machines'),
                    ],
                    'Cloud computing is the on-demand delivery of compute power, database storage, applications, and other IT resources through a cloud services platform via the Internet with pay-as-you-go pricing.',
                    'easy', 'approved'),
                $this->q(
                    'Which of the following is a benefit of cloud computing?',
                    [
                        $this->correct('Trade capital expense for variable expense'),
                        $this->wrong('Increase the time to market for new applications'),
                        $this->wrong('Maintain physical servers in your own data center'),
                        $this->wrong('Guess your infrastructure capacity needs'),
                    ],
                    'With cloud computing, you can trade capital expense (such as data centers and physical servers) for variable expense, and only pay for IT as you consume it.',
                    'easy', 'approved'),
                $this->q(
                    'What does "elasticity" mean in cloud computing?',
                    [
                        $this->correct('The ability to acquire resources as you need them and release resources when you no longer need them'),
                        $this->wrong('The ability to automatically recover from failures'),
                        $this->wrong('The ability to distribute applications across multiple regions'),
                        $this->wrong('The ability to encrypt data at rest and in transit'),
                    ],
                    'Elasticity means you can scale resources up or down based on demand. You don\'t have to overprovision resources up front to handle peak levels of business activity in the future.',
                    'medium', 'approved'),
                $this->q(
                    'Which AWS value proposition allows customers to benefit from massive economies of scale?',
                    [
                        $this->correct('Lower variable costs due to AWS achieving higher economies of scale'),
                        $this->wrong('The ability to deploy applications in multiple regions'),
                        $this->wrong('Access to AWS technical support'),
                        $this->wrong('The ability to use reserved instances'),
                    ],
                    'Because usage from hundreds of thousands of customers is aggregated in the cloud, AWS can achieve higher economies of scale, which translates into lower pay-as-you-go prices.',
                    'medium', 'approved'),
                $this->q(
                    'A company wants to reduce the time spent on undifferentiated heavy lifting. Which AWS benefit does this describe?',
                    [
                        $this->correct('Focus on business differentiators rather than infrastructure management'),
                        $this->wrong('Increase the speed of deployment'),
                        $this->wrong('Reduce total cost of ownership'),
                        $this->wrong('Improve security posture'),
                    ],
                    'AWS allows you to focus on projects that differentiate your business, not the infrastructure. AWS takes care of the heavy lifting of racking, stacking, and powering servers.',
                    'medium', 'approved'),
                $this->q(
                    'Which of the following best describes the AWS global infrastructure advantage?',
                    [
                        $this->correct('Deploy applications in multiple geographic locations with low latency'),
                        $this->wrong('Automatically replicate data across all regions'),
                        $this->wrong('Eliminate the need for data backups'),
                        $this->wrong('Provide free data transfer between all AWS services'),
                    ],
                    'AWS has the concept of Regions and Availability Zones. This allows you to deploy applications and data in multiple geographic locations, reducing latency for end users and providing disaster recovery capabilities.',
                    'hard', 'approved'),
            ],

            'Cloud Computing Models' => [
                $this->q(
                    'Which cloud computing model provides the most control over the underlying infrastructure?',
                    [
                        $this->correct('Infrastructure as a Service (IaaS)'),
                        $this->wrong('Platform as a Service (PaaS)'),
                        $this->wrong('Software as a Service (SaaS)'),
                        $this->wrong('Function as a Service (FaaS)'),
                    ],
                    'IaaS provides the highest level of flexibility and management control over your IT resources. It is most similar to existing IT resources that many IT departments and developers are familiar with.',
                    'easy', 'approved'),
                $this->q(
                    'Which service model allows developers to focus on deploying applications without managing the underlying infrastructure?',
                    [
                        $this->correct('Platform as a Service (PaaS)'),
                        $this->wrong('Infrastructure as a Service (IaaS)'),
                        $this->wrong('Software as a Service (SaaS)'),
                        $this->wrong('Desktop as a Service (DaaS)'),
                    ],
                    'PaaS removes the need for organizations to manage the underlying infrastructure (usually hardware and operating systems) and allows you to focus on the deployment and management of your applications.',
                    'easy', 'approved'),
                $this->q(
                    'Amazon EC2 is an example of which cloud computing model?',
                    [
                        $this->correct('Infrastructure as a Service (IaaS)'),
                        $this->wrong('Platform as a Service (PaaS)'),
                        $this->wrong('Software as a Service (SaaS)'),
                        $this->wrong('Container as a Service (CaaS)'),
                    ],
                    'Amazon EC2 provides virtual servers (instances) in the cloud, which is a classic example of IaaS. You have control over the operating system, networking, and storage.',
                    'medium', 'approved'),
                $this->q(
                    'Which of the following is an example of Software as a Service (SaaS)?',
                    [
                        $this->correct('Amazon WorkMail'),
                        $this->wrong('Amazon EC2'),
                        $this->wrong('Amazon S3'),
                        $this->wrong('Amazon VPC'),
                    ],
                    'Amazon WorkMail is a managed email and calendaring service, which is an example of SaaS. Users access the software through a web interface without managing the underlying infrastructure.',
                    'medium', 'approved'),
                $this->q(
                    'What is the primary advantage of using Platform as a Service (PaaS)?',
                    [
                        $this->correct('Reduced complexity in building and maintaining the underlying platform'),
                        $this->wrong('Complete control over the operating system'),
                        $this->wrong('Ability to manage physical servers'),
                        $this->wrong('Direct access to hardware components'),
                    ],
                    'PaaS provides a platform allowing customers to develop, run, and manage applications without the complexity of building and maintaining the infrastructure typically associated with developing and launching an app.',
                    'medium', 'approved'),
                $this->q(
                    'A company needs to run a legacy application that requires specific operating system configurations. Which cloud service model would be most appropriate?',
                    [
                        $this->correct('Infrastructure as a Service (IaaS)'),
                        $this->wrong('Software as a Service (SaaS)'),
                        $this->wrong('Platform as a Service (PaaS)'),
                        $this->wrong('Database as a Service (DBaaS)'),
                    ],
                    'IaaS provides the most control and flexibility, allowing you to configure the operating system and install any required software. This makes it ideal for legacy applications with specific requirements.',
                    'hard', 'approved'),
            ],

            'Cloud Deployment Models' => [
                $this->q(
                    'Which cloud deployment model provides resources over the Internet to the general public?',
                    [
                        $this->correct('Public cloud'),
                        $this->wrong('Private cloud'),
                        $this->wrong('Hybrid cloud'),
                        $this->wrong('Community cloud'),
                    ],
                    'A public cloud is owned and operated by a third-party cloud service provider, which delivers computing resources like servers and storage over the Internet. AWS is an example of a public cloud.',
                    'easy', 'approved'),
                $this->q(
                    'What is a hybrid cloud deployment?',
                    [
                        $this->correct('A combination of on-premises infrastructure and cloud-based resources'),
                        $this->wrong('Multiple public cloud providers used together'),
                        $this->wrong('A private cloud shared among multiple organizations'),
                        $this->wrong('A cloud that only runs containerized applications'),
                    ],
                    'A hybrid cloud deployment connects on-premises infrastructure and applications to cloud-based resources. This allows data and applications to move between on-premises and cloud environments.',
                    'easy', 'approved'),
                $this->q(
                    'Which deployment model would be most suitable for a company with strict data residency requirements?',
                    [
                        $this->correct('Private cloud or on-premises'),
                        $this->wrong('Public cloud only'),
                        $this->wrong('Community cloud'),
                        $this->wrong('Multi-cloud'),
                    ],
                    'Organizations with strict regulatory requirements or data residency needs may choose a private cloud or on-premises deployment to maintain complete control over their data location and security.',
                    'medium', 'approved'),
                $this->q(
                    'What is an advantage of using a hybrid cloud approach?',
                    [
                        $this->correct('Flexibility to keep sensitive data on-premises while using cloud for other workloads'),
                        $this->wrong('Eliminates the need for any on-premises infrastructure'),
                        $this->wrong('Provides free data transfer between environments'),
                        $this->wrong('Automatically replicates all data to the cloud'),
                    ],
                    'Hybrid cloud allows organizations to keep sensitive data and applications on-premises for security or compliance reasons while taking advantage of the cloud\'s scalability and cost-effectiveness for other workloads.',
                    'medium', 'approved'),
                $this->q(
                    'A company wants to migrate some applications to the cloud while keeping others on-premises due to compliance requirements. Which deployment model should they use?',
                    [
                        $this->correct('Hybrid cloud'),
                        $this->wrong('Public cloud'),
                        $this->wrong('Private cloud'),
                        $this->wrong('Multi-cloud'),
                    ],
                    'Hybrid cloud is the ideal solution when you need to maintain some resources on-premises (for compliance, latency, or other reasons) while leveraging cloud services for other applications.',
                    'medium', 'approved'),
                $this->q(
                    'Which AWS service facilitates hybrid cloud deployments by extending AWS infrastructure to on-premises data centers?',
                    [
                        $this->correct('AWS Outposts'),
                        $this->wrong('AWS Direct Connect'),
                        $this->wrong('Amazon VPC'),
                        $this->wrong('AWS CloudFormation'),
                    ],
                    'AWS Outposts brings native AWS services, infrastructure, and operating models to virtually any data center, co-location space, or on-premises facility, enabling true hybrid cloud deployments.',
                    'hard', 'approved'),
            ],

            'AWS Well-Architected Framework' => [
                $this->q(
                    'How many pillars are in the AWS Well-Architected Framework?',
                    [
                        $this->correct('Six'),
                        $this->wrong('Four'),
                        $this->wrong('Five'),
                        $this->wrong('Seven'),
                    ],
                    'The AWS Well-Architected Framework consists of six pillars: Operational Excellence, Security, Reliability, Performance Efficiency, Cost Optimization, and Sustainability.',
                    'easy', 'approved'),
                $this->q(
                    'Which pillar of the AWS Well-Architected Framework focuses on the ability to run and monitor systems?',
                    [
                        $this->correct('Operational Excellence'),
                        $this->wrong('Reliability'),
                        $this->wrong('Performance Efficiency'),
                        $this->wrong('Security'),
                    ],
                    'The Operational Excellence pillar focuses on running and monitoring systems to deliver business value, and continually improving processes and procedures.',
                    'easy', 'approved'),
                $this->q(
                    'Which Well-Architected Framework pillar includes the ability to protect information, systems, and assets?',
                    [
                        $this->correct('Security'),
                        $this->wrong('Operational Excellence'),
                        $this->wrong('Reliability'),
                        $this->wrong('Cost Optimization'),
                    ],
                    'The Security pillar focuses on protecting information and systems. Key topics include confidentiality and integrity of data, identifying and managing who can do what, protecting systems, and establishing controls to detect security events.',
                    'medium', 'approved'),
                $this->q(
                    'What does the Reliability pillar of the Well-Architected Framework focus on?',
                    [
                        $this->correct('The ability of a system to recover from failures and meet demand'),
                        $this->wrong('Running systems at the lowest cost'),
                        $this->wrong('Protecting data and systems from unauthorized access'),
                        $this->wrong('Using computing resources efficiently'),
                    ],
                    'The Reliability pillar encompasses the ability of a workload to perform its intended function correctly and consistently when it\'s expected to. This includes the ability to operate and test the workload through its total lifecycle.',
                    'medium', 'approved'),
                $this->q(
                    'Which design principle is part of the Cost Optimization pillar?',
                    [
                        $this->correct('Adopt a consumption model'),
                        $this->wrong('Deploy systems in multiple Availability Zones'),
                        $this->wrong('Implement strong identity foundation'),
                        $this->wrong('Automate recovery from failure'),
                    ],
                    'The Cost Optimization pillar includes the ability to run systems to deliver business value at the lowest price point. Key design principles include adopting a consumption model, measuring overall efficiency, and analyzing and attributing expenditure.',
                    'medium', 'approved'),
                $this->q(
                    'A company wants to ensure their AWS architecture can automatically recover from failures. Which Well-Architected Framework pillar and design principle should they focus on?',
                    [
                        $this->correct('Reliability pillar - Automatically recover from failure'),
                        $this->wrong('Security pillar - Enable traceability'),
                        $this->wrong('Performance Efficiency pillar - Democratize advanced technologies'),
                        $this->wrong('Operational Excellence pillar - Perform operations as code'),
                    ],
                    'The Reliability pillar includes the design principle of automatically recovering from failure. By monitoring a workload for key performance indicators (KPIs), you can trigger automation when a threshold is breached.',
                    'hard', 'approved'),
            ],

            'Total Cost of Ownership (TCO)' => [
                $this->q(
                    'What does TCO stand for in cloud computing?',
                    [
                        $this->correct('Total Cost of Ownership'),
                        $this->wrong('Total Cloud Operations'),
                        $this->wrong('Technical Cost Optimization'),
                        $this->wrong('Total Compute Overhead'),
                    ],
                    'TCO stands for Total Cost of Ownership, which is a financial estimate intended to help buyers and owners determine the direct and indirect costs of a product or system.',
                    'easy', 'approved'),
                $this->q(
                    'Which of the following is typically included in an on-premises TCO calculation?',
                    [
                        $this->correct('Hardware costs, facility costs, and personnel costs'),
                        $this->wrong('Only the cost of servers'),
                        $this->wrong('Only software licensing fees'),
                        $this->wrong('Only network bandwidth costs'),
                    ],
                    'On-premises TCO includes hardware acquisition and maintenance, facility costs (power, cooling, physical space), personnel costs (IT staff), and other operational expenses.',
                    'easy', 'approved'),
                $this->q(
                    'How does cloud computing typically affect Total Cost of Ownership compared to on-premises infrastructure?',
                    [
                        $this->correct('Reduces upfront capital expenses and converts them to operational expenses'),
                        $this->wrong('Increases upfront capital expenses'),
                        $this->wrong('Eliminates all IT costs'),
                        $this->wrong('Requires more IT staff to manage'),
                    ],
                    'Cloud computing reduces TCO by eliminating or reducing upfront capital expenses for hardware and data centers, converting these to pay-as-you-go operational expenses.',
                    'medium', 'approved'),
                $this->q(
                    'Which cost is eliminated when moving from on-premises to AWS cloud?',
                    [
                        $this->correct('Data center facility costs'),
                        $this->wrong('Network bandwidth costs'),
                        $this->wrong('Software licensing costs'),
                        $this->wrong('Data storage costs'),
                    ],
                    'When moving to AWS, you eliminate data center facility costs such as rent, power, cooling, and physical security. AWS manages these costs as part of their infrastructure.',
                    'medium', 'approved'),
                $this->q(
                    'What is a key benefit of using the AWS TCO Calculator?',
                    [
                        $this->correct('Compare the cost of running applications on-premises versus in AWS'),
                        $this->wrong('Calculate the exact monthly AWS bill'),
                        $this->wrong('Determine which AWS services to use'),
                        $this->wrong('Estimate application performance in the cloud'),
                    ],
                    'The AWS TCO Calculator helps you estimate the cost savings of using AWS compared to on-premises infrastructure by comparing the total cost of ownership.',
                    'medium', 'approved'),
                $this->q(
                    'A company is evaluating whether to migrate to AWS. Which factors should be considered in a comprehensive TCO analysis?',
                    [
                        $this->correct('Server costs, storage costs, network costs, IT labor costs, and facility costs'),
                        $this->wrong('Only the cost of AWS services'),
                        $this->wrong('Only hardware and software costs'),
                        $this->wrong('Only the cost of data migration'),
                    ],
                    'A comprehensive TCO analysis should include all direct and indirect costs: server hardware and software, storage, network infrastructure, IT labor, facilities (power, cooling, space), and other operational costs.',
                    'hard', 'approved'),
            ],

            // Domain 2: Security and Compliance
            'AWS Shared Responsibility Model' => [
                $this->q(
                    'In the AWS Shared Responsibility Model, who is responsible for the security "of" the cloud?',
                    [
                        $this->correct('AWS'),
                        $this->wrong('The customer'),
                        $this->wrong('Both AWS and the customer equally'),
                        $this->wrong('Third-party auditors'),
                    ],
                    'AWS is responsible for security "of" the cloud, which includes protecting the infrastructure that runs all AWS services. This includes hardware, software, networking, and facilities.',
                    'easy', 'approved'),
                $this->q(
                    'In the AWS Shared Responsibility Model, who is responsible for security "in" the cloud?',
                    [
                        $this->correct('The customer'),
                        $this->wrong('AWS'),
                        $this->wrong('Both AWS and the customer equally'),
                        $this->wrong('The cloud service provider only'),
                    ],
                    'Customers are responsible for security "in" the cloud, which includes customer data, platform and application management, operating systems, network configuration, and encryption.',
                    'easy', 'approved'),
                $this->q(
                    'Which of the following is a customer responsibility under the AWS Shared Responsibility Model?',
                    [
                        $this->correct('Managing IAM user access and permissions'),
                        $this->wrong('Maintaining physical security of data centers'),
                        $this->wrong('Patching the underlying hypervisor'),
                        $this->wrong('Managing the physical network infrastructure'),
                    ],
                    'Customers are responsible for managing Identity and Access Management (IAM), including creating users, groups, roles, and policies to control access to AWS resources.',
                    'medium', 'approved'),
                $this->q(
                    'For Amazon EC2, which of the following is AWS responsible for?',
                    [
                        $this->correct('Physical security of the data center'),
                        $this->wrong('Patching the guest operating system'),
                        $this->wrong('Configuring security groups'),
                        $this->wrong('Managing application code'),
                    ],
                    'AWS is responsible for the physical security of the infrastructure, including data centers, hardware, and the underlying virtualization layer. Customers are responsible for the guest OS and above.',
                    'medium', 'approved'),
                $this->q(
                    'Which security aspect is shared between AWS and the customer?',
                    [
                        $this->correct('Patch management'),
                        $this->wrong('Physical infrastructure security'),
                        $this->wrong('Edge location security'),
                        $this->wrong('Hardware disposal'),
                    ],
                    'Patch management is a shared responsibility. AWS is responsible for patching the underlying infrastructure, while customers are responsible for patching their guest operating systems and applications.',
                    'medium', 'approved'),
                $this->q(
                    'For Amazon RDS, which of the following is the customer responsible for?',
                    [
                        $this->correct('Managing database user accounts and permissions'),
                        $this->wrong('Patching the database software'),
                        $this->wrong('Backing up the underlying storage'),
                        $this->wrong('Maintaining the database engine'),
                    ],
                    'For managed services like RDS, AWS handles infrastructure tasks like patching and backups. Customers are responsible for managing database users, permissions, and configuring database-specific security settings.',
                    'hard', 'approved'),
            ],

            'AWS Identity and Access Management (IAM)' => [
                $this->q(
                    'What is AWS IAM used for?',
                    [
                        $this->correct('Managing user access and permissions to AWS resources'),
                        $this->wrong('Monitoring AWS resource usage'),
                        $this->wrong('Creating virtual private clouds'),
                        $this->wrong('Storing and retrieving data'),
                    ],
                    'AWS Identity and Access Management (IAM) enables you to manage access to AWS services and resources securely. You can create and manage AWS users and groups and use permissions to allow and deny their access to AWS resources.',
                    'easy', 'approved'),
                $this->q(
                    'What is the AWS best practice for the root account?',
                    [
                        $this->correct('Enable MFA and avoid using it for everyday tasks'),
                        $this->wrong('Use it for all administrative tasks'),
                        $this->wrong('Share the credentials with the team'),
                        $this->wrong('Disable it after creating IAM users'),
                    ],
                    'AWS best practice is to enable multi-factor authentication (MFA) on the root account and avoid using it for everyday tasks. Instead, create IAM users with appropriate permissions for daily operations.',
                    'easy', 'approved'),
                $this->q(
                    'What is an IAM role?',
                    [
                        $this->correct('An IAM identity with permissions that can be assumed by users, applications, or services'),
                        $this->wrong('A permanent set of credentials for a user'),
                        $this->wrong('A physical security token'),
                        $this->wrong('A type of AWS resource'),
                    ],
                    'An IAM role is an identity you can create that has specific permissions. Roles are assumed by users, applications, or services and provide temporary security credentials.',
                    'medium', 'approved'),
                $this->q(
                    'Which IAM entity should be used to grant permissions to an EC2 instance to access S3?',
                    [
                        $this->correct('IAM role'),
                        $this->wrong('IAM user'),
                        $this->wrong('IAM group'),
                        $this->wrong('Access key'),
                    ],
                    'IAM roles should be used to grant permissions to EC2 instances. The role provides temporary credentials that are automatically rotated, which is more secure than embedding access keys in the instance.',
                    'medium', 'approved'),
                $this->q(
                    'What does the principle of least privilege mean in IAM?',
                    [
                        $this->correct('Grant only the permissions required to perform a task'),
                        $this->wrong('Grant all permissions by default and remove as needed'),
                        $this->wrong('Grant read-only access to all resources'),
                        $this->wrong('Grant administrator access to all users'),
                    ],
                    'The principle of least privilege means granting only the permissions necessary to perform a specific task. This minimizes security risks by limiting what users and services can do.',
                    'medium', 'approved'),
                $this->q(
                    'A developer needs temporary access to production resources for troubleshooting. What is the most secure way to grant this access?',
                    [
                        $this->correct('Create an IAM role with the required permissions and allow the developer to assume it temporarily'),
                        $this->wrong('Share the root account credentials'),
                        $this->wrong('Create a permanent IAM user with administrator access'),
                        $this->wrong('Add the developer to the administrators group'),
                    ],
                    'Using IAM roles with temporary credentials is the most secure approach. The developer can assume the role when needed, and the credentials automatically expire, reducing the risk of credential exposure.',
                    'hard', 'approved'),
            ],

            'Security Groups and Network ACLs' => [
                $this->q(
                    'What is a security group in AWS?',
                    [
                        $this->correct('A virtual firewall that controls inbound and outbound traffic for EC2 instances'),
                        $this->wrong('A group of IAM users with similar permissions'),
                        $this->wrong('A collection of AWS resources in the same region'),
                        $this->wrong('A physical firewall device'),
                    ],
                    'A security group acts as a virtual firewall for EC2 instances to control inbound and outbound traffic. You can specify allowed protocols, ports, and source/destination IP addresses.',
                    'easy', 'approved'),
                $this->q(
                    'What is the default behavior of a security group?',
                    [
                        $this->correct('Deny all inbound traffic and allow all outbound traffic'),
                        $this->wrong('Allow all inbound and outbound traffic'),
                        $this->wrong('Deny all inbound and outbound traffic'),
                        $this->wrong('Allow all inbound traffic and deny all outbound traffic'),
                    ],
                    'By default, security groups deny all inbound traffic and allow all outbound traffic. You must explicitly add rules to allow inbound traffic.',
                    'easy', 'approved'),
                $this->q(
                    'How do security groups differ from network ACLs?',
                    [
                        $this->correct('Security groups are stateful, while network ACLs are stateless'),
                        $this->wrong('Security groups operate at the subnet level, while network ACLs operate at the instance level'),
                        $this->wrong('Security groups support deny rules, while network ACLs do not'),
                        $this->wrong('Security groups are stateless, while network ACLs are stateful'),
                    ],
                    'Security groups are stateful, meaning return traffic is automatically allowed. Network ACLs are stateless, requiring explicit rules for both inbound and outbound traffic.',
                    'medium', 'approved'),
                $this->q(
                    'At what level do network ACLs operate?',
                    [
                        $this->correct('Subnet level'),
                        $this->wrong('Instance level'),
                        $this->wrong('VPC level'),
                        $this->wrong('Region level'),
                    ],
                    'Network ACLs operate at the subnet level and apply to all instances in the subnet. They provide an additional layer of security beyond security groups.',
                    'medium', 'approved'),
                $this->q(
                    'Can security groups have deny rules?',
                    [
                        $this->correct('No, security groups only support allow rules'),
                        $this->wrong('Yes, security groups support both allow and deny rules'),
                        $this->wrong('Yes, but only for outbound traffic'),
                        $this->wrong('Yes, but only for inbound traffic'),
                    ],
                    'Security groups only support allow rules. All traffic is denied by default, and you explicitly allow the traffic you want. To deny specific traffic, you would use network ACLs.',
                    'medium', 'approved'),
                $this->q(
                    'A company needs to block traffic from a specific IP address. Which AWS feature should they use?',
                    [
                        $this->correct('Network ACL'),
                        $this->wrong('Security group'),
                        $this->wrong('IAM policy'),
                        $this->wrong('Route table'),
                    ],
                    'Network ACLs support deny rules, making them the appropriate choice for blocking specific IP addresses. Security groups only support allow rules.',
                    'hard', 'approved'),
            ],

            'Data Encryption and Key Management' => [
                $this->q(
                    'What is encryption at rest?',
                    [
                        $this->correct('Encryption of data while it is stored on disk'),
                        $this->wrong('Encryption of data while it is being transmitted'),
                        $this->wrong('Encryption of data in memory'),
                        $this->wrong('Encryption of data during processing'),
                    ],
                    'Encryption at rest refers to encrypting data while it is stored on disk or in a database. This protects data from unauthorized access if the storage media is compromised.',
                    'easy', 'approved'),
                $this->q(
                    'What is AWS Key Management Service (KMS) used for?',
                    [
                        $this->correct('Creating and managing encryption keys'),
                        $this->wrong('Managing IAM users and groups'),
                        $this->wrong('Monitoring AWS resources'),
                        $this->wrong('Storing application secrets'),
                    ],
                    'AWS KMS is a managed service that makes it easy to create and control the encryption keys used to encrypt your data. It integrates with many AWS services to protect data.',
                    'easy', 'approved'),
                $this->q(
                    'Which AWS service provides encryption at rest for S3 objects?',
                    [
                        $this->correct('AWS KMS or S3-managed keys (SSE-S3)'),
                        $this->wrong('AWS CloudHSM only'),
                        $this->wrong('AWS Certificate Manager'),
                        $this->wrong('AWS Secrets Manager'),
                    ],
                    'Amazon S3 supports server-side encryption using AWS KMS keys (SSE-KMS) or S3-managed keys (SSE-S3). You can also use client-side encryption before uploading to S3.',
                    'medium', 'approved'),
                $this->q(
                    'What is the difference between encryption at rest and encryption in transit?',
                    [
                        $this->correct('Encryption at rest protects stored data, while encryption in transit protects data being transmitted'),
                        $this->wrong('Encryption at rest is faster than encryption in transit'),
                        $this->wrong('Encryption at rest uses symmetric keys, while encryption in transit uses asymmetric keys'),
                        $this->wrong('Encryption at rest is mandatory, while encryption in transit is optional'),
                    ],
                    'Encryption at rest protects data stored on disk, while encryption in transit (using protocols like TLS/SSL) protects data as it moves between systems over a network.',
                    'medium', 'approved'),
                $this->q(
                    'Which AWS service helps manage and rotate secrets such as database credentials?',
                    [
                        $this->correct('AWS Secrets Manager'),
                        $this->wrong('AWS KMS'),
                        $this->wrong('AWS IAM'),
                        $this->wrong('AWS Certificate Manager'),
                    ],
                    'AWS Secrets Manager helps you protect access to your applications, services, and IT resources. It enables you to easily rotate, manage, and retrieve database credentials, API keys, and other secrets.',
                    'medium', 'approved'),
                $this->q(
                    'A company needs to meet compliance requirements for hardware security modules (HSMs). Which AWS service should they use?',
                    [
                        $this->correct('AWS CloudHSM'),
                        $this->wrong('AWS KMS'),
                        $this->wrong('AWS Secrets Manager'),
                        $this->wrong('AWS Certificate Manager'),
                    ],
                    'AWS CloudHSM provides hardware security modules in the AWS Cloud. It allows you to meet corporate, contractual, and regulatory compliance requirements for data security by using dedicated HSM instances.',
                    'hard', 'approved'),
            ],

            'Compliance and Governance' => [
                $this->q(
                    'What is AWS Artifact?',
                    [
                        $this->correct('A portal that provides access to AWS compliance reports and agreements'),
                        $this->wrong('A service for deploying applications'),
                        $this->wrong('A tool for monitoring AWS resources'),
                        $this->wrong('A database service'),
                    ],
                    'AWS Artifact is a self-service portal for on-demand access to AWS compliance reports and select online agreements. It provides access to security and compliance documents.',
                    'easy', 'approved'),
                $this->q(
                    'Which AWS service helps ensure resources comply with company policies?',
                    [
                        $this->correct('AWS Config'),
                        $this->wrong('AWS CloudTrail'),
                        $this->wrong('Amazon CloudWatch'),
                        $this->wrong('AWS Trusted Advisor'),
                    ],
                    'AWS Config is a service that enables you to assess, audit, and evaluate the configurations of your AWS resources. It helps ensure compliance with internal policies and regulatory standards.',
                    'easy', 'approved'),
                $this->q(
                    'What does AWS CloudTrail record?',
                    [
                        $this->correct('API calls made in your AWS account'),
                        $this->wrong('Performance metrics of EC2 instances'),
                        $this->wrong('Network traffic patterns'),
                        $this->wrong('Application logs'),
                    ],
                    'AWS CloudTrail records API calls made in your AWS account, providing a history of AWS API calls for security analysis, resource change tracking, and compliance auditing.',
                    'medium', 'approved'),
                $this->q(
                    'Which compliance program certifies that AWS has appropriate controls to protect customer data?',
                    [
                        $this->correct('SOC 2'),
                        $this->wrong('GDPR'),
                        $this->wrong('HIPAA'),
                        $this->wrong('PCI DSS'),
                    ],
                    'SOC 2 is an auditing procedure that ensures service providers securely manage data to protect the interests of the organization and the privacy of its clients. AWS maintains SOC 2 compliance.',
                    'medium', 'approved'),
                $this->q(
                    'What is the purpose of AWS Organizations?',
                    [
                        $this->correct('Centrally manage and govern multiple AWS accounts'),
                        $this->wrong('Monitor application performance'),
                        $this->wrong('Deploy applications across regions'),
                        $this->wrong('Encrypt data at rest'),
                    ],
                    'AWS Organizations helps you centrally manage and govern your environment as you grow and scale your AWS resources. You can create groups of accounts and apply policies to those groups.',
                    'medium', 'approved'),
                $this->q(
                    'A healthcare company needs to ensure their AWS infrastructure meets HIPAA compliance requirements. What should they do?',
                    [
                        $this->correct('Sign a Business Associate Agreement (BAA) with AWS and use HIPAA-eligible services'),
                        $this->wrong('Use any AWS service without additional configuration'),
                        $this->wrong('Only use AWS GovCloud'),
                        $this->wrong('Enable encryption on all services'),
                    ],
                    'To meet HIPAA requirements, companies must sign a BAA with AWS and use only HIPAA-eligible services. They must also implement appropriate security controls and configurations.',
                    'hard', 'approved'),
            ],

            // Domain 3: Cloud Technology and Services
            'Compute Services' => [
                $this->q(
                    'What is Amazon EC2?',
                    [
                        $this->correct('A service that provides resizable virtual servers in the cloud'),
                        $this->wrong('A managed database service'),
                        $this->wrong('A content delivery network'),
                        $this->wrong('A serverless compute service'),
                    ],
                    'Amazon Elastic Compute Cloud (EC2) provides secure, resizable compute capacity in the cloud. It allows you to launch virtual servers (instances) with various operating systems and configurations.',
                    'easy', 'approved'),
                $this->q(
                    'Which AWS service allows you to run code without provisioning servers?',
                    [
                        $this->correct('AWS Lambda'),
                        $this->wrong('Amazon EC2'),
                        $this->wrong('Amazon ECS'),
                        $this->wrong('AWS Elastic Beanstalk'),
                    ],
                    'AWS Lambda is a serverless compute service that runs your code in response to events and automatically manages the underlying compute resources. You don\'t need to provision or manage servers.',
                    'easy', 'approved'),
                $this->q(
                    'What is Amazon ECS used for?',
                    [
                        $this->correct('Running and managing Docker containers'),
                        $this->wrong('Storing files in the cloud'),
                        $this->wrong('Managing databases'),
                        $this->wrong('Creating virtual networks'),
                    ],
                    'Amazon Elastic Container Service (ECS) is a fully managed container orchestration service that makes it easy to deploy, manage, and scale containerized applications using Docker.',
                    'medium', 'approved'),
                $this->q(
                    'Which EC2 pricing model provides the biggest discount for long-term commitments?',
                    [
                        $this->correct('Reserved Instances'),
                        $this->wrong('On-Demand Instances'),
                        $this->wrong('Spot Instances'),
                        $this->wrong('Dedicated Hosts'),
                    ],
                    'Reserved Instances provide significant discounts (up to 75%) compared to On-Demand pricing in exchange for a commitment to use EC2 for a one or three-year term.',
                    'medium', 'approved'),
                $this->q(
                    'What is AWS Elastic Beanstalk?',
                    [
                        $this->correct('A Platform as a Service (PaaS) for deploying and managing applications'),
                        $this->wrong('A database migration service'),
                        $this->wrong('A content delivery network'),
                        $this->wrong('A monitoring service'),
                    ],
                    'AWS Elastic Beanstalk is a PaaS that allows you to deploy and manage applications without worrying about the infrastructure. You upload your code and Elastic Beanstalk handles deployment, capacity provisioning, load balancing, and auto-scaling.',
                    'medium', 'approved'),
                $this->q(
                    'A company has a batch processing job that can tolerate interruptions and needs to minimize costs. Which EC2 pricing model should they use?',
                    [
                        $this->correct('Spot Instances'),
                        $this->wrong('On-Demand Instances'),
                        $this->wrong('Reserved Instances'),
                        $this->wrong('Dedicated Instances'),
                    ],
                    'Spot Instances allow you to bid on spare EC2 capacity at up to 90% discount compared to On-Demand prices. They are ideal for fault-tolerant, flexible workloads that can handle interruptions.',
                    'hard', 'approved'),
            ],

            'Storage Services' => [
                $this->q(
                    'What is Amazon S3 used for?',
                    [
                        $this->correct('Object storage for files and backups'),
                        $this->wrong('Block storage for EC2 instances'),
                        $this->wrong('Relational database storage'),
                        $this->wrong('In-memory caching'),
                    ],
                    'Amazon Simple Storage Service (S3) is an object storage service that offers industry-leading scalability, data availability, security, and performance. It\'s ideal for storing and retrieving any amount of data.',
                    'easy', 'approved'),
                $this->q(
                    'Which storage service provides block-level storage for EC2 instances?',
                    [
                        $this->correct('Amazon EBS (Elastic Block Store)'),
                        $this->wrong('Amazon S3'),
                        $this->wrong('Amazon EFS'),
                        $this->wrong('Amazon Glacier'),
                    ],
                    'Amazon EBS provides block-level storage volumes for use with EC2 instances. EBS volumes behave like raw, unformatted block devices that can be attached to instances.',
                    'easy', 'approved'),
                $this->q(
                    'What is Amazon Glacier used for?',
                    [
                        $this->correct('Long-term archival storage with low cost'),
                        $this->wrong('Frequently accessed data storage'),
                        $this->wrong('Database storage'),
                        $this->wrong('Real-time data processing'),
                    ],
                    'Amazon S3 Glacier is a secure, durable, and low-cost storage class for data archiving and long-term backup. It\'s designed for data that is infrequently accessed and for which retrieval times of several hours are acceptable.',
                    'medium', 'approved'),
                $this->q(
                    'Which storage service provides a file system interface for multiple EC2 instances?',
                    [
                        $this->correct('Amazon EFS (Elastic File System)'),
                        $this->wrong('Amazon EBS'),
                        $this->wrong('Amazon S3'),
                        $this->wrong('Amazon Glacier'),
                    ],
                    'Amazon EFS provides a simple, scalable, elastic file system for Linux-based workloads. It can be accessed by multiple EC2 instances simultaneously, making it ideal for shared file storage.',
                    'medium', 'approved'),
                $this->q(
                    'What is the difference between S3 Standard and S3 Intelligent-Tiering?',
                    [
                        $this->correct('S3 Intelligent-Tiering automatically moves objects between access tiers based on usage patterns'),
                        $this->wrong('S3 Standard is cheaper than S3 Intelligent-Tiering'),
                        $this->wrong('S3 Intelligent-Tiering has lower durability'),
                        $this->wrong('S3 Standard provides faster retrieval times'),
                    ],
                    'S3 Intelligent-Tiering automatically moves objects between frequent and infrequent access tiers based on changing access patterns, optimizing costs without performance impact or operational overhead.',
                    'medium', 'approved'),
                $this->q(
                    'A company needs to store data that must be accessed immediately but is rarely accessed after 30 days. Which S3 storage class combination is most cost-effective?',
                    [
                        $this->correct('S3 Standard with a lifecycle policy to transition to S3 Standard-IA after 30 days'),
                        $this->wrong('S3 Glacier for all data'),
                        $this->wrong('S3 Standard for all data'),
                        $this->wrong('S3 One Zone-IA for all data'),
                    ],
                    'Using S3 Standard for immediate access and transitioning to S3 Standard-IA (Infrequent Access) after 30 days provides the best balance of performance and cost. Lifecycle policies can automate this transition.',
                    'hard', 'approved'),
            ],

            'Database Services' => [
                $this->q(
                    'What is Amazon RDS?',
                    [
                        $this->correct('A managed relational database service'),
                        $this->wrong('A NoSQL database service'),
                        $this->wrong('An in-memory caching service'),
                        $this->wrong('A data warehouse service'),
                    ],
                    'Amazon Relational Database Service (RDS) makes it easy to set up, operate, and scale a relational database in the cloud. It supports multiple database engines including MySQL, PostgreSQL, Oracle, and SQL Server.',
                    'easy', 'approved'),
                $this->q(
                    'Which AWS database service is designed for NoSQL workloads?',
                    [
                        $this->correct('Amazon DynamoDB'),
                        $this->wrong('Amazon RDS'),
                        $this->wrong('Amazon Redshift'),
                        $this->wrong('Amazon Aurora'),
                    ],
                    'Amazon DynamoDB is a fully managed NoSQL database service that provides fast and predictable performance with seamless scalability. It supports both document and key-value data models.',
                    'easy', 'approved'),
                $this->q(
                    'What is Amazon Aurora?',
                    [
                        $this->correct('A MySQL and PostgreSQL-compatible relational database built for the cloud'),
                        $this->wrong('A NoSQL database service'),
                        $this->wrong('A data warehousing service'),
                        $this->wrong('An in-memory database'),
                    ],
                    'Amazon Aurora is a MySQL and PostgreSQL-compatible relational database built for the cloud. It combines the performance and availability of high-end commercial databases with the simplicity and cost-effectiveness of open-source databases.',
                    'medium', 'approved'),
                $this->q(
                    'Which database service is optimized for data warehousing and analytics?',
                    [
                        $this->correct('Amazon Redshift'),
                        $this->wrong('Amazon DynamoDB'),
                        $this->wrong('Amazon RDS'),
                        $this->wrong('Amazon ElastiCache'),
                    ],
                    'Amazon Redshift is a fast, fully managed data warehouse that makes it simple and cost-effective to analyze all your data using standard SQL and existing business intelligence tools.',
                    'medium', 'approved'),
                $this->q(
                    'What is Amazon ElastiCache used for?',
                    [
                        $this->correct('In-memory caching to improve application performance'),
                        $this->wrong('Long-term data archival'),
                        $this->wrong('Relational database storage'),
                        $this->wrong('Data warehousing'),
                    ],
                    'Amazon ElastiCache is a fully managed in-memory caching service that supports Redis and Memcached. It improves application performance by retrieving data from fast, managed, in-memory caches.',
                    'medium', 'approved'),
                $this->q(
                    'A company needs a database that can handle millions of requests per second with single-digit millisecond latency. Which AWS service should they use?',
                    [
                        $this->correct('Amazon DynamoDB'),
                        $this->wrong('Amazon RDS'),
                        $this->wrong('Amazon Redshift'),
                        $this->wrong('Amazon Aurora'),
                    ],
                    'DynamoDB is designed for high-performance applications that require consistent, single-digit millisecond latency at any scale. It can handle more than 10 trillion requests per day and support peaks of more than 20 million requests per second.',
                    'hard', 'approved'),
            ],

            'Networking and Content Delivery' => [
                $this->q(
                    'What is Amazon VPC?',
                    [
                        $this->correct('A virtual private network in the AWS cloud'),
                        $this->wrong('A content delivery network'),
                        $this->wrong('A database service'),
                        $this->wrong('A monitoring service'),
                    ],
                    'Amazon Virtual Private Cloud (VPC) lets you provision a logically isolated section of the AWS Cloud where you can launch AWS resources in a virtual network that you define.',
                    'easy', 'approved'),
                $this->q(
                    'What is Amazon CloudFront?',
                    [
                        $this->correct('A content delivery network (CDN) service'),
                        $this->wrong('A compute service'),
                        $this->wrong('A database service'),
                        $this->wrong('A storage service'),
                    ],
                    'Amazon CloudFront is a fast content delivery network (CDN) service that securely delivers data, videos, applications, and APIs to customers globally with low latency and high transfer speeds.',
                    'easy', 'approved'),
                $this->q(
                    'What is Amazon Route 53 used for?',
                    [
                        $this->correct('Domain Name System (DNS) web service'),
                        $this->wrong('Load balancing only'),
                        $this->wrong('Content delivery'),
                        $this->wrong('Virtual private networking'),
                    ],
                    'Amazon Route 53 is a highly available and scalable Domain Name System (DNS) web service. It routes end users to Internet applications by translating domain names into IP addresses.',
                    'medium', 'approved'),
                $this->q(
                    'Which service distributes incoming application traffic across multiple targets?',
                    [
                        $this->correct('Elastic Load Balancing (ELB)'),
                        $this->wrong('Amazon Route 53'),
                        $this->wrong('Amazon CloudFront'),
                        $this->wrong('AWS Direct Connect'),
                    ],
                    'Elastic Load Balancing automatically distributes incoming application traffic across multiple targets, such as EC2 instances, containers, and IP addresses, in multiple Availability Zones.',
                    'medium', 'approved'),
                $this->q(
                    'What is AWS Direct Connect?',
                    [
                        $this->correct('A dedicated network connection from your premises to AWS'),
                        $this->wrong('A VPN connection to AWS'),
                        $this->wrong('A content delivery network'),
                        $this->wrong('A DNS service'),
                    ],
                    'AWS Direct Connect is a cloud service that establishes a dedicated network connection from your premises to AWS. It can reduce network costs, increase bandwidth throughput, and provide a more consistent network experience.',
                    'medium', 'approved'),
                $this->q(
                    'A company wants to improve the performance of their global web application by caching content closer to users. Which AWS service should they use?',
                    [
                        $this->correct('Amazon CloudFront'),
                        $this->wrong('Amazon Route 53'),
                        $this->wrong('Elastic Load Balancing'),
                        $this->wrong('AWS Direct Connect'),
                    ],
                    'CloudFront caches content at edge locations around the world, reducing latency by serving content from the location closest to the user. This significantly improves application performance for global users.',
                    'hard', 'approved'),
            ],

            'Management and Monitoring' => [
                $this->q(
                    'What is Amazon CloudWatch used for?',
                    [
                        $this->correct('Monitoring AWS resources and applications'),
                        $this->wrong('Deploying applications'),
                        $this->wrong('Managing user access'),
                        $this->wrong('Storing data'),
                    ],
                    'Amazon CloudWatch is a monitoring and observability service that provides data and actionable insights for AWS resources and applications. It collects monitoring and operational data in the form of logs, metrics, and events.',
                    'easy', 'approved'),
                $this->q(
                    'What is AWS CloudFormation used for?',
                    [
                        $this->correct('Infrastructure as Code - automating resource provisioning'),
                        $this->wrong('Monitoring application performance'),
                        $this->wrong('Managing user identities'),
                        $this->wrong('Storing and retrieving files'),
                    ],
                    'AWS CloudFormation provides a common language for describing and provisioning all infrastructure resources in your cloud environment. It allows you to use code to automate the setup of AWS resources.',
                    'easy', 'approved'),
                $this->q(
                    'Which service provides recommendations to help optimize AWS infrastructure?',
                    [
                        $this->correct('AWS Trusted Advisor'),
                        $this->wrong('AWS Config'),
                        $this->wrong('Amazon CloudWatch'),
                        $this->wrong('AWS CloudTrail'),
                    ],
                    'AWS Trusted Advisor provides real-time guidance to help you provision your resources following AWS best practices. It inspects your AWS environment and makes recommendations for cost optimization, performance, security, and fault tolerance.',
                    'medium', 'approved'),
                $this->q(
                    'What is AWS Systems Manager used for?',
                    [
                        $this->correct('Centralized operational management of AWS resources'),
                        $this->wrong('User authentication and authorization'),
                        $this->wrong('Data encryption'),
                        $this->wrong('Content delivery'),
                    ],
                    'AWS Systems Manager gives you visibility and control of your infrastructure on AWS. It provides a unified user interface to view operational data from multiple AWS services and automate operational tasks.',
                    'medium', 'approved'),
                $this->q(
                    'Which AWS service helps you track resource configuration changes over time?',
                    [
                        $this->correct('AWS Config'),
                        $this->wrong('AWS CloudTrail'),
                        $this->wrong('Amazon CloudWatch'),
                        $this->wrong('AWS Systems Manager'),
                    ],
                    'AWS Config provides a detailed view of the configuration of AWS resources in your account. It records configuration changes and enables you to assess how a resource was configured at any point in time.',
                    'medium', 'approved'),
                $this->q(
                    'A company needs to automatically respond to security findings and remediate non-compliant resources. Which combination of services should they use?',
                    [
                        $this->correct('AWS Config with AWS Systems Manager Automation'),
                        $this->wrong('AWS CloudTrail with Amazon CloudWatch'),
                        $this->wrong('AWS Trusted Advisor with AWS Lambda'),
                        $this->wrong('Amazon GuardDuty with AWS Shield'),
                    ],
                    'AWS Config can detect non-compliant resources and trigger AWS Systems Manager Automation documents to automatically remediate issues, providing automated compliance enforcement.',
                    'hard', 'approved'),
            ],

            // Domain 4: Billing, Pricing, and Support
            'AWS Pricing Models' => [
                $this->q(
                    'What is the AWS Free Tier?',
                    [
                        $this->correct('A program that offers free usage of certain AWS services for 12 months'),
                        $this->wrong('A discount program for enterprise customers'),
                        $this->wrong('A trial period for all AWS services'),
                        $this->wrong('A loyalty program for long-term customers'),
                    ],
                    'The AWS Free Tier enables you to gain free, hands-on experience with AWS services. It includes services with a free tier available for 12 months following your AWS sign-up date, as well as additional service offers that do not expire.',
                    'easy', 'approved'),
                $this->q(
                    'Which AWS pricing model allows you to pay only for the resources you use?',
                    [
                        $this->correct('Pay-as-you-go'),
                        $this->wrong('Reserved capacity'),
                        $this->wrong('Enterprise agreement'),
                        $this->wrong('Volume licensing'),
                    ],
                    'Pay-as-you-go pricing allows you to pay for compute capacity by the hour or second with no long-term commitments. This eliminates the costs and complexities of planning, purchasing, and maintaining hardware.',
                    'easy', 'approved'),
                $this->q(
                    'What is a Reserved Instance?',
                    [
                        $this->correct('A pricing model that provides a significant discount for a 1 or 3-year commitment'),
                        $this->wrong('An EC2 instance that cannot be terminated'),
                        $this->wrong('An instance reserved for emergency use'),
                        $this->wrong('A backup instance for disaster recovery'),
                    ],
                    'Reserved Instances provide you with a significant discount (up to 75%) compared to On-Demand instance pricing. You commit to using EC2 for a one or three-year term in exchange for the discount.',
                    'medium', 'approved'),
                $this->q(
                    'Which AWS pricing model offers the highest discount?',
                    [
                        $this->correct('Savings Plans (up to 72% discount)'),
                        $this->wrong('On-Demand pricing'),
                        $this->wrong('Free Tier'),
                        $this->wrong('Data transfer pricing'),
                    ],
                    'AWS Savings Plans offer significant savings (up to 72%) on AWS compute usage in exchange for a commitment to a consistent amount of usage (measured in $/hour) for a 1 or 3-year term.',
                    'medium', 'approved'),
                $this->q(
                    'What is the benefit of Consolidated Billing in AWS Organizations?',
                    [
                        $this->correct('Combine usage across multiple accounts to receive volume pricing discounts'),
                        $this->wrong('Automatically pay bills from multiple accounts'),
                        $this->wrong('Split bills equally among all accounts'),
                        $this->wrong('Eliminate all AWS charges'),
                    ],
                    'Consolidated Billing allows you to combine usage from multiple AWS accounts to receive volume pricing discounts. It also provides a single bill for all accounts in your organization.',
                    'medium', 'approved'),
                $this->q(
                    'A company has variable workloads that run continuously but can tolerate interruptions. They want to minimize costs. Which pricing strategy should they use?',
                    [
                        $this->correct('A combination of Reserved Instances for baseline capacity and Spot Instances for variable capacity'),
                        $this->wrong('Only On-Demand Instances'),
                        $this->wrong('Only Reserved Instances'),
                        $this->wrong('Only Spot Instances'),
                    ],
                    'Using Reserved Instances for predictable baseline capacity and Spot Instances for variable, interruptible workloads provides the best cost optimization. This strategy leverages the discounts of both pricing models.',
                    'hard', 'approved'),
            ],

            'Billing and Cost Management Tools' => [
                $this->q(
                    'What is AWS Cost Explorer used for?',
                    [
                        $this->correct('Visualizing and analyzing AWS costs and usage over time'),
                        $this->wrong('Creating AWS budgets'),
                        $this->wrong('Paying AWS bills'),
                        $this->wrong('Estimating future costs'),
                    ],
                    'AWS Cost Explorer is a tool that enables you to view and analyze your costs and usage. You can explore your AWS costs using an interface that lets you break down costs by service, time period, and other dimensions.',
                    'easy', 'approved'),
                $this->q(
                    'What is AWS Budgets used for?',
                    [
                        $this->correct('Setting custom cost and usage budgets with alerts'),
                        $this->wrong('Paying AWS bills automatically'),
                        $this->wrong('Estimating the cost of new services'),
                        $this->wrong('Viewing historical cost data'),
                    ],
                    'AWS Budgets allows you to set custom budgets that alert you when your costs or usage exceed (or are forecasted to exceed) your budgeted amount. You can also use budgets to track your Reserved Instance utilization.',
                    'easy', 'approved'),
                $this->q(
                    'Which tool helps you estimate the cost of AWS services before you use them?',
                    [
                        $this->correct('AWS Pricing Calculator'),
                        $this->wrong('AWS Cost Explorer'),
                        $this->wrong('AWS Budgets'),
                        $this->wrong('AWS Cost and Usage Report'),
                    ],
                    'The AWS Pricing Calculator lets you explore AWS services and create an estimate for the cost of your use cases on AWS. You can model your solutions before building them to understand the potential costs.',
                    'medium', 'approved'),
                $this->q(
                    'What information does the AWS Cost and Usage Report provide?',
                    [
                        $this->correct('Comprehensive cost and usage data with detailed line items'),
                        $this->wrong('Only high-level cost summaries'),
                        $this->wrong('Only usage data without costs'),
                        $this->wrong('Only Reserved Instance recommendations'),
                    ],
                    'The AWS Cost and Usage Report contains the most comprehensive set of cost and usage data available. It includes metadata about AWS services, pricing, and reservations.',
                    'medium', 'approved'),
                $this->q(
                    'Which AWS service can send alerts when billing thresholds are exceeded?',
                    [
                        $this->correct('AWS Budgets with Amazon SNS'),
                        $this->wrong('AWS Cost Explorer'),
                        $this->wrong('AWS Pricing Calculator'),
                        $this->wrong('AWS Trusted Advisor'),
                    ],
                    'AWS Budgets can be configured to send alerts via Amazon SNS when your costs or usage exceed your budgeted thresholds. This helps you stay informed and take action before costs spiral.',
                    'medium', 'approved'),
                $this->q(
                    'A company wants to analyze their AWS costs by project and department. What should they use?',
                    [
                        $this->correct('Cost allocation tags with AWS Cost Explorer'),
                        $this->wrong('AWS Budgets only'),
                        $this->wrong('AWS Pricing Calculator'),
                        $this->wrong('AWS CloudTrail'),
                    ],
                    'Cost allocation tags allow you to organize your resources and track AWS costs on a detailed level. When combined with Cost Explorer, you can analyze costs by custom categories like project, department, or environment.',
                    'hard', 'approved'),
            ],

            'AWS Support Plans' => [
                $this->q(
                    'Which AWS Support plan provides 24/7 access to customer service?',
                    [
                        $this->correct('All support plans (Basic, Developer, Business, Enterprise)'),
                        $this->wrong('Only Business and Enterprise'),
                        $this->wrong('Only Enterprise'),
                        $this->wrong('None of the support plans'),
                    ],
                    'All AWS Support plans, including the free Basic Support plan, provide 24/7 access to customer service, documentation, whitepapers, and support forums.',
                    'easy', 'approved'),
                $this->q(
                    'Which AWS Support plan includes access to AWS Trusted Advisor best practice checks?',
                    [
                        $this->correct('Business and Enterprise Support plans'),
                        $this->wrong('Basic Support plan'),
                        $this->wrong('Developer Support plan'),
                        $this->wrong('All support plans'),
                    ],
                    'Business and Enterprise Support plans include access to the full set of Trusted Advisor checks. Basic and Developer plans have access to only a limited set of core checks.',
                    'easy', 'approved'),
                $this->q(
                    'What is the response time for critical system down issues with Business Support?',
                    [
                        $this->correct('Less than 1 hour'),
                        $this->wrong('Less than 15 minutes'),
                        $this->wrong('Less than 4 hours'),
                        $this->wrong('Less than 12 hours'),
                    ],
                    'Business Support provides a response time of less than 1 hour for production system down cases. Enterprise Support provides less than 15 minutes for business-critical system down.',
                    'medium', 'approved'),
                $this->q(
                    'Which AWS Support plan includes a Technical Account Manager (TAM)?',
                    [
                        $this->correct('Enterprise Support'),
                        $this->wrong('Business Support'),
                        $this->wrong('Developer Support'),
                        $this->wrong('Basic Support'),
                    ],
                    'Only the Enterprise Support plan includes a designated Technical Account Manager (TAM) who provides consultative architectural and operational guidance.',
                    'medium', 'approved'),
                $this->q(
                    'What is included in the AWS Basic Support plan?',
                    [
                        $this->correct('24/7 customer service, documentation, whitepapers, and support forums'),
                        $this->wrong('Unlimited technical support cases'),
                        $this->wrong('Access to all Trusted Advisor checks'),
                        $this->wrong('Dedicated Technical Account Manager'),
                    ],
                    'Basic Support is included for all AWS customers at no additional charge. It includes 24/7 access to customer service, documentation, whitepapers, support forums, AWS Personal Health Dashboard, and limited Trusted Advisor checks.',
                    'medium', 'approved'),
                $this->q(
                    'A startup company needs architectural guidance and wants to ensure production issues are resolved quickly. Which support plan should they choose?',
                    [
                        $this->correct('Business Support'),
                        $this->wrong('Basic Support'),
                        $this->wrong('Developer Support'),
                        $this->wrong('Enterprise Support'),
                    ],
                    'Business Support is ideal for production workloads. It provides 24/7 technical support, architectural guidance, full Trusted Advisor access, and fast response times for production issues, making it suitable for growing companies.',
                    'hard', 'approved'),
            ],

            'AWS Marketplace and Partner Network' => [
                $this->q(
                    'What is AWS Marketplace?',
                    [
                        $this->correct('A digital catalog of third-party software and services that run on AWS'),
                        $this->wrong('A physical store for AWS hardware'),
                        $this->wrong('A job board for AWS professionals'),
                        $this->wrong('A forum for AWS users'),
                    ],
                    'AWS Marketplace is a curated digital catalog that makes it easy to find, test, buy, and deploy software that runs on AWS. It includes thousands of software listings from independent software vendors.',
                    'easy', 'approved'),
                $this->q(
                    'What is the AWS Partner Network (APN)?',
                    [
                        $this->correct('A global community of partners who leverage AWS to build solutions and services'),
                        $this->wrong('A networking service for connecting VPCs'),
                        $this->wrong('A marketplace for buying AWS services'),
                        $this->wrong('A support plan for enterprise customers'),
                    ],
                    'The AWS Partner Network (APN) is a global partner program for technology and consulting businesses that leverage AWS to build solutions and services for customers.',
                    'easy', 'approved'),
                $this->q(
                    'What type of partners are part of the AWS Partner Network?',
                    [
                        $this->correct('Consulting Partners and Technology Partners'),
                        $this->wrong('Only hardware vendors'),
                        $this->wrong('Only training providers'),
                        $this->wrong('Only managed service providers'),
                    ],
                    'The APN includes Consulting Partners (professional services firms) and Technology Partners (independent software vendors) who help customers build, market, and sell their AWS-based solutions.',
                    'medium', 'approved'),
                $this->q(
                    'What is a benefit of using AWS Marketplace?',
                    [
                        $this->correct('Simplified procurement and deployment of third-party software'),
                        $this->wrong('Free software licenses'),
                        $this->wrong('Guaranteed software performance'),
                        $this->wrong('Unlimited technical support'),
                    ],
                    'AWS Marketplace simplifies software licensing and procurement. You can quickly launch pre-configured software with just a few clicks, and billing is consolidated with your AWS bill.',
                    'medium', 'approved'),
                $this->q(
                    'Which AWS Marketplace pricing model allows you to pay only for what you use?',
                    [
                        $this->correct('Usage-based pricing'),
                        $this->wrong('Perpetual license'),
                        $this->wrong('One-time purchase'),
                        $this->wrong('Annual subscription only'),
                    ],
                    'AWS Marketplace offers various pricing models including usage-based pricing (pay-as-you-go), which allows you to pay only for the resources you consume, similar to AWS service pricing.',
                    'medium', 'approved'),
                $this->q(
                    'A company needs help migrating their on-premises applications to AWS. What type of APN partner should they engage?',
                    [
                        $this->correct('APN Consulting Partner with migration expertise'),
                        $this->wrong('APN Technology Partner'),
                        $this->wrong('AWS Marketplace vendor'),
                        $this->wrong('AWS Support team only'),
                    ],
                    'APN Consulting Partners provide professional services including migration, implementation, and managed services. They have the expertise and AWS certifications to help with complex migration projects.',
                    'hard', 'approved'),
            ],
        ];
    }
}

