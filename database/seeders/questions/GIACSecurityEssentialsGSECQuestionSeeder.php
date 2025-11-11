<?php

namespace Database\Seeders\Questions;

class GIACSecurityEssentialsGSECQuestionSeeder extends BaseQuestionSeeder
{
    protected function getCertificationSlug(): string
    {
        return 'giac-security-essentials-gsec';
    }

    protected function getQuestionsData(): array
    {
        return [
            'Access Control and Password Management' => [
                $this->q('What is the principle of least privilege?', [$this->correct('Users should have only the minimum access necessary to perform their job'), $this->wrong('All users should have administrator access'), $this->wrong('Users should have no access'), $this->wrong('Only managers should have access')], 'Least privilege minimizes the potential damage from accidents or malicious actions by limiting user permissions.', 'easy', 'approved'),
                $this->q('What makes a strong password?', [$this->correct('Length, complexity, and uniqueness'), $this->wrong('Using common words'), $this->wrong('Reusing the same password'), $this->wrong('Using only numbers')], 'Strong passwords are long (12+ characters), complex (mixed case, numbers, symbols), and unique for each account.', 'easy', 'approved'),
                $this->q('What is multi-factor authentication?', [$this->correct('Authentication using two or more independent factors'), $this->wrong('Using two passwords'), $this->wrong('Using a long password'), $this->wrong('Using biometrics only')], 'MFA combines something you know (password), something you have (token), and/or something you are (biometric).', 'easy', 'approved'),
            ],
            'Cryptography' => [
                $this->q('What is the difference between symmetric and asymmetric encryption?', [$this->correct('Symmetric uses one key, asymmetric uses a key pair'), $this->wrong('They are the same'), $this->wrong('Asymmetric is faster'), $this->wrong('Symmetric uses two keys')], 'Symmetric encryption uses the same key for encryption and decryption (AES), while asymmetric uses public/private key pairs (RSA).', 'medium', 'approved'),
                $this->q('What is a digital signature?', [$this->correct('A cryptographic method to verify authenticity and integrity'), $this->wrong('An electronic copy of a handwritten signature'), $this->wrong('A password'), $this->wrong('An encryption algorithm')], 'Digital signatures use asymmetric cryptography to prove that a message came from a specific sender and hasn\'t been altered.', 'medium', 'approved'),
                $this->q('What is hashing used for?', [$this->correct('Creating a fixed-size fingerprint of data for integrity verification'), $this->wrong('Encrypting data'), $this->wrong('Compressing files'), $this->wrong('Routing network traffic')], 'Hashing creates a unique fixed-size output from input data. Any change to the input produces a different hash, enabling integrity verification.', 'easy', 'approved'),
            ],
            'Network Security' => [
                $this->q('What is the purpose of network segmentation?', [$this->correct('To divide a network into smaller segments for security and performance'), $this->wrong('To combine all networks into one'), $this->wrong('To disable all network access'), $this->wrong('To increase network speed only')], 'Network segmentation limits the blast radius of security incidents and improves performance by reducing broadcast domains.', 'medium', 'approved'),
                $this->q('What is a DMZ?', [$this->correct('A network segment between internal and external networks for public-facing services'), $this->wrong('A type of firewall'), $this->wrong('An encryption protocol'), $this->wrong('A wireless network')], 'The Demilitarized Zone (DMZ) hosts public-facing services while protecting the internal network from direct internet exposure.', 'medium', 'approved'),
                $this->q('What is the difference between stateful and stateless firewalls?', [$this->correct('Stateful tracks connection state, stateless examines each packet independently'), $this->wrong('They are the same'), $this->wrong('Stateless is more secure'), $this->wrong('Stateful is faster')], 'Stateful firewalls track connection state and context, while stateless firewalls examine each packet independently against rules.', 'medium', 'approved'),
            ],
            'Incident Handling' => [
                $this->q('What is an indicator of compromise (IOC)?', [$this->correct('Evidence that a system has been breached'), $this->wrong('A security policy'), $this->wrong('A firewall rule'), $this->wrong('An encryption key')], 'IOCs are artifacts or evidence that indicate a security breach, such as unusual network traffic, file modifications, or malware signatures.', 'easy', 'approved'),
                $this->q('What is the purpose of forensic imaging?', [$this->correct('To create an exact copy of storage media for investigation'), $this->wrong('To delete evidence'), $this->wrong('To repair damaged files'), $this->wrong('To compress data')], 'Forensic imaging creates a bit-by-bit copy of storage media, preserving evidence while allowing analysis on the copy.', 'medium', 'approved'),
                $this->q('What is volatility in digital forensics?', [$this->correct('How quickly data is lost when power is removed'), $this->wrong('How dangerous malware is'), $this->wrong('How often backups are made'), $this->wrong('How fast a network is')], 'Volatile data (RAM, cache) is lost when power is removed, so it must be collected first during incident response.', 'medium', 'approved'),
            ],
            'Defensive Security Operations' => [
                $this->q('What is defense in depth?', [$this->correct('Using multiple layers of security controls'), $this->wrong('Using only one strong firewall'), $this->wrong('Relying on antivirus alone'), $this->wrong('Disabling all network access')], 'Defense in depth uses multiple overlapping security layers so that if one fails, others provide protection.', 'easy', 'approved'),
                $this->q('What is the purpose of security awareness training?', [$this->correct('To educate users about security threats and best practices'), $this->wrong('To install antivirus software'), $this->wrong('To configure firewalls'), $this->wrong('To perform penetration testing')], 'Security awareness training addresses the human element, teaching users to recognize and respond appropriately to security threats.', 'easy', 'approved'),
                $this->q('What is patch management?', [$this->correct('The process of identifying, testing, and deploying software updates'), $this->wrong('Repairing physical hardware'), $this->wrong('Creating backups'), $this->wrong('Monitoring network traffic')], 'Patch management ensures systems are updated with security fixes to address known vulnerabilities.', 'easy', 'approved'),
            ],
        ];
    }
}

