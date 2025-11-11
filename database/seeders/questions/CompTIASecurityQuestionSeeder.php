<?php

namespace Database\Seeders\Questions;

class CompTIASecurityQuestionSeeder extends BaseQuestionSeeder
{
    protected function getCertificationSlug(): string
    {
        return 'comptia-security-plus';
    }

    protected function getQuestionsData(): array
    {
        return [
            // Domain 1: Threats, Attacks, and Vulnerabilities
            'Social Engineering' => [
                $this->q(
                    'What is phishing?',
                    [
                        $this->correct('A social engineering attack that uses fraudulent emails to trick users into revealing sensitive information'),
                        $this->wrong('A type of firewall'),
                        $this->wrong('A network protocol'),
                        $this->wrong('An encryption method'),
                    ],
                    'Phishing is a social engineering technique where attackers send fraudulent emails that appear to come from legitimate sources to steal sensitive data.',
                    'easy', 'approved'),
                $this->q(
                    'What is the difference between phishing and spear phishing?',
                    [
                        $this->correct('Spear phishing targets specific individuals while phishing targets many people'),
                        $this->wrong('They are the same thing'),
                        $this->wrong('Phishing is more targeted than spear phishing'),
                        $this->wrong('Spear phishing uses phone calls only'),
                    ],
                    'Spear phishing is a targeted attack aimed at specific individuals or organizations, while phishing is a broad attack sent to many recipients.',
                    'medium', 'approved'),
                $this->q(
                    'What is pretexting?',
                    [
                        $this->correct('Creating a fabricated scenario to obtain information from a target'),
                        $this->wrong('Installing malware on a system'),
                        $this->wrong('Scanning networks for vulnerabilities'),
                        $this->wrong('Encrypting sensitive data'),
                    ],
                    'Pretexting involves creating a false scenario (pretext) to manipulate victims into divulging information or performing actions they normally wouldn\'t.',
                    'medium', 'approved'),
            ],

            'Malware Types' => [
                $this->q(
                    'What is ransomware?',
                    [
                        $this->correct('Malware that encrypts files and demands payment for decryption'),
                        $this->wrong('Software that removes viruses'),
                        $this->wrong('A type of firewall'),
                        $this->wrong('An encryption algorithm'),
                    ],
                    'Ransomware is malicious software that encrypts a victim\'s files and demands payment (ransom) to restore access.',
                    'easy', 'approved'),
                $this->q(
                    'What is a trojan horse?',
                    [
                        $this->correct('Malware disguised as legitimate software'),
                        $this->wrong('A self-replicating virus'),
                        $this->wrong('A network scanning tool'),
                        $this->wrong('An encryption method'),
                    ],
                    'A trojan horse is malware that disguises itself as legitimate software to trick users into installing it.',
                    'easy', 'approved'),
                $this->q(
                    'What distinguishes a worm from a virus?',
                    [
                        $this->correct('A worm can self-replicate and spread without human interaction'),
                        $this->wrong('A worm requires user action to spread'),
                        $this->wrong('A virus spreads faster than a worm'),
                        $this->wrong('They are exactly the same'),
                    ],
                    'Unlike viruses that require user action to spread, worms can self-replicate and spread automatically across networks without human interaction.',
                    'medium', 'approved'),
            ],

            'Attack Types' => [
                $this->q(
                    'What is a DDoS attack?',
                    [
                        $this->correct('An attack that overwhelms a system with traffic from multiple sources'),
                        $this->wrong('An attack that steals passwords'),
                        $this->wrong('An attack that encrypts files'),
                        $this->wrong('An attack that installs malware'),
                    ],
                    'A Distributed Denial of Service (DDoS) attack uses multiple compromised systems to flood a target with traffic, making it unavailable to legitimate users.',
                    'easy', 'approved'),
                $this->q(
                    'What is SQL injection?',
                    [
                        $this->correct('An attack that inserts malicious SQL code into application queries'),
                        $this->wrong('A method to optimize database performance'),
                        $this->wrong('A type of encryption'),
                        $this->wrong('A network protocol'),
                    ],
                    'SQL injection is a code injection technique that exploits vulnerabilities in an application\'s database layer by inserting malicious SQL statements.',
                    'medium', 'approved'),
                $this->q(
                    'What is a man-in-the-middle (MITM) attack?',
                    [
                        $this->correct('An attack where the attacker intercepts communication between two parties'),
                        $this->wrong('An attack that deletes files'),
                        $this->wrong('An attack that creates fake websites'),
                        $this->wrong('An attack that disables firewalls'),
                    ],
                    'In a MITM attack, the attacker secretly intercepts and possibly alters communication between two parties who believe they are directly communicating.',
                    'medium', 'approved'),
            ],

            'Vulnerability Assessment' => [
                $this->q(
                    'What is vulnerability scanning?',
                    [
                        $this->correct('An automated process to identify security weaknesses in systems'),
                        $this->wrong('A manual review of source code'),
                        $this->wrong('Installing security patches'),
                        $this->wrong('Creating firewall rules'),
                    ],
                    'Vulnerability scanning is an automated process that identifies security weaknesses in systems, applications, and networks.',
                    'easy', 'approved'),
                $this->q(
                    'What is penetration testing?',
                    [
                        $this->correct('Simulated cyber attacks to identify exploitable vulnerabilities'),
                        $this->wrong('Installing antivirus software'),
                        $this->wrong('Creating backups'),
                        $this->wrong('Monitoring network traffic'),
                    ],
                    'Penetration testing (pen testing) involves authorized simulated cyber attacks to evaluate the security of a system.',
                    'easy', 'approved'),
                $this->q(
                    'What is the Common Vulnerability Scoring System (CVSS)?',
                    [
                        $this->correct('A standardized method for rating the severity of security vulnerabilities'),
                        $this->wrong('A type of firewall'),
                        $this->wrong('An encryption standard'),
                        $this->wrong('A network protocol'),
                    ],
                    'CVSS provides a standardized way to measure and communicate the severity of software vulnerabilities using a score from 0 to 10.',
                    'medium', 'approved'),
            ],

            // Domain 2: Architecture and Design
            'Security Frameworks' => [
                $this->q(
                    'What is defense in depth?',
                    [
                        $this->correct('A layered security approach using multiple defensive measures'),
                        $this->wrong('Using only one strong firewall'),
                        $this->wrong('Relying solely on antivirus software'),
                        $this->wrong('Disabling all network access'),
                    ],
                    'Defense in depth is a security strategy that uses multiple layers of security controls to protect resources, ensuring that if one layer fails, others remain.',
                    'medium', 'approved'),
                $this->q(
                    'What is the principle of least privilege?',
                    [
                        $this->correct('Users should have only the minimum access rights needed to perform their job'),
                        $this->wrong('All users should have administrator access'),
                        $this->wrong('Users should have no access to any systems'),
                        $this->wrong('Only managers should have access'),
                    ],
                    'The principle of least privilege states that users should be granted only the minimum levels of access necessary to perform their job functions.',
                    'easy', 'approved'),
                $this->q(
                    'What is zero trust security?',
                    [
                        $this->correct('A security model that assumes no user or system should be trusted by default'),
                        $this->wrong('A security model that trusts all internal users'),
                        $this->wrong('A type of encryption'),
                        $this->wrong('A firewall configuration'),
                    ],
                    'Zero trust is a security model based on the principle of "never trust, always verify," requiring strict identity verification for every person and device.',
                    'medium', 'approved'),
            ],

            'Network Security Design' => [
                $this->q(
                    'What is network segmentation?',
                    [
                        $this->correct('Dividing a network into smaller segments to improve security and performance'),
                        $this->wrong('Connecting all devices to one network'),
                        $this->wrong('Removing all firewalls'),
                        $this->wrong('Disabling network access'),
                    ],
                    'Network segmentation divides a network into multiple segments or subnets, each acting as its own small network, improving security and performance.',
                    'easy', 'approved'),
                $this->q(
                    'What is a DMZ (Demilitarized Zone)?',
                    [
                        $this->correct('A network segment that sits between the internal network and the internet'),
                        $this->wrong('A type of firewall'),
                        $this->wrong('An encryption protocol'),
                        $this->wrong('A wireless network'),
                    ],
                    'A DMZ is a physical or logical subnet that separates an internal network from untrusted networks, typically hosting public-facing services.',
                    'medium', 'approved'),
                $this->q(
                    'What is the purpose of a VPN?',
                    [
                        $this->correct('To create a secure, encrypted connection over a less secure network'),
                        $this->wrong('To speed up internet connections'),
                        $this->wrong('To block all network traffic'),
                        $this->wrong('To scan for viruses'),
                    ],
                    'A Virtual Private Network (VPN) creates a secure, encrypted tunnel for data transmission over public networks like the internet.',
                    'easy', 'approved'),
            ],

            'Cryptography Concepts' => [
                $this->q(
                    'What is symmetric encryption?',
                    [
                        $this->correct('Encryption that uses the same key for both encryption and decryption'),
                        $this->wrong('Encryption that uses different keys for encryption and decryption'),
                        $this->wrong('Encryption that doesn\'t use keys'),
                        $this->wrong('Encryption that only works on text'),
                    ],
                    'Symmetric encryption uses the same key for both encrypting and decrypting data. Examples include AES and DES.',
                    'easy', 'approved'),
                $this->q(
                    'What is asymmetric encryption?',
                    [
                        $this->correct('Encryption that uses a public key for encryption and a private key for decryption'),
                        $this->wrong('Encryption that uses the same key for both operations'),
                        $this->wrong('Encryption without keys'),
                        $this->wrong('Encryption that only works on images'),
                    ],
                    'Asymmetric encryption uses a pair of keys: a public key for encryption and a private key for decryption. Examples include RSA and ECC.',
                    'medium', 'approved'),
                $this->q(
                    'What is hashing?',
                    [
                        $this->correct('A one-way function that converts data into a fixed-size string'),
                        $this->wrong('A two-way encryption method'),
                        $this->wrong('A method to compress files'),
                        $this->wrong('A network protocol'),
                    ],
                    'Hashing is a one-way cryptographic function that converts data of any size into a fixed-size hash value. It cannot be reversed to obtain the original data.',
                    'medium', 'approved'),
            ],

            // Domain 3: Implementation
            'Access Control' => [
                $this->q(
                    'What is Multi-Factor Authentication (MFA)?',
                    [
                        $this->correct('Authentication that requires two or more verification factors'),
                        $this->wrong('Using only a password'),
                        $this->wrong('Using only a fingerprint'),
                        $this->wrong('Not using any authentication'),
                    ],
                    'MFA requires users to provide two or more verification factors (something you know, have, or are) to gain access to a resource.',
                    'easy', 'approved'),
                $this->q(
                    'What are the three authentication factors?',
                    [
                        $this->correct('Something you know, something you have, something you are'),
                        $this->wrong('Username, password, email'),
                        $this->wrong('Firewall, antivirus, encryption'),
                        $this->wrong('Public key, private key, certificate'),
                    ],
                    'The three authentication factors are: something you know (password), something you have (token/phone), and something you are (biometric).',
                    'easy', 'approved'),
                $this->q(
                    'What is Role-Based Access Control (RBAC)?',
                    [
                        $this->correct('Access permissions are assigned based on user roles within an organization'),
                        $this->wrong('All users have the same access'),
                        $this->wrong('Access is granted randomly'),
                        $this->wrong('No access control is used'),
                    ],
                    'RBAC assigns permissions to users based on their role in the organization rather than to individuals directly.',
                    'medium', 'approved'),
            ],

            'Security Technologies' => [
                $this->q(
                    'What is a firewall?',
                    [
                        $this->correct('A network security device that monitors and filters traffic'),
                        $this->wrong('A type of malware'),
                        $this->wrong('An encryption algorithm'),
                        $this->wrong('A backup system'),
                    ],
                    'A firewall is a network security device that monitors and filters incoming and outgoing network traffic based on security rules.',
                    'easy', 'approved'),
                $this->q(
                    'What is an Intrusion Detection System (IDS)?',
                    [
                        $this->correct('A system that monitors network traffic for suspicious activity'),
                        $this->wrong('A system that blocks all network traffic'),
                        $this->wrong('A type of firewall'),
                        $this->wrong('An encryption tool'),
                    ],
                    'An IDS monitors network traffic for suspicious activity and alerts administrators when potential threats are detected.',
                    'easy', 'approved'),
                $this->q(
                    'What is the difference between IDS and IPS?',
                    [
                        $this->correct('IDS detects and alerts, while IPS detects and prevents/blocks threats'),
                        $this->wrong('They are the same thing'),
                        $this->wrong('IPS only alerts, IDS blocks'),
                        $this->wrong('IDS is faster than IPS'),
                    ],
                    'IDS (Intrusion Detection System) detects and alerts on threats, while IPS (Intrusion Prevention System) can detect and actively block threats.',
                    'medium', 'approved'),
            ],

            'Secure Protocols' => [
                $this->q(
                    'What is HTTPS?',
                    [
                        $this->correct('HTTP with SSL/TLS encryption'),
                        $this->wrong('A faster version of HTTP'),
                        $this->wrong('A type of firewall'),
                        $this->wrong('A network protocol without encryption'),
                    ],
                    'HTTPS (HTTP Secure) is HTTP protocol with SSL/TLS encryption to secure communication between web browsers and servers.',
                    'easy', 'approved'),
                $this->q(
                    'What is SSH used for?',
                    [
                        $this->correct('Secure remote access to systems'),
                        $this->wrong('Sending emails'),
                        $this->wrong('Browsing websites'),
                        $this->wrong('Printing documents'),
                    ],
                    'SSH (Secure Shell) is a cryptographic network protocol for secure remote login and command execution on networked systems.',
                    'easy', 'approved'),
                $this->q(
                    'What port does HTTPS use by default?',
                    [
                        $this->correct('443'),
                        $this->wrong('80'),
                        $this->wrong('22'),
                        $this->wrong('3389'),
                    ],
                    'HTTPS uses port 443 by default, while HTTP uses port 80.',
                    'medium', 'approved'),
            ],

            // Domain 4: Operations and Incident Response
            'Incident Response' => [
                $this->q(
                    'What is the first phase of incident response?',
                    [
                        $this->correct('Preparation'),
                        $this->wrong('Containment'),
                        $this->wrong('Eradication'),
                        $this->wrong('Recovery'),
                    ],
                    'The incident response lifecycle starts with Preparation, followed by Detection, Containment, Eradication, Recovery, and Lessons Learned.',
                    'easy', 'approved'),
                $this->q(
                    'What is the purpose of containment in incident response?',
                    [
                        $this->correct('To limit the scope and impact of the incident'),
                        $this->wrong('To delete all evidence'),
                        $this->wrong('To ignore the incident'),
                        $this->wrong('To notify the public immediately'),
                    ],
                    'Containment aims to limit the damage and prevent the incident from spreading while preserving evidence for investigation.',
                    'medium', 'approved'),
                $this->q(
                    'What is a security incident?',
                    [
                        $this->correct('An event that compromises the confidentiality, integrity, or availability of information'),
                        $this->wrong('A scheduled system maintenance'),
                        $this->wrong('A software update'),
                        $this->wrong('A user password change'),
                    ],
                    'A security incident is any event that violates or threatens to violate security policies, including data breaches, malware infections, and unauthorized access.',
                    'easy', 'approved'),
            ],

            'Security Monitoring' => [
                $this->q(
                    'What is SIEM?',
                    [
                        $this->correct('Security Information and Event Management - a system that aggregates and analyzes security data'),
                        $this->wrong('A type of firewall'),
                        $this->wrong('An encryption protocol'),
                        $this->wrong('A backup solution'),
                    ],
                    'SIEM systems collect, aggregate, and analyze security data from across an organization to detect threats and support compliance.',
                    'medium', 'approved'),
                $this->q(
                    'What are security logs used for?',
                    [
                        $this->correct('Recording events for security monitoring, auditing, and forensic analysis'),
                        $this->wrong('Storing user passwords'),
                        $this->wrong('Speeding up systems'),
                        $this->wrong('Encrypting data'),
                    ],
                    'Security logs record system events, user activities, and security-related information for monitoring, auditing, and investigating incidents.',
                    'easy', 'approved'),
            ],

            // Domain 5: Governance, Risk, and Compliance
            'Security Policies' => [
                $this->q(
                    'What is an Acceptable Use Policy (AUP)?',
                    [
                        $this->correct('A policy that defines acceptable ways to use company IT resources'),
                        $this->wrong('A policy about employee vacation time'),
                        $this->wrong('A policy about office hours'),
                        $this->wrong('A policy about parking'),
                    ],
                    'An AUP defines the acceptable ways employees can use company IT resources, including computers, networks, and internet access.',
                    'easy', 'approved'),
                $this->q(
                    'What is a data classification policy?',
                    [
                        $this->correct('A policy that categorizes data based on sensitivity and criticality'),
                        $this->wrong('A policy about file naming conventions'),
                        $this->wrong('A policy about data storage locations'),
                        $this->wrong('A policy about backup schedules'),
                    ],
                    'Data classification policies categorize data based on its sensitivity, value, and criticality to the organization (e.g., public, internal, confidential, restricted).',
                    'medium', 'approved'),
            ],

            'Risk Management' => [
                $this->q(
                    'What is risk assessment?',
                    [
                        $this->correct('The process of identifying, analyzing, and evaluating risks'),
                        $this->wrong('Installing antivirus software'),
                        $this->wrong('Creating backups'),
                        $this->wrong('Updating passwords'),
                    ],
                    'Risk assessment involves identifying potential threats and vulnerabilities, analyzing their likelihood and impact, and evaluating the overall risk to the organization.',
                    'easy', 'approved'),
                $this->q(
                    'What are the four risk response strategies?',
                    [
                        $this->correct('Accept, Avoid, Transfer, Mitigate'),
                        $this->wrong('Stop, Drop, Roll, Run'),
                        $this->wrong('Plan, Do, Check, Act'),
                        $this->wrong('Prevent, Detect, Respond, Recover'),
                    ],
                    'The four main risk response strategies are: Accept (acknowledge the risk), Avoid (eliminate the risk), Transfer (shift the risk to others), and Mitigate (reduce the risk).',
                    'medium', 'approved'),
            ],
        ];
    }
}

