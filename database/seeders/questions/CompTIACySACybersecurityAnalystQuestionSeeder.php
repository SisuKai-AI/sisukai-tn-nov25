<?php

namespace Database\Seeders\Questions;

class CompTIACySACybersecurityAnalystQuestionSeeder extends BaseQuestionSeeder
{
    protected function getCertificationSlug(): string
    {
        return 'comptia-cysa-plus';
    }

    protected function getQuestionsData(): array
    {
        return [
            'Threat and Vulnerability Management' => [
                $this->q('What is threat intelligence?', [$this->correct('Information about potential or current attacks that threaten an organization'), $this->wrong('A list of all software vulnerabilities'), $this->wrong('A firewall configuration'), $this->wrong('An antivirus program')], 'Threat intelligence provides actionable information about threats, including indicators of compromise (IOCs), tactics, techniques, and procedures (TTPs).', 'easy', 'approved'),
                $this->q('What is the difference between a vulnerability and an exploit?', [$this->correct('A vulnerability is a weakness, an exploit is code that takes advantage of it'), $this->wrong('They are the same thing'), $this->wrong('An exploit is less dangerous than a vulnerability'), $this->wrong('Vulnerabilities only exist in software')], 'Vulnerabilities are weaknesses in systems, while exploits are specific methods or code used to take advantage of those weaknesses.', 'medium', 'approved'),
                $this->q('What is a zero-day vulnerability?', [$this->correct('A vulnerability that is unknown to the vendor and has no patch available'), $this->wrong('A vulnerability discovered on day zero of a product release'), $this->wrong('A vulnerability that takes zero days to exploit'), $this->wrong('A vulnerability with zero impact')], 'Zero-day vulnerabilities are unknown to the software vendor, meaning no patch exists and attackers may already be exploiting them.', 'medium', 'approved'),
            ],
            'Software and Systems Security' => [
                $this->q('What is the purpose of application whitelisting?', [$this->correct('To allow only approved applications to run on a system'), $this->wrong('To block all applications'), $this->wrong('To list all installed applications'), $this->wrong('To update applications automatically')], 'Application whitelisting permits only pre-approved applications to execute, blocking all others including malware.', 'medium', 'approved'),
                $this->q('What is sandboxing in security?', [$this->correct('Running untrusted code in an isolated environment'), $this->wrong('Storing backups in a secure location'), $this->wrong('Encrypting sensitive data'), $this->wrong('Monitoring network traffic')], 'Sandboxing executes potentially malicious code in an isolated environment to analyze behavior without risking the host system.', 'medium', 'approved'),
                $this->q('What does HIDS stand for?', [$this->correct('Host-based Intrusion Detection System'), $this->wrong('Hardware Intrusion Detection System'), $this->wrong('Hybrid Intrusion Detection System'), $this->wrong('High-level Intrusion Detection System')], 'HIDS monitors a single host for suspicious activity, complementing network-based IDS (NIDS).', 'easy', 'approved'),
            ],
            'Security Operations and Monitoring' => [
                $this->q('What is a SIEM system?', [$this->correct('Security Information and Event Management - aggregates and analyzes security data'), $this->wrong('A type of firewall'), $this->wrong('An antivirus program'), $this->wrong('A backup solution')], 'SIEM systems collect logs and events from across the network, correlate them, and provide alerts on potential security incidents.', 'easy', 'approved'),
                $this->q('What is the purpose of log correlation?', [$this->correct('To identify patterns and relationships across multiple log sources'), $this->wrong('To delete old logs'), $this->wrong('To encrypt log files'), $this->wrong('To compress log data')], 'Log correlation analyzes logs from multiple sources to identify patterns that might indicate security incidents.', 'medium', 'approved'),
                $this->q('What is a false positive in security monitoring?', [$this->correct('An alert triggered by benign activity incorrectly identified as malicious'), $this->wrong('A real attack that was detected'), $this->wrong('A system error'), $this->wrong('A successful security control')], 'False positives are alerts triggered by legitimate activity, wasting analyst time and potentially causing alert fatigue.', 'easy', 'approved'),
            ],
            'Incident Response' => [
                $this->q('What is the first step in the incident response process?', [$this->correct('Preparation'), $this->wrong('Containment'), $this->wrong('Eradication'), $this->wrong('Recovery')], 'Preparation involves establishing policies, procedures, tools, and training before an incident occurs.', 'easy', 'approved'),
                $this->q('What is the purpose of containment in incident response?', [$this->correct('To limit the scope and impact of the incident'), $this->wrong('To delete all affected systems'), $this->wrong('To notify law enforcement'), $this->wrong('To restore normal operations')], 'Containment prevents the incident from spreading while preserving evidence for investigation.', 'medium', 'approved'),
                $this->q('What is chain of custody?', [$this->correct('Documentation of who handled evidence and when'), $this->wrong('A list of security controls'), $this->wrong('An incident timeline'), $this->wrong('A network diagram')], 'Chain of custody maintains a documented trail of evidence handling to ensure admissibility in legal proceedings.', 'medium', 'approved'),
            ],
            'Compliance and Assessment' => [
                $this->q('What is the purpose of a penetration test?', [$this->correct('To simulate an attack to identify exploitable vulnerabilities'), $this->wrong('To install security patches'), $this->wrong('To train employees'), $this->wrong('To backup data')], 'Penetration testing simulates real-world attacks to identify security weaknesses before malicious actors can exploit them.', 'easy', 'approved'),
                $this->q('What is the difference between black box and white box testing?', [$this->correct('Black box has no prior knowledge, white box has full knowledge of the system'), $this->wrong('They are the same'), $this->wrong('White box is faster than black box'), $this->wrong('Black box is more thorough')], 'Black box testing simulates an external attacker with no knowledge, while white box testing has full system knowledge like an insider.', 'medium', 'approved'),
                $this->q('What is a security baseline?', [$this->correct('A minimum set of security controls required for a system'), $this->wrong('The first security scan of a system'), $this->wrong('A list of all vulnerabilities'), $this->wrong('A network diagram')], 'Security baselines define minimum security configurations and controls that all systems must meet.', 'easy', 'approved'),
            ],
        ];
    }
}

