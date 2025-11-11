<?php

namespace Database\Seeders\Questions;

class CISSPQuestionSeeder extends BaseQuestionSeeder
{
    protected function getCertificationSlug(): string
    {
        return 'cissp';
    }

    protected function getQuestionsData(): array
    {
        return [
            'Security and Risk Management' => [
                $this->q('What is the CIA triad?', [$this->correct('Confidentiality, Integrity, and Availability'), $this->wrong('Control, Implementation, and Assessment'), $this->wrong('Compliance, Investigation, and Audit'), $this->wrong('Classification, Identification, and Authorization')], 'The CIA triad is the foundation of information security: protecting confidentiality, ensuring integrity, and maintaining availability.', 'easy', 'approved'),
                $this->q('What is due diligence?', [$this->correct('Investigating and understanding risks before making decisions'), $this->wrong('Following regulations after an incident'), $this->wrong('Implementing security controls'), $this->wrong('Conducting audits')], 'Due diligence involves researching and understanding risks, while due care is taking reasonable steps to mitigate them.', 'medium', 'approved'),
                $this->q('What is risk appetite?', [$this->correct('The amount of risk an organization is willing to accept'), $this->wrong('The total amount of risk facing an organization'), $this->wrong('The cost of security controls'), $this->wrong('The likelihood of a threat')], 'Risk appetite defines how much risk an organization is willing to tolerate in pursuit of its objectives.', 'medium', 'approved'),
            ],
            'Asset Security' => [
                $this->q('What is data classification?', [$this->correct('Categorizing data based on sensitivity and criticality'), $this->wrong('Organizing files in folders'), $this->wrong('Encrypting all data'), $this->wrong('Backing up data')], 'Data classification assigns labels (e.g., public, internal, confidential, secret) to data based on its sensitivity and value.', 'easy', 'approved'),
                $this->q('What is data remanence?', [$this->correct('Residual data remaining after deletion attempts'), $this->wrong('Data backup copies'), $this->wrong('Encrypted data'), $this->wrong('Archived data')], 'Data remanence is residual data that remains on storage media after deletion, requiring secure sanitization methods.', 'medium', 'approved'),
                $this->q('What is the difference between data owner and data custodian?', [$this->correct('Owner is responsible for data, custodian implements protection'), $this->wrong('They are the same role'), $this->wrong('Custodian owns the data'), $this->wrong('Owner stores the data')], 'Data owners are accountable for data and define requirements, while custodians implement and maintain the protective controls.', 'medium', 'approved'),
            ],
            'Security Architecture and Engineering' => [
                $this->q('What is defense in depth?', [$this->correct('Using multiple layers of security controls'), $this->wrong('Using the strongest single control'), $this->wrong('Focusing only on perimeter security'), $this->wrong('Relying on encryption alone')], 'Defense in depth uses multiple overlapping security layers so that if one fails, others provide continued protection.', 'easy', 'approved'),
                $this->q('What is the Trusted Computing Base (TCB)?', [$this->correct('The totality of protection mechanisms within a system'), $this->wrong('A specific hardware component'), $this->wrong('An encryption algorithm'), $this->wrong('A network firewall')], 'The TCB includes all hardware, firmware, and software components responsible for enforcing the security policy.', 'medium', 'approved'),
                $this->q('What is the principle of fail-safe?', [$this->correct('Systems should fail to a secure state'), $this->wrong('Systems should never fail'), $this->wrong('Systems should fail open'), $this->wrong('Systems should restart automatically')], 'Fail-safe design ensures that when a system fails, it defaults to a secure state (e.g., doors unlock during fire, access denied on error).', 'medium', 'approved'),
            ],
            'Communication and Network Security' => [
                $this->q('What OSI layer does a router operate at?', [$this->correct('Layer 3 (Network)'), $this->wrong('Layer 2 (Data Link)'), $this->wrong('Layer 4 (Transport)'), $this->wrong('Layer 7 (Application)')], 'Routers operate at Layer 3, making forwarding decisions based on IP addresses.', 'easy', 'approved'),
                $this->q('What is the difference between TCP and UDP?', [$this->correct('TCP is connection-oriented and reliable, UDP is connectionless'), $this->wrong('UDP is more reliable than TCP'), $this->wrong('TCP is faster than UDP'), $this->wrong('They are the same')], 'TCP provides reliable, ordered delivery with error checking, while UDP is faster but doesn\'t guarantee delivery.', 'easy', 'approved'),
                $this->q('What is IPSec?', [$this->correct('A protocol suite for securing IP communications'), $this->wrong('An email encryption protocol'), $this->wrong('A web security protocol'), $this->wrong('A wireless security standard')], 'IPSec provides authentication, integrity, and confidentiality for IP packets, commonly used in VPNs.', 'medium', 'approved'),
            ],
            'Identity and Access Management' => [
                $this->q('What is the difference between identification and authentication?', [$this->correct('Identification claims identity, authentication proves it'), $this->wrong('They are the same'), $this->wrong('Authentication comes before identification'), $this->wrong('Identification is more secure')], 'Identification is claiming an identity (username), authentication is proving that identity (password, biometric).', 'easy', 'approved'),
                $this->q('What is Single Sign-On (SSO)?', [$this->correct('Authenticating once to access multiple systems'), $this->wrong('Using one password for all accounts'), $this->wrong('Logging in without a password'), $this->wrong('Automatic authentication')], 'SSO allows users to authenticate once and access multiple applications without re-authenticating.', 'easy', 'approved'),
                $this->q('What is the difference between RBAC and DAC?', [$this->correct('RBAC uses roles, DAC allows owners to set permissions'), $this->wrong('They are the same'), $this->wrong('DAC is more secure'), $this->wrong('RBAC is outdated')], 'Role-Based Access Control assigns permissions by role, while Discretionary Access Control allows resource owners to set permissions.', 'medium', 'approved'),
            ],
            'Security Assessment and Testing' => [
                $this->q('What is the difference between vulnerability assessment and penetration testing?', [$this->correct('VA identifies vulnerabilities, pen testing exploits them'), $this->wrong('They are the same'), $this->wrong('Pen testing is automated, VA is manual'), $this->wrong('VA is more thorough')], 'Vulnerability assessments identify and report vulnerabilities, while penetration tests actively exploit them to demonstrate impact.', 'medium', 'approved'),
                $this->q('What is code review?', [$this->correct('Examining source code for security flaws'), $this->wrong('Testing compiled applications'), $this->wrong('Reviewing documentation'), $this->wrong('Scanning networks')], 'Code review (static analysis) examines source code to identify security vulnerabilities before the code is executed.', 'easy', 'approved'),
                $this->q('What is regression testing?', [$this->correct('Testing to ensure changes don\'t break existing functionality'), $this->wrong('Testing old systems'), $this->wrong('Performance testing'), $this->wrong('Security testing')], 'Regression testing verifies that new changes or patches don\'t introduce new bugs or break existing features.', 'medium', 'approved'),
            ],
            'Security Operations' => [
                $this->q('What is change management?', [$this->correct('A formal process for making changes to systems'), $this->wrong('Updating passwords regularly'), $this->wrong('Installing patches immediately'), $this->wrong('Replacing old hardware')], 'Change management ensures changes are reviewed, approved, tested, and documented before implementation to prevent disruptions.', 'easy', 'approved'),
                $this->q('What is the purpose of security awareness training?', [$this->correct('To educate users about security threats and responsibilities'), $this->wrong('To install security software'), $this->wrong('To configure firewalls'), $this->wrong('To perform audits')], 'Security awareness training addresses the human element, teaching users to recognize and respond appropriately to threats.', 'easy', 'approved'),
                $this->q('What is the difference between backup and disaster recovery?', [$this->correct('Backup copies data, DR restores operations after a disaster'), $this->wrong('They are the same'), $this->wrong('DR is faster than backup'), $this->wrong('Backup is more expensive')], 'Backups preserve data copies, while disaster recovery encompasses the entire process of restoring operations after a major disruption.', 'medium', 'approved'),
            ],
            'Software Development Security' => [
                $this->q('What is the Secure Development Lifecycle (SDL)?', [$this->correct('Integrating security throughout the software development process'), $this->wrong('Testing security after development'), $this->wrong('A programming language'), $this->wrong('A type of encryption')], 'SDL incorporates security considerations in every phase of development, from requirements through deployment and maintenance.', 'medium', 'approved'),
                $this->q('What is input validation?', [$this->correct('Verifying that user input meets expected criteria'), $this->wrong('Encrypting user input'), $this->wrong('Storing user input'), $this->wrong('Logging user input')], 'Input validation checks that data is properly formed, preventing injection attacks and other input-based vulnerabilities.', 'easy', 'approved'),
                $this->q('What is the principle of least privilege in software design?', [$this->correct('Code should run with minimum necessary permissions'), $this->wrong('All code should run as administrator'), $this->wrong('Code should have no permissions'), $this->wrong('Only managers can run code')], 'Applications should run with the minimum privileges required to function, limiting potential damage from exploitation.', 'easy', 'approved'),
            ],
        ];
    }
}

