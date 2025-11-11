<?php

namespace Database\Seeders\Questions;

class GoogleCloudDigitalLeaderQuestionSeeder extends BaseQuestionSeeder
{
    protected function getCertificationSlug(): string
    {
        return 'google-cloud-digital-leader';
    }

    protected function getQuestionsData(): array
    {
        return [
            // Domain 1: Digital Transformation with Google Cloud
            'Cloud Transformation Benefits' => [
                $this->q(
                    'What is digital transformation?',
                    [
                        $this->correct('Using technology to create new or modify existing business processes and customer experiences'),
                        $this->wrong('Moving all data to the cloud'),
                        $this->wrong('Replacing all employees with AI'),
                        $this->wrong('Buying new computers for the office'),
                    ],
                    'Digital transformation involves using technology to fundamentally change how businesses operate and deliver value to customers.',
                    'easy', 'approved'),
                $this->q(
                    'Which Google Cloud benefit helps organizations innovate faster?',
                    [
                        $this->correct('Access to cutting-edge technologies like AI and ML'),
                        $this->wrong('Cheaper hardware'),
                        $this->wrong('Fewer employees needed'),
                        $this->wrong('Slower deployment times'),
                    ],
                    'Google Cloud provides access to advanced technologies like AI, machine learning, and data analytics that enable faster innovation.',
                    'easy', 'approved'),
                $this->q(
                    'What is the primary advantage of cloud computing for scalability?',
                    [
                        $this->correct('Resources can be scaled up or down based on demand'),
                        $this->wrong('You must purchase servers in advance'),
                        $this->wrong('Scaling requires physical hardware installation'),
                        $this->wrong('Scaling is not possible in the cloud'),
                    ],
                    'Cloud computing allows organizations to scale resources dynamically based on actual demand, optimizing costs and performance.',
                    'medium', 'approved'),
            ],

            'Infrastructure Modernization' => [
                $this->q(
                    'What is infrastructure modernization?',
                    [
                        $this->correct('Updating legacy systems to cloud-native architectures'),
                        $this->wrong('Buying new office furniture'),
                        $this->wrong('Hiring more IT staff'),
                        $this->wrong('Installing faster internet'),
                    ],
                    'Infrastructure modernization involves migrating from legacy on-premises systems to modern cloud-based infrastructure.',
                    'easy', 'approved'),
                $this->q(
                    'Which Google Cloud service helps migrate virtual machines to the cloud?',
                    [
                        $this->correct('Migrate for Compute Engine'),
                        $this->wrong('Cloud Storage'),
                        $this->wrong('BigQuery'),
                        $this->wrong('Cloud Functions'),
                    ],
                    'Migrate for Compute Engine (formerly Velostrata) enables organizations to migrate and run virtual machines on Google Cloud.',
                    'medium', 'approved'),
                $this->q(
                    'What is a hybrid cloud approach?',
                    [
                        $this->correct('Combining on-premises infrastructure with cloud services'),
                        $this->wrong('Using only public cloud'),
                        $this->wrong('Using only private cloud'),
                        $this->wrong('Avoiding cloud entirely'),
                    ],
                    'Hybrid cloud combines on-premises infrastructure with public cloud services, allowing workloads to move between them as needs change.',
                    'medium', 'approved'),
            ],

            'Data-Driven Innovation' => [
                $this->q(
                    'What is the main purpose of data analytics in business?',
                    [
                        $this->correct('To gain insights and make informed decisions'),
                        $this->wrong('To store more data'),
                        $this->wrong('To delete old information'),
                        $this->wrong('To slow down operations'),
                    ],
                    'Data analytics helps organizations extract valuable insights from data to make better, data-driven business decisions.',
                    'easy', 'approved'),
                $this->q(
                    'Which Google Cloud service is designed for big data analytics?',
                    [
                        $this->correct('BigQuery'),
                        $this->wrong('Compute Engine'),
                        $this->wrong('Cloud Storage'),
                        $this->wrong('Cloud DNS'),
                    ],
                    'BigQuery is Google Cloud\'s serverless, highly scalable data warehouse designed for big data analytics using SQL.',
                    'easy', 'approved'),
                $this->q(
                    'What is machine learning?',
                    [
                        $this->correct('A type of AI that enables systems to learn from data without explicit programming'),
                        $this->wrong('A manual data entry process'),
                        $this->wrong('A type of physical machine'),
                        $this->wrong('A programming language'),
                    ],
                    'Machine learning is a subset of AI that enables systems to automatically learn and improve from experience without being explicitly programmed.',
                    'medium', 'approved'),
            ],

            'Collaboration and Productivity' => [
                $this->q(
                    'Which Google Workspace tool is used for video conferencing?',
                    [
                        $this->correct('Google Meet'),
                        $this->wrong('Google Docs'),
                        $this->wrong('Google Sheets'),
                        $this->wrong('Google Drive'),
                    ],
                    'Google Meet is Google Workspace\'s video conferencing tool for virtual meetings and collaboration.',
                    'easy', 'approved'),
                $this->q(
                    'What is the benefit of real-time collaboration in Google Workspace?',
                    [
                        $this->correct('Multiple users can work on the same document simultaneously'),
                        $this->wrong('Documents can only be edited by one person at a time'),
                        $this->wrong('Changes are saved monthly'),
                        $this->wrong('Collaboration is not supported'),
                    ],
                    'Google Workspace enables real-time collaboration where multiple users can edit documents, spreadsheets, and presentations simultaneously.',
                    'easy', 'approved'),
                $this->q(
                    'Which Google Workspace feature helps organize and find emails efficiently?',
                    [
                        $this->correct('Gmail labels and search'),
                        $this->wrong('Google Calendar'),
                        $this->wrong('Google Slides'),
                        $this->wrong('Google Forms'),
                    ],
                    'Gmail provides powerful labeling and search capabilities to help users organize and quickly find emails.',
                    'medium', 'approved'),
            ],

            // Domain 2: Google Cloud Products and Services
            'Compute Services' => [
                $this->q(
                    'What is Google Compute Engine?',
                    [
                        $this->correct('A service that provides virtual machines running in Google\'s data centers'),
                        $this->wrong('A physical server you own'),
                        $this->wrong('A database service'),
                        $this->wrong('A storage service'),
                    ],
                    'Compute Engine is Google Cloud\'s Infrastructure as a Service (IaaS) that provides virtual machines.',
                    'easy', 'approved'),
                $this->q(
                    'Which Google Cloud service is best for running containerized applications?',
                    [
                        $this->correct('Google Kubernetes Engine (GKE)'),
                        $this->wrong('Compute Engine'),
                        $this->wrong('Cloud Storage'),
                        $this->wrong('BigQuery'),
                    ],
                    'Google Kubernetes Engine (GKE) is a managed Kubernetes service for deploying, managing, and scaling containerized applications.',
                    'medium', 'approved'),
                $this->q(
                    'What is Cloud Run?',
                    [
                        $this->correct('A serverless platform for running containerized applications'),
                        $this->wrong('A virtual machine service'),
                        $this->wrong('A database service'),
                        $this->wrong('A storage service'),
                    ],
                    'Cloud Run is a fully managed serverless platform that automatically scales your containerized applications.',
                    'medium', 'approved'),
            ],

            'Storage Services' => [
                $this->q(
                    'Which Google Cloud storage option is best for unstructured data like images and videos?',
                    [
                        $this->correct('Cloud Storage'),
                        $this->wrong('Cloud SQL'),
                        $this->wrong('Bigtable'),
                        $this->wrong('Spanner'),
                    ],
                    'Cloud Storage is object storage ideal for unstructured data like images, videos, and backups.',
                    'easy', 'approved'),
                $this->q(
                    'What are the Cloud Storage classes?',
                    [
                        $this->correct('Standard, Nearline, Coldline, and Archive'),
                        $this->wrong('Fast, Medium, Slow'),
                        $this->wrong('Hot, Warm, Cold'),
                        $this->wrong('Primary, Secondary, Tertiary'),
                    ],
                    'Cloud Storage offers four storage classes: Standard (frequent access), Nearline (monthly access), Coldline (quarterly access), and Archive (yearly access).',
                    'medium', 'approved'),
                $this->q(
                    'Which storage class is most cost-effective for data accessed less than once a year?',
                    [
                        $this->correct('Archive'),
                        $this->wrong('Standard'),
                        $this->wrong('Nearline'),
                        $this->wrong('Coldline'),
                    ],
                    'Archive storage class is the most cost-effective option for data that is accessed less than once a year.',
                    'easy', 'approved'),
            ],

            'Database Services' => [
                $this->q(
                    'Which Google Cloud database is best for traditional relational workloads?',
                    [
                        $this->correct('Cloud SQL'),
                        $this->wrong('Firestore'),
                        $this->wrong('Bigtable'),
                        $this->wrong('Cloud Storage'),
                    ],
                    'Cloud SQL is a fully managed relational database service for MySQL, PostgreSQL, and SQL Server.',
                    'easy', 'approved'),
                $this->q(
                    'What is Cloud Spanner?',
                    [
                        $this->correct('A globally distributed, horizontally scalable relational database'),
                        $this->wrong('A NoSQL document database'),
                        $this->wrong('An object storage service'),
                        $this->wrong('A data warehouse'),
                    ],
                    'Cloud Spanner is a fully managed, globally distributed relational database that combines the benefits of relational structure with non-relational horizontal scale.',
                    'medium', 'approved'),
                $this->q(
                    'Which database is designed for mobile and web app development with real-time synchronization?',
                    [
                        $this->correct('Firestore'),
                        $this->wrong('Cloud SQL'),
                        $this->wrong('Bigtable'),
                        $this->wrong('Spanner'),
                    ],
                    'Firestore is a NoSQL document database built for automatic scaling, high performance, and ease of application development with real-time synchronization.',
                    'medium', 'approved'),
            ],

            'Networking Services' => [
                $this->q(
                    'What is a Virtual Private Cloud (VPC)?',
                    [
                        $this->correct('A private network within Google Cloud'),
                        $this->wrong('A physical data center'),
                        $this->wrong('A type of virtual machine'),
                        $this->wrong('A storage bucket'),
                    ],
                    'A VPC is a virtual version of a physical network implemented inside Google\'s production network.',
                    'easy', 'approved'),
                $this->q(
                    'Which service distributes incoming traffic across multiple instances?',
                    [
                        $this->correct('Cloud Load Balancing'),
                        $this->wrong('Cloud DNS'),
                        $this->wrong('Cloud CDN'),
                        $this->wrong('Cloud VPN'),
                    ],
                    'Cloud Load Balancing distributes user traffic across multiple instances of your application to ensure high availability and performance.',
                    'easy', 'approved'),
                $this->q(
                    'What is Cloud CDN?',
                    [
                        $this->correct('A content delivery network that caches content closer to users'),
                        $this->wrong('A database service'),
                        $this->wrong('A compute service'),
                        $this->wrong('A monitoring service'),
                    ],
                    'Cloud CDN (Content Delivery Network) uses Google\'s globally distributed edge points to cache content close to users for faster delivery.',
                    'medium', 'approved'),
            ],

            // Domain 3: Security and Compliance
            'Identity and Access Management' => [
                $this->q(
                    'What is the principle of least privilege?',
                    [
                        $this->correct('Users should have only the minimum permissions needed to perform their job'),
                        $this->wrong('All users should have administrator access'),
                        $this->wrong('Users should have no permissions'),
                        $this->wrong('Permissions don\'t matter'),
                    ],
                    'The principle of least privilege states that users should be granted only the minimum permissions necessary to perform their job functions.',
                    'easy', 'approved'),
                $this->q(
                    'What is Cloud IAM?',
                    [
                        $this->correct('A service for managing access control to Google Cloud resources'),
                        $this->wrong('A storage service'),
                        $this->wrong('A compute service'),
                        $this->wrong('A database service'),
                    ],
                    'Cloud Identity and Access Management (IAM) lets you manage access control by defining who (identity) has what access (role) for which resource.',
                    'easy', 'approved'),
                $this->q(
                    'What are the three parts of an IAM policy?',
                    [
                        $this->correct('Who, can do what, on which resource'),
                        $this->wrong('Name, type, location'),
                        $this->wrong('User, password, token'),
                        $this->wrong('Project, zone, region'),
                    ],
                    'IAM policies consist of three parts: identity (who), role (can do what), and resource (on which resource).',
                    'medium', 'approved'),
            ],

            'Data Security' => [
                $this->q(
                    'What is encryption at rest?',
                    [
                        $this->correct('Encrypting data when it is stored on disk'),
                        $this->wrong('Encrypting data while it is being transmitted'),
                        $this->wrong('Not encrypting data at all'),
                        $this->wrong('Encrypting only passwords'),
                    ],
                    'Encryption at rest protects data stored on disk by encrypting it, ensuring it cannot be read if the physical media is compromised.',
                    'easy', 'approved'),
                $this->q(
                    'What is encryption in transit?',
                    [
                        $this->correct('Encrypting data as it travels over a network'),
                        $this->wrong('Encrypting data when stored'),
                        $this->wrong('Not encrypting data'),
                        $this->wrong('Encrypting only during backups'),
                    ],
                    'Encryption in transit protects data as it travels between systems, typically using TLS/SSL protocols.',
                    'easy', 'approved'),
                $this->q(
                    'Does Google Cloud encrypt customer data at rest by default?',
                    [
                        $this->correct('Yes, all data is encrypted at rest by default'),
                        $this->wrong('No, you must enable it manually'),
                        $this->wrong('Only for premium customers'),
                        $this->wrong('Encryption is not supported'),
                    ],
                    'Google Cloud automatically encrypts all customer data at rest without any action required from the customer.',
                    'medium', 'approved'),
            ],

            'Compliance' => [
                $this->q(
                    'What is compliance in cloud computing?',
                    [
                        $this->correct('Meeting regulatory and industry standards for data protection and privacy'),
                        $this->wrong('Following company dress code'),
                        $this->wrong('Using only Google products'),
                        $this->wrong('Avoiding cloud services'),
                    ],
                    'Compliance refers to adhering to laws, regulations, and industry standards related to data protection, privacy, and security.',
                    'easy', 'approved'),
                $this->q(
                    'Which regulation focuses on protecting EU citizens\' personal data?',
                    [
                        $this->correct('GDPR (General Data Protection Regulation)'),
                        $this->wrong('HIPAA'),
                        $this->wrong('SOC 2'),
                        $this->wrong('PCI DSS'),
                    ],
                    'GDPR is a European Union regulation that governs data protection and privacy for individuals within the EU.',
                    'medium', 'approved'),
            ],

            // Domain 4: Cost Management
            'Cloud Pricing Models' => [
                $this->q(
                    'What is the pay-as-you-go pricing model?',
                    [
                        $this->correct('You pay only for the resources you actually use'),
                        $this->wrong('You pay a fixed monthly fee regardless of usage'),
                        $this->wrong('You pay upfront for a year'),
                        $this->wrong('Services are free'),
                    ],
                    'Pay-as-you-go means you pay only for the compute resources you consume, with no upfront costs or long-term commitments.',
                    'easy', 'approved'),
                $this->q(
                    'What are Committed Use Discounts?',
                    [
                        $this->correct('Discounted prices in exchange for committing to use resources for 1 or 3 years'),
                        $this->wrong('Free services for loyal customers'),
                        $this->wrong('Temporary promotional pricing'),
                        $this->wrong('Discounts for government agencies only'),
                    ],
                    'Committed Use Discounts provide discounted prices in exchange for your commitment to use a minimum level of resources for a specified term.',
                    'medium', 'approved'),
                $this->q(
                    'What is the Total Cost of Ownership (TCO)?',
                    [
                        $this->correct('The complete cost of owning and operating technology including all direct and indirect costs'),
                        $this->wrong('Only the purchase price of hardware'),
                        $this->wrong('Only monthly cloud bills'),
                        $this->wrong('Only employee salaries'),
                    ],
                    'TCO includes all costs associated with owning and operating technology: purchase, installation, operation, maintenance, and disposal.',
                    'medium', 'approved'),
            ],

            'Cost Optimization' => [
                $this->q(
                    'Which tool helps you monitor and control Google Cloud spending?',
                    [
                        $this->correct('Cloud Billing'),
                        $this->wrong('Cloud Storage'),
                        $this->wrong('Compute Engine'),
                        $this->wrong('BigQuery'),
                    ],
                    'Cloud Billing provides tools to track, manage, and optimize your Google Cloud costs.',
                    'easy', 'approved'),
                $this->q(
                    'What are sustained use discounts?',
                    [
                        $this->correct('Automatic discounts for running Compute Engine resources for a significant portion of the month'),
                        $this->wrong('Discounts for new customers only'),
                        $this->wrong('Discounts for using multiple services'),
                        $this->wrong('Discounts for paying annually'),
                    ],
                    'Sustained use discounts are automatic discounts you get for running Compute Engine resources for a significant portion of the billing month.',
                    'medium', 'approved'),
            ],
        ];
    }
}

