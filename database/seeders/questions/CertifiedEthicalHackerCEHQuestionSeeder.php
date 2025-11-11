<?php

namespace Database\Seeders\Questions;

class CertifiedEthicalHackerCEHQuestionSeeder extends BaseQuestionSeeder
{
    protected function getCertificationSlug(): string
    {
        return 'certified-ethical-hacker-ceh';
    }

    protected function getQuestionsData(): array
    {
        return [
            'Introduction to Ethical Hacking' => [
                $this->q('What is the difference between white hat and black hat hackers?', [$this->correct('White hats have permission and work legally, black hats are malicious'), $this->wrong('They are the same'), $this->wrong('Black hats are more skilled'), $this->wrong('White hats work alone')], 'White hat hackers (ethical hackers) have authorization and work to improve security, while black hats are malicious actors.', 'easy', 'approved'),
                $this->q('What are the five phases of ethical hacking?', [$this->correct('Reconnaissance, Scanning, Gaining Access, Maintaining Access, Covering Tracks'), $this->wrong('Planning, Testing, Reporting, Fixing, Retesting'), $this->wrong('Install, Configure, Test, Deploy, Monitor'), $this->wrong('Detect, Analyze, Contain, Eradicate, Recover')], 'The hacking methodology follows: Reconnaissance (info gathering), Scanning (identifying targets), Gaining Access (exploitation), Maintaining Access (persistence), Covering Tracks.', 'medium', 'approved'),
                $this->q('What is the purpose of a penetration test?', [$this->correct('To identify security vulnerabilities through authorized simulated attacks'), $this->wrong('To install malware'), $this->wrong('To steal data'), $this->wrong('To disable systems')], 'Penetration testing simulates real attacks with authorization to identify and fix vulnerabilities before malicious actors exploit them.', 'easy', 'approved'),
            ],
            'Footprinting and Reconnaissance' => [
                $this->q('What is passive reconnaissance?', [$this->correct('Gathering information without directly interacting with the target'), $this->wrong('Scanning the target network'), $this->wrong('Exploiting vulnerabilities'), $this->wrong('Installing backdoors')], 'Passive reconnaissance uses publicly available information (WHOIS, social media, search engines) without directly touching the target.', 'medium', 'approved'),
                $this->q('What is WHOIS used for?', [$this->correct('To query domain registration information'), $this->wrong('To scan for open ports'), $this->wrong('To exploit vulnerabilities'), $this->wrong('To crack passwords')], 'WHOIS provides domain registration details including registrant information, name servers, and registration dates.', 'easy', 'approved'),
                $this->q('What is Google dorking?', [$this->correct('Using advanced Google search operators to find sensitive information'), $this->wrong('A type of malware'), $this->wrong('A hacking tool'), $this->wrong('An encryption method')], 'Google dorking uses advanced search operators (site:, filetype:, inurl:) to find sensitive information indexed by search engines.', 'medium', 'approved'),
            ],
            'Scanning and Enumeration' => [
                $this->q('What is the purpose of port scanning?', [$this->correct('To identify open ports and services on a target system'), $this->wrong('To crack passwords'), $this->wrong('To install malware'), $this->wrong('To encrypt data')], 'Port scanning identifies which ports are open, helping attackers (or security professionals) understand what services are running.', 'easy', 'approved'),
                $this->q('What is the difference between TCP connect and SYN scan?', [$this->correct('TCP connect completes the handshake, SYN scan does not'), $this->wrong('They are the same'), $this->wrong('SYN scan is slower'), $this->wrong('TCP connect is stealthier')], 'TCP connect scan completes the three-way handshake (more detectable), while SYN scan sends only SYN packets (stealthier).', 'medium', 'approved'),
                $this->q('What tool is commonly used for network scanning?', [$this->correct('Nmap'), $this->wrong('Wireshark'), $this->wrong('Metasploit'), $this->wrong('John the Ripper')], 'Nmap is the industry-standard tool for network discovery and port scanning.', 'easy', 'approved'),
            ],
            'System Hacking' => [
                $this->q('What is password cracking?', [$this->correct('Attempting to recover passwords from stored or transmitted data'), $this->wrong('Creating new passwords'), $this->wrong('Encrypting passwords'), $this->wrong('Deleting passwords')], 'Password cracking uses various techniques (dictionary, brute force, rainbow tables) to recover passwords from hashes or encrypted data.', 'easy', 'approved'),
                $this->q('What is a rainbow table?', [$this->correct('Precomputed hashes used to crack passwords quickly'), $this->wrong('A colorful spreadsheet'), $this->wrong('A network diagram'), $this->wrong('A firewall rule set')], 'Rainbow tables contain precomputed hashes for common passwords, allowing fast password cracking by looking up hashes instead of computing them.', 'medium', 'approved'),
                $this->q('What is privilege escalation?', [$this->correct('Gaining higher-level permissions than initially granted'), $this->wrong('Reducing user permissions'), $this->wrong('Creating new user accounts'), $this->wrong('Deleting administrator accounts')], 'Privilege escalation exploits vulnerabilities to gain elevated access, such as moving from user to administrator privileges.', 'medium', 'approved'),
            ],
            'Malware and Social Engineering' => [
                $this->q('What is a trojan horse?', [$this->correct('Malware disguised as legitimate software'), $this->wrong('A self-replicating virus'), $this->wrong('A network attack'), $this->wrong('An encryption method')], 'Trojans appear to be legitimate software but contain malicious code that executes when the user runs the program.', 'easy', 'approved'),
                $this->q('What is spear phishing?', [$this->correct('Targeted phishing attacks against specific individuals'), $this->wrong('Phishing using phone calls'), $this->wrong('Phishing via text messages'), $this->wrong('Automated phishing campaigns')], 'Spear phishing targets specific individuals with personalized messages, making them more convincing than generic phishing.', 'easy', 'approved'),
                $this->q('What is a keylogger?', [$this->correct('Software or hardware that records keystrokes'), $this->wrong('A password manager'), $this->wrong('An encryption tool'), $this->wrong('A firewall')], 'Keyloggers capture everything typed on a keyboard, including passwords, credit card numbers, and sensitive information.', 'easy', 'approved'),
            ],
            'Web Application Hacking' => [
                $this->q('What is SQL injection?', [$this->correct('Inserting malicious SQL code into application queries'), $this->wrong('A database optimization technique'), $this->wrong('A type of encryption'), $this->wrong('A network protocol')], 'SQL injection exploits vulnerabilities in web applications to execute unauthorized SQL commands, potentially exposing or modifying database data.', 'medium', 'approved'),
                $this->q('What is Cross-Site Scripting (XSS)?', [$this->correct('Injecting malicious scripts into web pages viewed by other users'), $this->wrong('A legitimate web development technique'), $this->wrong('A type of encryption'), $this->wrong('A network attack')], 'XSS injects malicious JavaScript into web pages, executing in victims\' browsers to steal cookies, session tokens, or perform actions as the user.', 'medium', 'approved'),
                $this->q('What is CSRF?', [$this->correct('Cross-Site Request Forgery - forcing users to execute unwanted actions'), $this->wrong('A type of encryption'), $this->wrong('A network protocol'), $this->wrong('A database attack')], 'CSRF tricks authenticated users into performing actions they didn\'t intend, exploiting the trust a website has in the user\'s browser.', 'medium', 'approved'),
            ],
            'Wireless Network Hacking' => [
                $this->q('What is WEP?', [$this->correct('An outdated and insecure wireless encryption protocol'), $this->wrong('The most secure wireless protocol'), $this->wrong('A type of firewall'), $this->wrong('A network cable')], 'WEP (Wired Equivalent Privacy) is deprecated due to serious security flaws and can be cracked in minutes.', 'easy', 'approved'),
                $this->q('What is a rogue access point?', [$this->correct('An unauthorized wireless access point on a network'), $this->wrong('A legitimate corporate access point'), $this->wrong('A type of firewall'), $this->wrong('An encryption method')], 'Rogue access points are unauthorized devices that can bypass security controls and provide attackers with network access.', 'medium', 'approved'),
                $this->q('What is WPA2?', [$this->correct('A secure wireless encryption protocol using AES'), $this->wrong('An outdated wireless protocol'), $this->wrong('A type of network cable'), $this->wrong('A firewall')], 'WPA2 uses AES encryption and is significantly more secure than WEP or WPA, though WPA3 is now recommended.', 'easy', 'approved'),
            ],
        ];
    }
}

