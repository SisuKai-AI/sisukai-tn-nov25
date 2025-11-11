<?php

namespace Database\Seeders\Questions;

class CertifiedInformationSystemsSecurityProfessionalCISSPQuestionSeeder extends BaseQuestionSeeder
{
    protected function getCertificationSlug(): string
    {
        return 'cissp';
    }

    protected function getQuestionsData(): array
    {
        return [
            'Security Governance Principles' => [
                $this->q(
                    'Which of the following best describes Security Governance Principles?',
                    [
                        $this->correct('Correct answer related to Security Governance Principles'),
                        $this->wrong('Incorrect option A for Security Governance Principles'),
                        $this->wrong('Incorrect option B for Security Governance Principles'),
                        $this->wrong('Incorrect option C for Security Governance Principles'),
                    ],
                    'This question tests understanding of Security Governance Principles and its practical applications.',
                    'easy', 'approved'),
                $this->q(
                    'What is the primary purpose of Security Governance Principles?',
                    [
                        $this->correct('Correct answer related to Security Governance Principles'),
                        $this->wrong('Incorrect option A for Security Governance Principles'),
                        $this->wrong('Incorrect option B for Security Governance Principles'),
                        $this->wrong('Incorrect option C for Security Governance Principles'),
                    ],
                    'This question tests understanding of Security Governance Principles and its practical applications.',
                    'easy', 'approved'),
                $this->q(
                    'What are the main components of Security Governance Principles?',
                    [
                        $this->correct('Correct answer related to Security Governance Principles'),
                        $this->wrong('Incorrect option A for Security Governance Principles'),
                        $this->wrong('Incorrect option B for Security Governance Principles'),
                        $this->wrong('Incorrect option C for Security Governance Principles'),
                    ],
                    'This question tests understanding of Security Governance Principles and its practical applications.',
                    'medium', 'approved'),
                $this->q(
                    'What is a key benefit of implementing Security Governance Principles?',
                    [
                        $this->correct('Correct answer related to Security Governance Principles'),
                        $this->wrong('Incorrect option A for Security Governance Principles'),
                        $this->wrong('Incorrect option B for Security Governance Principles'),
                        $this->wrong('Incorrect option C for Security Governance Principles'),
                    ],
                    'This question tests understanding of Security Governance Principles and its practical applications.',
                    'medium', 'approved'),
                $this->q(
                    'Which scenario best demonstrates the use of Security Governance Principles?',
                    [
                        $this->correct('Correct answer related to Security Governance Principles'),
                        $this->wrong('Incorrect option A for Security Governance Principles'),
                        $this->wrong('Incorrect option B for Security Governance Principles'),
                        $this->wrong('Incorrect option C for Security Governance Principles'),
                    ],
                    'This question tests understanding of Security Governance Principles and its practical applications.',
                    'medium', 'approved'),
                $this->q(
                    'How would you troubleshoot issues related to Security Governance Principles?',
                    [
                        $this->correct('Correct answer related to Security Governance Principles'),
                        $this->wrong('Incorrect option A for Security Governance Principles'),
                        $this->wrong('Incorrect option B for Security Governance Principles'),
                        $this->wrong('Incorrect option C for Security Governance Principles'),
                    ],
                    'This question tests understanding of Security Governance Principles and its practical applications.',
                    'hard', 'approved'),
            ],

            'Compliance and Legal Requirements' => [
                $this->q(
                    'What is the primary purpose of Compliance and Legal Requirements?',
                    [
                        $this->correct('Correct answer related to Compliance and Legal Requirements'),
                        $this->wrong('Incorrect option A for Compliance and Legal Requirements'),
                        $this->wrong('Incorrect option B for Compliance and Legal Requirements'),
                        $this->wrong('Incorrect option C for Compliance and Legal Requirements'),
                    ],
                    'This question tests understanding of Compliance and Legal Requirements and its practical applications.',
                    'easy', 'approved'),
                $this->q(
                    'Which of the following best describes Compliance and Legal Requirements?',
                    [
                        $this->correct('Correct answer related to Compliance and Legal Requirements'),
                        $this->wrong('Incorrect option A for Compliance and Legal Requirements'),
                        $this->wrong('Incorrect option B for Compliance and Legal Requirements'),
                        $this->wrong('Incorrect option C for Compliance and Legal Requirements'),
                    ],
                    'This question tests understanding of Compliance and Legal Requirements and its practical applications.',
                    'easy', 'approved'),
                $this->q(
                    'Which scenario best demonstrates the use of Compliance and Legal Requirements?',
                    [
                        $this->correct('Correct answer related to Compliance and Legal Requirements'),
                        $this->wrong('Incorrect option A for Compliance and Legal Requirements'),
                        $this->wrong('Incorrect option B for Compliance and Legal Requirements'),
                        $this->wrong('Incorrect option C for Compliance and Legal Requirements'),
                    ],
                    'This question tests understanding of Compliance and Legal Requirements and its practical applications.',
                    'medium', 'approved'),
                $this->q(
                    'What is a key benefit of implementing Compliance and Legal Requirements?',
                    [
                        $this->correct('Correct answer related to Compliance and Legal Requirements'),
                        $this->wrong('Incorrect option A for Compliance and Legal Requirements'),
                        $this->wrong('Incorrect option B for Compliance and Legal Requirements'),
                        $this->wrong('Incorrect option C for Compliance and Legal Requirements'),
                    ],
                    'This question tests understanding of Compliance and Legal Requirements and its practical applications.',
                    'medium', 'approved'),
                $this->q(
                    'What is a key benefit of implementing Compliance and Legal Requirements?',
                    [
                        $this->correct('Correct answer related to Compliance and Legal Requirements'),
                        $this->wrong('Incorrect option A for Compliance and Legal Requirements'),
                        $this->wrong('Incorrect option B for Compliance and Legal Requirements'),
                        $this->wrong('Incorrect option C for Compliance and Legal Requirements'),
                    ],
                    'This question tests understanding of Compliance and Legal Requirements and its practical applications.',
                    'medium', 'approved'),
                $this->q(
                    'What are the security implications of Compliance and Legal Requirements?',
                    [
                        $this->correct('Correct answer related to Compliance and Legal Requirements'),
                        $this->wrong('Incorrect option A for Compliance and Legal Requirements'),
                        $this->wrong('Incorrect option B for Compliance and Legal Requirements'),
                        $this->wrong('Incorrect option C for Compliance and Legal Requirements'),
                    ],
                    'This question tests understanding of Compliance and Legal Requirements and its practical applications.',
                    'hard', 'approved'),
            ],

            'Professional Ethics' => [
                $this->q(
                    'Which of the following best describes Professional Ethics?',
                    [
                        $this->correct('Correct answer related to Professional Ethics'),
                        $this->wrong('Incorrect option A for Professional Ethics'),
                        $this->wrong('Incorrect option B for Professional Ethics'),
                        $this->wrong('Incorrect option C for Professional Ethics'),
                    ],
                    'This question tests understanding of Professional Ethics and its practical applications.',
                    'easy', 'approved'),
                $this->q(
                    'Which statement about Professional Ethics is correct?',
                    [
                        $this->correct('Correct answer related to Professional Ethics'),
                        $this->wrong('Incorrect option A for Professional Ethics'),
                        $this->wrong('Incorrect option B for Professional Ethics'),
                        $this->wrong('Incorrect option C for Professional Ethics'),
                    ],
                    'This question tests understanding of Professional Ethics and its practical applications.',
                    'easy', 'approved'),
                $this->q(
                    'Which scenario best demonstrates the use of Professional Ethics?',
                    [
                        $this->correct('Correct answer related to Professional Ethics'),
                        $this->wrong('Incorrect option A for Professional Ethics'),
                        $this->wrong('Incorrect option B for Professional Ethics'),
                        $this->wrong('Incorrect option C for Professional Ethics'),
                    ],
                    'This question tests understanding of Professional Ethics and its practical applications.',
                    'medium', 'approved'),
                $this->q(
                    'What are the main components of Professional Ethics?',
                    [
                        $this->correct('Correct answer related to Professional Ethics'),
                        $this->wrong('Incorrect option A for Professional Ethics'),
                        $this->wrong('Incorrect option B for Professional Ethics'),
                        $this->wrong('Incorrect option C for Professional Ethics'),
                    ],
                    'This question tests understanding of Professional Ethics and its practical applications.',
                    'medium', 'approved'),
                $this->q(
                    'What are the main components of Professional Ethics?',
                    [
                        $this->correct('Correct answer related to Professional Ethics'),
                        $this->wrong('Incorrect option A for Professional Ethics'),
                        $this->wrong('Incorrect option B for Professional Ethics'),
                        $this->wrong('Incorrect option C for Professional Ethics'),
                    ],
                    'This question tests understanding of Professional Ethics and its practical applications.',
                    'medium', 'approved'),
                $this->q(
                    'In a production environment, how would you optimize Professional Ethics?',
                    [
                        $this->correct('Correct answer related to Professional Ethics'),
                        $this->wrong('Incorrect option A for Professional Ethics'),
                        $this->wrong('Incorrect option B for Professional Ethics'),
                        $this->wrong('Incorrect option C for Professional Ethics'),
                    ],
                    'This question tests understanding of Professional Ethics and its practical applications.',
                    'hard', 'approved'),
            ],

            'Risk Management Concepts' => [
                $this->q(
                    'Which of the following best describes Risk Management Concepts?',
                    [
                        $this->correct('Correct answer related to Risk Management Concepts'),
                        $this->wrong('Incorrect option A for Risk Management Concepts'),
                        $this->wrong('Incorrect option B for Risk Management Concepts'),
                        $this->wrong('Incorrect option C for Risk Management Concepts'),
                    ],
                    'This question tests understanding of Risk Management Concepts and its practical applications.',
                    'easy', 'approved'),
                $this->q(
                    'What is Risk Management Concepts used for?',
                    [
                        $this->correct('Correct answer related to Risk Management Concepts'),
                        $this->wrong('Incorrect option A for Risk Management Concepts'),
                        $this->wrong('Incorrect option B for Risk Management Concepts'),
                        $this->wrong('Incorrect option C for Risk Management Concepts'),
                    ],
                    'This question tests understanding of Risk Management Concepts and its practical applications.',
                    'easy', 'approved'),
                $this->q(
                    'What is a key benefit of implementing Risk Management Concepts?',
                    [
                        $this->correct('Correct answer related to Risk Management Concepts'),
                        $this->wrong('Incorrect option A for Risk Management Concepts'),
                        $this->wrong('Incorrect option B for Risk Management Concepts'),
                        $this->wrong('Incorrect option C for Risk Management Concepts'),
                    ],
                    'This question tests understanding of Risk Management Concepts and its practical applications.',
                    'medium', 'approved'),
                $this->q(
                    'Which scenario best demonstrates the use of Risk Management Concepts?',
                    [
                        $this->correct('Correct answer related to Risk Management Concepts'),
                        $this->wrong('Incorrect option A for Risk Management Concepts'),
                        $this->wrong('Incorrect option B for Risk Management Concepts'),
                        $this->wrong('Incorrect option C for Risk Management Concepts'),
                    ],
                    'This question tests understanding of Risk Management Concepts and its practical applications.',
                    'medium', 'approved'),
                $this->q(
                    'What are the main components of Risk Management Concepts?',
                    [
                        $this->correct('Correct answer related to Risk Management Concepts'),
                        $this->wrong('Incorrect option A for Risk Management Concepts'),
                        $this->wrong('Incorrect option B for Risk Management Concepts'),
                        $this->wrong('Incorrect option C for Risk Management Concepts'),
                    ],
                    'This question tests understanding of Risk Management Concepts and its practical applications.',
                    'medium', 'approved'),
                $this->q(
                    'What is the best practice for implementing Risk Management Concepts at scale?',
                    [
                        $this->correct('Correct answer related to Risk Management Concepts'),
                        $this->wrong('Incorrect option A for Risk Management Concepts'),
                        $this->wrong('Incorrect option B for Risk Management Concepts'),
                        $this->wrong('Incorrect option C for Risk Management Concepts'),
                    ],
                    'This question tests understanding of Risk Management Concepts and its practical applications.',
                    'hard', 'approved'),
            ],

            'Business Continuity Planning' => [
                $this->q(
                    'What is Business Continuity Planning used for?',
                    [
                        $this->correct('Correct answer related to Business Continuity Planning'),
                        $this->wrong('Incorrect option A for Business Continuity Planning'),
                        $this->wrong('Incorrect option B for Business Continuity Planning'),
                        $this->wrong('Incorrect option C for Business Continuity Planning'),
                    ],
                    'This question tests understanding of Business Continuity Planning and its practical applications.',
                    'easy', 'approved'),
                $this->q(
                    'What is the primary purpose of Business Continuity Planning?',
                    [
                        $this->correct('Correct answer related to Business Continuity Planning'),
                        $this->wrong('Incorrect option A for Business Continuity Planning'),
                        $this->wrong('Incorrect option B for Business Continuity Planning'),
                        $this->wrong('Incorrect option C for Business Continuity Planning'),
                    ],
                    'This question tests understanding of Business Continuity Planning and its practical applications.',
                    'easy', 'approved'),
                $this->q(
                    'What is a key benefit of implementing Business Continuity Planning?',
                    [
                        $this->correct('Correct answer related to Business Continuity Planning'),
                        $this->wrong('Incorrect option A for Business Continuity Planning'),
                        $this->wrong('Incorrect option B for Business Continuity Planning'),
                        $this->wrong('Incorrect option C for Business Continuity Planning'),
                    ],
                    'This question tests understanding of Business Continuity Planning and its practical applications.',
                    'medium', 'approved'),
                $this->q(
                    'What are the main components of Business Continuity Planning?',
                    [
                        $this->correct('Correct answer related to Business Continuity Planning'),
                        $this->wrong('Incorrect option A for Business Continuity Planning'),
                        $this->wrong('Incorrect option B for Business Continuity Planning'),
                        $this->wrong('Incorrect option C for Business Continuity Planning'),
                    ],
                    'This question tests understanding of Business Continuity Planning and its practical applications.',
                    'medium', 'approved'),
                $this->q(
                    'What is a key benefit of implementing Business Continuity Planning?',
                    [
                        $this->correct('Correct answer related to Business Continuity Planning'),
                        $this->wrong('Incorrect option A for Business Continuity Planning'),
                        $this->wrong('Incorrect option B for Business Continuity Planning'),
                        $this->wrong('Incorrect option C for Business Continuity Planning'),
                    ],
                    'This question tests understanding of Business Continuity Planning and its practical applications.',
                    'medium', 'approved'),
                $this->q(
                    'What are the security implications of Business Continuity Planning?',
                    [
                        $this->correct('Correct answer related to Business Continuity Planning'),
                        $this->wrong('Incorrect option A for Business Continuity Planning'),
                        $this->wrong('Incorrect option B for Business Continuity Planning'),
                        $this->wrong('Incorrect option C for Business Continuity Planning'),
                    ],
                    'This question tests understanding of Business Continuity Planning and its practical applications.',
                    'hard', 'approved'),
            ],

            'Information and Asset Classification' => [
                $this->q(
                    'Which statement about Information and Asset Classification is correct?',
                    [
                        $this->correct('Correct answer related to Information and Asset Classification'),
                        $this->wrong('Incorrect option A for Information and Asset Classification'),
                        $this->wrong('Incorrect option B for Information and Asset Classification'),
                        $this->wrong('Incorrect option C for Information and Asset Classification'),
                    ],
                    'This question tests understanding of Information and Asset Classification and its practical applications.',
                    'easy', 'approved'),
                $this->q(
                    'What is the primary purpose of Information and Asset Classification?',
                    [
                        $this->correct('Correct answer related to Information and Asset Classification'),
                        $this->wrong('Incorrect option A for Information and Asset Classification'),
                        $this->wrong('Incorrect option B for Information and Asset Classification'),
                        $this->wrong('Incorrect option C for Information and Asset Classification'),
                    ],
                    'This question tests understanding of Information and Asset Classification and its practical applications.',
                    'easy', 'approved'),
                $this->q(
                    'What is a key benefit of implementing Information and Asset Classification?',
                    [
                        $this->correct('Correct answer related to Information and Asset Classification'),
                        $this->wrong('Incorrect option A for Information and Asset Classification'),
                        $this->wrong('Incorrect option B for Information and Asset Classification'),
                        $this->wrong('Incorrect option C for Information and Asset Classification'),
                    ],
                    'This question tests understanding of Information and Asset Classification and its practical applications.',
                    'medium', 'approved'),
                $this->q(
                    'How does Information and Asset Classification improve system performance?',
                    [
                        $this->correct('Correct answer related to Information and Asset Classification'),
                        $this->wrong('Incorrect option A for Information and Asset Classification'),
                        $this->wrong('Incorrect option B for Information and Asset Classification'),
                        $this->wrong('Incorrect option C for Information and Asset Classification'),
                    ],
                    'This question tests understanding of Information and Asset Classification and its practical applications.',
                    'medium', 'approved'),
                $this->q(
                    'How does Information and Asset Classification improve system performance?',
                    [
                        $this->correct('Correct answer related to Information and Asset Classification'),
                        $this->wrong('Incorrect option A for Information and Asset Classification'),
                        $this->wrong('Incorrect option B for Information and Asset Classification'),
                        $this->wrong('Incorrect option C for Information and Asset Classification'),
                    ],
                    'This question tests understanding of Information and Asset Classification and its practical applications.',
                    'medium', 'approved'),
                $this->q(
                    'How would you troubleshoot issues related to Information and Asset Classification?',
                    [
                        $this->correct('Correct answer related to Information and Asset Classification'),
                        $this->wrong('Incorrect option A for Information and Asset Classification'),
                        $this->wrong('Incorrect option B for Information and Asset Classification'),
                        $this->wrong('Incorrect option C for Information and Asset Classification'),
                    ],
                    'This question tests understanding of Information and Asset Classification and its practical applications.',
                    'hard', 'approved'),
            ],

            'Ownership and Accountability' => [
                $this->q(
                    'Which statement about Ownership and Accountability is correct?',
                    [
                        $this->correct('Correct answer related to Ownership and Accountability'),
                        $this->wrong('Incorrect option A for Ownership and Accountability'),
                        $this->wrong('Incorrect option B for Ownership and Accountability'),
                        $this->wrong('Incorrect option C for Ownership and Accountability'),
                    ],
                    'This question tests understanding of Ownership and Accountability and its practical applications.',
                    'easy', 'approved'),
                $this->q(
                    'Which of the following best describes Ownership and Accountability?',
                    [
                        $this->correct('Correct answer related to Ownership and Accountability'),
                        $this->wrong('Incorrect option A for Ownership and Accountability'),
                        $this->wrong('Incorrect option B for Ownership and Accountability'),
                        $this->wrong('Incorrect option C for Ownership and Accountability'),
                    ],
                    'This question tests understanding of Ownership and Accountability and its practical applications.',
                    'easy', 'approved'),
                $this->q(
                    'What is a key benefit of implementing Ownership and Accountability?',
                    [
                        $this->correct('Correct answer related to Ownership and Accountability'),
                        $this->wrong('Incorrect option A for Ownership and Accountability'),
                        $this->wrong('Incorrect option B for Ownership and Accountability'),
                        $this->wrong('Incorrect option C for Ownership and Accountability'),
                    ],
                    'This question tests understanding of Ownership and Accountability and its practical applications.',
                    'medium', 'approved'),
                $this->q(
                    'How does Ownership and Accountability improve system performance?',
                    [
                        $this->correct('Correct answer related to Ownership and Accountability'),
                        $this->wrong('Incorrect option A for Ownership and Accountability'),
                        $this->wrong('Incorrect option B for Ownership and Accountability'),
                        $this->wrong('Incorrect option C for Ownership and Accountability'),
                    ],
                    'This question tests understanding of Ownership and Accountability and its practical applications.',
                    'medium', 'approved'),
                $this->q(
                    'What are the main components of Ownership and Accountability?',
                    [
                        $this->correct('Correct answer related to Ownership and Accountability'),
                        $this->wrong('Incorrect option A for Ownership and Accountability'),
                        $this->wrong('Incorrect option B for Ownership and Accountability'),
                        $this->wrong('Incorrect option C for Ownership and Accountability'),
                    ],
                    'This question tests understanding of Ownership and Accountability and its practical applications.',
                    'medium', 'approved'),
                $this->q(
                    'In a production environment, how would you optimize Ownership and Accountability?',
                    [
                        $this->correct('Correct answer related to Ownership and Accountability'),
                        $this->wrong('Incorrect option A for Ownership and Accountability'),
                        $this->wrong('Incorrect option B for Ownership and Accountability'),
                        $this->wrong('Incorrect option C for Ownership and Accountability'),
                    ],
                    'This question tests understanding of Ownership and Accountability and its practical applications.',
                    'hard', 'approved'),
            ],

            'Privacy Protection' => [
                $this->q(
                    'What is the primary purpose of Privacy Protection?',
                    [
                        $this->correct('Correct answer related to Privacy Protection'),
                        $this->wrong('Incorrect option A for Privacy Protection'),
                        $this->wrong('Incorrect option B for Privacy Protection'),
                        $this->wrong('Incorrect option C for Privacy Protection'),
                    ],
                    'This question tests understanding of Privacy Protection and its practical applications.',
                    'easy', 'approved'),
                $this->q(
                    'What is the primary purpose of Privacy Protection?',
                    [
                        $this->correct('Correct answer related to Privacy Protection'),
                        $this->wrong('Incorrect option A for Privacy Protection'),
                        $this->wrong('Incorrect option B for Privacy Protection'),
                        $this->wrong('Incorrect option C for Privacy Protection'),
                    ],
                    'This question tests understanding of Privacy Protection and its practical applications.',
                    'easy', 'approved'),
                $this->q(
                    'How does Privacy Protection improve system performance?',
                    [
                        $this->correct('Correct answer related to Privacy Protection'),
                        $this->wrong('Incorrect option A for Privacy Protection'),
                        $this->wrong('Incorrect option B for Privacy Protection'),
                        $this->wrong('Incorrect option C for Privacy Protection'),
                    ],
                    'This question tests understanding of Privacy Protection and its practical applications.',
                    'medium', 'approved'),
                $this->q(
                    'Which scenario best demonstrates the use of Privacy Protection?',
                    [
                        $this->correct('Correct answer related to Privacy Protection'),
                        $this->wrong('Incorrect option A for Privacy Protection'),
                        $this->wrong('Incorrect option B for Privacy Protection'),
                        $this->wrong('Incorrect option C for Privacy Protection'),
                    ],
                    'This question tests understanding of Privacy Protection and its practical applications.',
                    'medium', 'approved'),
                $this->q(
                    'Which scenario best demonstrates the use of Privacy Protection?',
                    [
                        $this->correct('Correct answer related to Privacy Protection'),
                        $this->wrong('Incorrect option A for Privacy Protection'),
                        $this->wrong('Incorrect option B for Privacy Protection'),
                        $this->wrong('Incorrect option C for Privacy Protection'),
                    ],
                    'This question tests understanding of Privacy Protection and its practical applications.',
                    'medium', 'approved'),
                $this->q(
                    'What are the security implications of Privacy Protection?',
                    [
                        $this->correct('Correct answer related to Privacy Protection'),
                        $this->wrong('Incorrect option A for Privacy Protection'),
                        $this->wrong('Incorrect option B for Privacy Protection'),
                        $this->wrong('Incorrect option C for Privacy Protection'),
                    ],
                    'This question tests understanding of Privacy Protection and its practical applications.',
                    'hard', 'approved'),
            ],

            'Data Retention and Disposal' => [
                $this->q(
                    'Which statement about Data Retention and Disposal is correct?',
                    [
                        $this->correct('Correct answer related to Data Retention and Disposal'),
                        $this->wrong('Incorrect option A for Data Retention and Disposal'),
                        $this->wrong('Incorrect option B for Data Retention and Disposal'),
                        $this->wrong('Incorrect option C for Data Retention and Disposal'),
                    ],
                    'This question tests understanding of Data Retention and Disposal and its practical applications.',
                    'easy', 'approved'),
                $this->q(
                    'What is Data Retention and Disposal used for?',
                    [
                        $this->correct('Correct answer related to Data Retention and Disposal'),
                        $this->wrong('Incorrect option A for Data Retention and Disposal'),
                        $this->wrong('Incorrect option B for Data Retention and Disposal'),
                        $this->wrong('Incorrect option C for Data Retention and Disposal'),
                    ],
                    'This question tests understanding of Data Retention and Disposal and its practical applications.',
                    'easy', 'approved'),
                $this->q(
                    'How does Data Retention and Disposal improve system performance?',
                    [
                        $this->correct('Correct answer related to Data Retention and Disposal'),
                        $this->wrong('Incorrect option A for Data Retention and Disposal'),
                        $this->wrong('Incorrect option B for Data Retention and Disposal'),
                        $this->wrong('Incorrect option C for Data Retention and Disposal'),
                    ],
                    'This question tests understanding of Data Retention and Disposal and its practical applications.',
                    'medium', 'approved'),
                $this->q(
                    'Which scenario best demonstrates the use of Data Retention and Disposal?',
                    [
                        $this->correct('Correct answer related to Data Retention and Disposal'),
                        $this->wrong('Incorrect option A for Data Retention and Disposal'),
                        $this->wrong('Incorrect option B for Data Retention and Disposal'),
                        $this->wrong('Incorrect option C for Data Retention and Disposal'),
                    ],
                    'This question tests understanding of Data Retention and Disposal and its practical applications.',
                    'medium', 'approved'),
                $this->q(
                    'Which scenario best demonstrates the use of Data Retention and Disposal?',
                    [
                        $this->correct('Correct answer related to Data Retention and Disposal'),
                        $this->wrong('Incorrect option A for Data Retention and Disposal'),
                        $this->wrong('Incorrect option B for Data Retention and Disposal'),
                        $this->wrong('Incorrect option C for Data Retention and Disposal'),
                    ],
                    'This question tests understanding of Data Retention and Disposal and its practical applications.',
                    'medium', 'approved'),
                $this->q(
                    'What are the security implications of Data Retention and Disposal?',
                    [
                        $this->correct('Correct answer related to Data Retention and Disposal'),
                        $this->wrong('Incorrect option A for Data Retention and Disposal'),
                        $this->wrong('Incorrect option B for Data Retention and Disposal'),
                        $this->wrong('Incorrect option C for Data Retention and Disposal'),
                    ],
                    'This question tests understanding of Data Retention and Disposal and its practical applications.',
                    'hard', 'approved'),
            ],

            'Data Security Controls' => [
                $this->q(
                    'Which of the following best describes Data Security Controls?',
                    [
                        $this->correct('Correct answer related to Data Security Controls'),
                        $this->wrong('Incorrect option A for Data Security Controls'),
                        $this->wrong('Incorrect option B for Data Security Controls'),
                        $this->wrong('Incorrect option C for Data Security Controls'),
                    ],
                    'This question tests understanding of Data Security Controls and its practical applications.',
                    'easy', 'approved'),
                $this->q(
                    'What is the primary purpose of Data Security Controls?',
                    [
                        $this->correct('Correct answer related to Data Security Controls'),
                        $this->wrong('Incorrect option A for Data Security Controls'),
                        $this->wrong('Incorrect option B for Data Security Controls'),
                        $this->wrong('Incorrect option C for Data Security Controls'),
                    ],
                    'This question tests understanding of Data Security Controls and its practical applications.',
                    'easy', 'approved'),
                $this->q(
                    'What is a key benefit of implementing Data Security Controls?',
                    [
                        $this->correct('Correct answer related to Data Security Controls'),
                        $this->wrong('Incorrect option A for Data Security Controls'),
                        $this->wrong('Incorrect option B for Data Security Controls'),
                        $this->wrong('Incorrect option C for Data Security Controls'),
                    ],
                    'This question tests understanding of Data Security Controls and its practical applications.',
                    'medium', 'approved'),
                $this->q(
                    'What are the main components of Data Security Controls?',
                    [
                        $this->correct('Correct answer related to Data Security Controls'),
                        $this->wrong('Incorrect option A for Data Security Controls'),
                        $this->wrong('Incorrect option B for Data Security Controls'),
                        $this->wrong('Incorrect option C for Data Security Controls'),
                    ],
                    'This question tests understanding of Data Security Controls and its practical applications.',
                    'medium', 'approved'),
                $this->q(
                    'How does Data Security Controls improve system performance?',
                    [
                        $this->correct('Correct answer related to Data Security Controls'),
                        $this->wrong('Incorrect option A for Data Security Controls'),
                        $this->wrong('Incorrect option B for Data Security Controls'),
                        $this->wrong('Incorrect option C for Data Security Controls'),
                    ],
                    'This question tests understanding of Data Security Controls and its practical applications.',
                    'medium', 'approved'),
                $this->q(
                    'What is the best practice for implementing Data Security Controls at scale?',
                    [
                        $this->correct('Correct answer related to Data Security Controls'),
                        $this->wrong('Incorrect option A for Data Security Controls'),
                        $this->wrong('Incorrect option B for Data Security Controls'),
                        $this->wrong('Incorrect option C for Data Security Controls'),
                    ],
                    'This question tests understanding of Data Security Controls and its practical applications.',
                    'hard', 'approved'),
            ],

            'Secure Design Principles' => [
                $this->q(
                    'What is Secure Design Principles used for?',
                    [
                        $this->correct('Correct answer related to Secure Design Principles'),
                        $this->wrong('Incorrect option A for Secure Design Principles'),
                        $this->wrong('Incorrect option B for Secure Design Principles'),
                        $this->wrong('Incorrect option C for Secure Design Principles'),
                    ],
                    'This question tests understanding of Secure Design Principles and its practical applications.',
                    'easy', 'approved'),
                $this->q(
                    'What is Secure Design Principles used for?',
                    [
                        $this->correct('Correct answer related to Secure Design Principles'),
                        $this->wrong('Incorrect option A for Secure Design Principles'),
                        $this->wrong('Incorrect option B for Secure Design Principles'),
                        $this->wrong('Incorrect option C for Secure Design Principles'),
                    ],
                    'This question tests understanding of Secure Design Principles and its practical applications.',
                    'easy', 'approved'),
                $this->q(
                    'What is a key benefit of implementing Secure Design Principles?',
                    [
                        $this->correct('Correct answer related to Secure Design Principles'),
                        $this->wrong('Incorrect option A for Secure Design Principles'),
                        $this->wrong('Incorrect option B for Secure Design Principles'),
                        $this->wrong('Incorrect option C for Secure Design Principles'),
                    ],
                    'This question tests understanding of Secure Design Principles and its practical applications.',
                    'medium', 'approved'),
                $this->q(
                    'Which scenario best demonstrates the use of Secure Design Principles?',
                    [
                        $this->correct('Correct answer related to Secure Design Principles'),
                        $this->wrong('Incorrect option A for Secure Design Principles'),
                        $this->wrong('Incorrect option B for Secure Design Principles'),
                        $this->wrong('Incorrect option C for Secure Design Principles'),
                    ],
                    'This question tests understanding of Secure Design Principles and its practical applications.',
                    'medium', 'approved'),
                $this->q(
                    'Which scenario best demonstrates the use of Secure Design Principles?',
                    [
                        $this->correct('Correct answer related to Secure Design Principles'),
                        $this->wrong('Incorrect option A for Secure Design Principles'),
                        $this->wrong('Incorrect option B for Secure Design Principles'),
                        $this->wrong('Incorrect option C for Secure Design Principles'),
                    ],
                    'This question tests understanding of Secure Design Principles and its practical applications.',
                    'medium', 'approved'),
                $this->q(
                    'In a production environment, how would you optimize Secure Design Principles?',
                    [
                        $this->correct('Correct answer related to Secure Design Principles'),
                        $this->wrong('Incorrect option A for Secure Design Principles'),
                        $this->wrong('Incorrect option B for Secure Design Principles'),
                        $this->wrong('Incorrect option C for Secure Design Principles'),
                    ],
                    'This question tests understanding of Secure Design Principles and its practical applications.',
                    'hard', 'approved'),
            ],

            'Security Models' => [
                $this->q(
                    'What is Security Models used for?',
                    [
                        $this->correct('Correct answer related to Security Models'),
                        $this->wrong('Incorrect option A for Security Models'),
                        $this->wrong('Incorrect option B for Security Models'),
                        $this->wrong('Incorrect option C for Security Models'),
                    ],
                    'This question tests understanding of Security Models and its practical applications.',
                    'easy', 'approved'),
                $this->q(
                    'What is the primary purpose of Security Models?',
                    [
                        $this->correct('Correct answer related to Security Models'),
                        $this->wrong('Incorrect option A for Security Models'),
                        $this->wrong('Incorrect option B for Security Models'),
                        $this->wrong('Incorrect option C for Security Models'),
                    ],
                    'This question tests understanding of Security Models and its practical applications.',
                    'easy', 'approved'),
                $this->q(
                    'What are the main components of Security Models?',
                    [
                        $this->correct('Correct answer related to Security Models'),
                        $this->wrong('Incorrect option A for Security Models'),
                        $this->wrong('Incorrect option B for Security Models'),
                        $this->wrong('Incorrect option C for Security Models'),
                    ],
                    'This question tests understanding of Security Models and its practical applications.',
                    'medium', 'approved'),
                $this->q(
                    'Which scenario best demonstrates the use of Security Models?',
                    [
                        $this->correct('Correct answer related to Security Models'),
                        $this->wrong('Incorrect option A for Security Models'),
                        $this->wrong('Incorrect option B for Security Models'),
                        $this->wrong('Incorrect option C for Security Models'),
                    ],
                    'This question tests understanding of Security Models and its practical applications.',
                    'medium', 'approved'),
                $this->q(
                    'What are the main components of Security Models?',
                    [
                        $this->correct('Correct answer related to Security Models'),
                        $this->wrong('Incorrect option A for Security Models'),
                        $this->wrong('Incorrect option B for Security Models'),
                        $this->wrong('Incorrect option C for Security Models'),
                    ],
                    'This question tests understanding of Security Models and its practical applications.',
                    'medium', 'approved'),
                $this->q(
                    'In a production environment, how would you optimize Security Models?',
                    [
                        $this->correct('Correct answer related to Security Models'),
                        $this->wrong('Incorrect option A for Security Models'),
                        $this->wrong('Incorrect option B for Security Models'),
                        $this->wrong('Incorrect option C for Security Models'),
                    ],
                    'This question tests understanding of Security Models and its practical applications.',
                    'hard', 'approved'),
            ],

            'Security Evaluation Models' => [
                $this->q(
                    'What is the primary purpose of Security Evaluation Models?',
                    [
                        $this->correct('Correct answer related to Security Evaluation Models'),
                        $this->wrong('Incorrect option A for Security Evaluation Models'),
                        $this->wrong('Incorrect option B for Security Evaluation Models'),
                        $this->wrong('Incorrect option C for Security Evaluation Models'),
                    ],
                    'This question tests understanding of Security Evaluation Models and its practical applications.',
                    'easy', 'approved'),
                $this->q(
                    'What is the primary purpose of Security Evaluation Models?',
                    [
                        $this->correct('Correct answer related to Security Evaluation Models'),
                        $this->wrong('Incorrect option A for Security Evaluation Models'),
                        $this->wrong('Incorrect option B for Security Evaluation Models'),
                        $this->wrong('Incorrect option C for Security Evaluation Models'),
                    ],
                    'This question tests understanding of Security Evaluation Models and its practical applications.',
                    'easy', 'approved'),
                $this->q(
                    'What are the main components of Security Evaluation Models?',
                    [
                        $this->correct('Correct answer related to Security Evaluation Models'),
                        $this->wrong('Incorrect option A for Security Evaluation Models'),
                        $this->wrong('Incorrect option B for Security Evaluation Models'),
                        $this->wrong('Incorrect option C for Security Evaluation Models'),
                    ],
                    'This question tests understanding of Security Evaluation Models and its practical applications.',
                    'medium', 'approved'),
                $this->q(
                    'What are the main components of Security Evaluation Models?',
                    [
                        $this->correct('Correct answer related to Security Evaluation Models'),
                        $this->wrong('Incorrect option A for Security Evaluation Models'),
                        $this->wrong('Incorrect option B for Security Evaluation Models'),
                        $this->wrong('Incorrect option C for Security Evaluation Models'),
                    ],
                    'This question tests understanding of Security Evaluation Models and its practical applications.',
                    'medium', 'approved'),
                $this->q(
                    'Which scenario best demonstrates the use of Security Evaluation Models?',
                    [
                        $this->correct('Correct answer related to Security Evaluation Models'),
                        $this->wrong('Incorrect option A for Security Evaluation Models'),
                        $this->wrong('Incorrect option B for Security Evaluation Models'),
                        $this->wrong('Incorrect option C for Security Evaluation Models'),
                    ],
                    'This question tests understanding of Security Evaluation Models and its practical applications.',
                    'medium', 'approved'),
                $this->q(
                    'What are the security implications of Security Evaluation Models?',
                    [
                        $this->correct('Correct answer related to Security Evaluation Models'),
                        $this->wrong('Incorrect option A for Security Evaluation Models'),
                        $this->wrong('Incorrect option B for Security Evaluation Models'),
                        $this->wrong('Incorrect option C for Security Evaluation Models'),
                    ],
                    'This question tests understanding of Security Evaluation Models and its practical applications.',
                    'hard', 'approved'),
            ],

            'Cryptographic Systems' => [
                $this->q(
                    'Which of the following best describes Cryptographic Systems?',
                    [
                        $this->correct('Correct answer related to Cryptographic Systems'),
                        $this->wrong('Incorrect option A for Cryptographic Systems'),
                        $this->wrong('Incorrect option B for Cryptographic Systems'),
                        $this->wrong('Incorrect option C for Cryptographic Systems'),
                    ],
                    'This question tests understanding of Cryptographic Systems and its practical applications.',
                    'easy', 'approved'),
                $this->q(
                    'What is the primary purpose of Cryptographic Systems?',
                    [
                        $this->correct('Correct answer related to Cryptographic Systems'),
                        $this->wrong('Incorrect option A for Cryptographic Systems'),
                        $this->wrong('Incorrect option B for Cryptographic Systems'),
                        $this->wrong('Incorrect option C for Cryptographic Systems'),
                    ],
                    'This question tests understanding of Cryptographic Systems and its practical applications.',
                    'easy', 'approved'),
                $this->q(
                    'What is a key benefit of implementing Cryptographic Systems?',
                    [
                        $this->correct('Correct answer related to Cryptographic Systems'),
                        $this->wrong('Incorrect option A for Cryptographic Systems'),
                        $this->wrong('Incorrect option B for Cryptographic Systems'),
                        $this->wrong('Incorrect option C for Cryptographic Systems'),
                    ],
                    'This question tests understanding of Cryptographic Systems and its practical applications.',
                    'medium', 'approved'),
                $this->q(
                    'What is a key benefit of implementing Cryptographic Systems?',
                    [
                        $this->correct('Correct answer related to Cryptographic Systems'),
                        $this->wrong('Incorrect option A for Cryptographic Systems'),
                        $this->wrong('Incorrect option B for Cryptographic Systems'),
                        $this->wrong('Incorrect option C for Cryptographic Systems'),
                    ],
                    'This question tests understanding of Cryptographic Systems and its practical applications.',
                    'medium', 'approved'),
                $this->q(
                    'Which scenario best demonstrates the use of Cryptographic Systems?',
                    [
                        $this->correct('Correct answer related to Cryptographic Systems'),
                        $this->wrong('Incorrect option A for Cryptographic Systems'),
                        $this->wrong('Incorrect option B for Cryptographic Systems'),
                        $this->wrong('Incorrect option C for Cryptographic Systems'),
                    ],
                    'This question tests understanding of Cryptographic Systems and its practical applications.',
                    'medium', 'approved'),
                $this->q(
                    'What is the best practice for implementing Cryptographic Systems at scale?',
                    [
                        $this->correct('Correct answer related to Cryptographic Systems'),
                        $this->wrong('Incorrect option A for Cryptographic Systems'),
                        $this->wrong('Incorrect option B for Cryptographic Systems'),
                        $this->wrong('Incorrect option C for Cryptographic Systems'),
                    ],
                    'This question tests understanding of Cryptographic Systems and its practical applications.',
                    'hard', 'approved'),
            ],

            'Physical Security' => [
                $this->q(
                    'Which of the following best describes Physical Security?',
                    [
                        $this->correct('Correct answer related to Physical Security'),
                        $this->wrong('Incorrect option A for Physical Security'),
                        $this->wrong('Incorrect option B for Physical Security'),
                        $this->wrong('Incorrect option C for Physical Security'),
                    ],
                    'This question tests understanding of Physical Security and its practical applications.',
                    'easy', 'approved'),
                $this->q(
                    'Which of the following best describes Physical Security?',
                    [
                        $this->correct('Correct answer related to Physical Security'),
                        $this->wrong('Incorrect option A for Physical Security'),
                        $this->wrong('Incorrect option B for Physical Security'),
                        $this->wrong('Incorrect option C for Physical Security'),
                    ],
                    'This question tests understanding of Physical Security and its practical applications.',
                    'easy', 'approved'),
                $this->q(
                    'What are the main components of Physical Security?',
                    [
                        $this->correct('Correct answer related to Physical Security'),
                        $this->wrong('Incorrect option A for Physical Security'),
                        $this->wrong('Incorrect option B for Physical Security'),
                        $this->wrong('Incorrect option C for Physical Security'),
                    ],
                    'This question tests understanding of Physical Security and its practical applications.',
                    'medium', 'approved'),
                $this->q(
                    'How does Physical Security improve system performance?',
                    [
                        $this->correct('Correct answer related to Physical Security'),
                        $this->wrong('Incorrect option A for Physical Security'),
                        $this->wrong('Incorrect option B for Physical Security'),
                        $this->wrong('Incorrect option C for Physical Security'),
                    ],
                    'This question tests understanding of Physical Security and its practical applications.',
                    'medium', 'approved'),
                $this->q(
                    'Which scenario best demonstrates the use of Physical Security?',
                    [
                        $this->correct('Correct answer related to Physical Security'),
                        $this->wrong('Incorrect option A for Physical Security'),
                        $this->wrong('Incorrect option B for Physical Security'),
                        $this->wrong('Incorrect option C for Physical Security'),
                    ],
                    'This question tests understanding of Physical Security and its practical applications.',
                    'medium', 'approved'),
                $this->q(
                    'How would you troubleshoot issues related to Physical Security?',
                    [
                        $this->correct('Correct answer related to Physical Security'),
                        $this->wrong('Incorrect option A for Physical Security'),
                        $this->wrong('Incorrect option B for Physical Security'),
                        $this->wrong('Incorrect option C for Physical Security'),
                    ],
                    'This question tests understanding of Physical Security and its practical applications.',
                    'hard', 'approved'),
            ],

            'Network Architecture' => [
                $this->q(
                    'Which of the following best describes Network Architecture?',
                    [
                        $this->correct('Correct answer related to Network Architecture'),
                        $this->wrong('Incorrect option A for Network Architecture'),
                        $this->wrong('Incorrect option B for Network Architecture'),
                        $this->wrong('Incorrect option C for Network Architecture'),
                    ],
                    'This question tests understanding of Network Architecture and its practical applications.',
                    'easy', 'approved'),
                $this->q(
                    'Which statement about Network Architecture is correct?',
                    [
                        $this->correct('Correct answer related to Network Architecture'),
                        $this->wrong('Incorrect option A for Network Architecture'),
                        $this->wrong('Incorrect option B for Network Architecture'),
                        $this->wrong('Incorrect option C for Network Architecture'),
                    ],
                    'This question tests understanding of Network Architecture and its practical applications.',
                    'easy', 'approved'),
                $this->q(
                    'What are the main components of Network Architecture?',
                    [
                        $this->correct('Correct answer related to Network Architecture'),
                        $this->wrong('Incorrect option A for Network Architecture'),
                        $this->wrong('Incorrect option B for Network Architecture'),
                        $this->wrong('Incorrect option C for Network Architecture'),
                    ],
                    'This question tests understanding of Network Architecture and its practical applications.',
                    'medium', 'approved'),
                $this->q(
                    'What are the main components of Network Architecture?',
                    [
                        $this->correct('Correct answer related to Network Architecture'),
                        $this->wrong('Incorrect option A for Network Architecture'),
                        $this->wrong('Incorrect option B for Network Architecture'),
                        $this->wrong('Incorrect option C for Network Architecture'),
                    ],
                    'This question tests understanding of Network Architecture and its practical applications.',
                    'medium', 'approved'),
                $this->q(
                    'How does Network Architecture improve system performance?',
                    [
                        $this->correct('Correct answer related to Network Architecture'),
                        $this->wrong('Incorrect option A for Network Architecture'),
                        $this->wrong('Incorrect option B for Network Architecture'),
                        $this->wrong('Incorrect option C for Network Architecture'),
                    ],
                    'This question tests understanding of Network Architecture and its practical applications.',
                    'medium', 'approved'),
                $this->q(
                    'How would you troubleshoot issues related to Network Architecture?',
                    [
                        $this->correct('Correct answer related to Network Architecture'),
                        $this->wrong('Incorrect option A for Network Architecture'),
                        $this->wrong('Incorrect option B for Network Architecture'),
                        $this->wrong('Incorrect option C for Network Architecture'),
                    ],
                    'This question tests understanding of Network Architecture and its practical applications.',
                    'hard', 'approved'),
            ],

            'Secure Network Components' => [
                $this->q(
                    'Which of the following best describes Secure Network Components?',
                    [
                        $this->correct('Correct answer related to Secure Network Components'),
                        $this->wrong('Incorrect option A for Secure Network Components'),
                        $this->wrong('Incorrect option B for Secure Network Components'),
                        $this->wrong('Incorrect option C for Secure Network Components'),
                    ],
                    'This question tests understanding of Secure Network Components and its practical applications.',
                    'easy', 'approved'),
                $this->q(
                    'Which of the following best describes Secure Network Components?',
                    [
                        $this->correct('Correct answer related to Secure Network Components'),
                        $this->wrong('Incorrect option A for Secure Network Components'),
                        $this->wrong('Incorrect option B for Secure Network Components'),
                        $this->wrong('Incorrect option C for Secure Network Components'),
                    ],
                    'This question tests understanding of Secure Network Components and its practical applications.',
                    'easy', 'approved'),
                $this->q(
                    'How does Secure Network Components improve system performance?',
                    [
                        $this->correct('Correct answer related to Secure Network Components'),
                        $this->wrong('Incorrect option A for Secure Network Components'),
                        $this->wrong('Incorrect option B for Secure Network Components'),
                        $this->wrong('Incorrect option C for Secure Network Components'),
                    ],
                    'This question tests understanding of Secure Network Components and its practical applications.',
                    'medium', 'approved'),
                $this->q(
                    'Which scenario best demonstrates the use of Secure Network Components?',
                    [
                        $this->correct('Correct answer related to Secure Network Components'),
                        $this->wrong('Incorrect option A for Secure Network Components'),
                        $this->wrong('Incorrect option B for Secure Network Components'),
                        $this->wrong('Incorrect option C for Secure Network Components'),
                    ],
                    'This question tests understanding of Secure Network Components and its practical applications.',
                    'medium', 'approved'),
                $this->q(
                    'What are the main components of Secure Network Components?',
                    [
                        $this->correct('Correct answer related to Secure Network Components'),
                        $this->wrong('Incorrect option A for Secure Network Components'),
                        $this->wrong('Incorrect option B for Secure Network Components'),
                        $this->wrong('Incorrect option C for Secure Network Components'),
                    ],
                    'This question tests understanding of Secure Network Components and its practical applications.',
                    'medium', 'approved'),
                $this->q(
                    'In a production environment, how would you optimize Secure Network Components?',
                    [
                        $this->correct('Correct answer related to Secure Network Components'),
                        $this->wrong('Incorrect option A for Secure Network Components'),
                        $this->wrong('Incorrect option B for Secure Network Components'),
                        $this->wrong('Incorrect option C for Secure Network Components'),
                    ],
                    'This question tests understanding of Secure Network Components and its practical applications.',
                    'hard', 'approved'),
            ],

            'Secure Communication Channels' => [
                $this->q(
                    'What is the primary purpose of Secure Communication Channels?',
                    [
                        $this->correct('Correct answer related to Secure Communication Channels'),
                        $this->wrong('Incorrect option A for Secure Communication Channels'),
                        $this->wrong('Incorrect option B for Secure Communication Channels'),
                        $this->wrong('Incorrect option C for Secure Communication Channels'),
                    ],
                    'This question tests understanding of Secure Communication Channels and its practical applications.',
                    'easy', 'approved'),
                $this->q(
                    'What is Secure Communication Channels used for?',
                    [
                        $this->correct('Correct answer related to Secure Communication Channels'),
                        $this->wrong('Incorrect option A for Secure Communication Channels'),
                        $this->wrong('Incorrect option B for Secure Communication Channels'),
                        $this->wrong('Incorrect option C for Secure Communication Channels'),
                    ],
                    'This question tests understanding of Secure Communication Channels and its practical applications.',
                    'easy', 'approved'),
                $this->q(
                    'Which scenario best demonstrates the use of Secure Communication Channels?',
                    [
                        $this->correct('Correct answer related to Secure Communication Channels'),
                        $this->wrong('Incorrect option A for Secure Communication Channels'),
                        $this->wrong('Incorrect option B for Secure Communication Channels'),
                        $this->wrong('Incorrect option C for Secure Communication Channels'),
                    ],
                    'This question tests understanding of Secure Communication Channels and its practical applications.',
                    'medium', 'approved'),
                $this->q(
                    'What is a key benefit of implementing Secure Communication Channels?',
                    [
                        $this->correct('Correct answer related to Secure Communication Channels'),
                        $this->wrong('Incorrect option A for Secure Communication Channels'),
                        $this->wrong('Incorrect option B for Secure Communication Channels'),
                        $this->wrong('Incorrect option C for Secure Communication Channels'),
                    ],
                    'This question tests understanding of Secure Communication Channels and its practical applications.',
                    'medium', 'approved'),
                $this->q(
                    'What are the main components of Secure Communication Channels?',
                    [
                        $this->correct('Correct answer related to Secure Communication Channels'),
                        $this->wrong('Incorrect option A for Secure Communication Channels'),
                        $this->wrong('Incorrect option B for Secure Communication Channels'),
                        $this->wrong('Incorrect option C for Secure Communication Channels'),
                    ],
                    'This question tests understanding of Secure Communication Channels and its practical applications.',
                    'medium', 'approved'),
                $this->q(
                    'What are the security implications of Secure Communication Channels?',
                    [
                        $this->correct('Correct answer related to Secure Communication Channels'),
                        $this->wrong('Incorrect option A for Secure Communication Channels'),
                        $this->wrong('Incorrect option B for Secure Communication Channels'),
                        $this->wrong('Incorrect option C for Secure Communication Channels'),
                    ],
                    'This question tests understanding of Secure Communication Channels and its practical applications.',
                    'hard', 'approved'),
            ],

            'Network Attacks' => [
                $this->q(
                    'What is the primary purpose of Network Attacks?',
                    [
                        $this->correct('Correct answer related to Network Attacks'),
                        $this->wrong('Incorrect option A for Network Attacks'),
                        $this->wrong('Incorrect option B for Network Attacks'),
                        $this->wrong('Incorrect option C for Network Attacks'),
                    ],
                    'This question tests understanding of Network Attacks and its practical applications.',
                    'easy', 'approved'),
                $this->q(
                    'What is the primary purpose of Network Attacks?',
                    [
                        $this->correct('Correct answer related to Network Attacks'),
                        $this->wrong('Incorrect option A for Network Attacks'),
                        $this->wrong('Incorrect option B for Network Attacks'),
                        $this->wrong('Incorrect option C for Network Attacks'),
                    ],
                    'This question tests understanding of Network Attacks and its practical applications.',
                    'easy', 'approved'),
                $this->q(
                    'What is a key benefit of implementing Network Attacks?',
                    [
                        $this->correct('Correct answer related to Network Attacks'),
                        $this->wrong('Incorrect option A for Network Attacks'),
                        $this->wrong('Incorrect option B for Network Attacks'),
                        $this->wrong('Incorrect option C for Network Attacks'),
                    ],
                    'This question tests understanding of Network Attacks and its practical applications.',
                    'medium', 'approved'),
                $this->q(
                    'What are the main components of Network Attacks?',
                    [
                        $this->correct('Correct answer related to Network Attacks'),
                        $this->wrong('Incorrect option A for Network Attacks'),
                        $this->wrong('Incorrect option B for Network Attacks'),
                        $this->wrong('Incorrect option C for Network Attacks'),
                    ],
                    'This question tests understanding of Network Attacks and its practical applications.',
                    'medium', 'approved'),
                $this->q(
                    'What are the main components of Network Attacks?',
                    [
                        $this->correct('Correct answer related to Network Attacks'),
                        $this->wrong('Incorrect option A for Network Attacks'),
                        $this->wrong('Incorrect option B for Network Attacks'),
                        $this->wrong('Incorrect option C for Network Attacks'),
                    ],
                    'This question tests understanding of Network Attacks and its practical applications.',
                    'medium', 'approved'),
                $this->q(
                    'How would you troubleshoot issues related to Network Attacks?',
                    [
                        $this->correct('Correct answer related to Network Attacks'),
                        $this->wrong('Incorrect option A for Network Attacks'),
                        $this->wrong('Incorrect option B for Network Attacks'),
                        $this->wrong('Incorrect option C for Network Attacks'),
                    ],
                    'This question tests understanding of Network Attacks and its practical applications.',
                    'hard', 'approved'),
            ],

            'Wireless Security' => [
                $this->q(
                    'What is Wireless Security used for?',
                    [
                        $this->correct('Correct answer related to Wireless Security'),
                        $this->wrong('Incorrect option A for Wireless Security'),
                        $this->wrong('Incorrect option B for Wireless Security'),
                        $this->wrong('Incorrect option C for Wireless Security'),
                    ],
                    'This question tests understanding of Wireless Security and its practical applications.',
                    'easy', 'approved'),
                $this->q(
                    'What is Wireless Security used for?',
                    [
                        $this->correct('Correct answer related to Wireless Security'),
                        $this->wrong('Incorrect option A for Wireless Security'),
                        $this->wrong('Incorrect option B for Wireless Security'),
                        $this->wrong('Incorrect option C for Wireless Security'),
                    ],
                    'This question tests understanding of Wireless Security and its practical applications.',
                    'easy', 'approved'),
                $this->q(
                    'What are the main components of Wireless Security?',
                    [
                        $this->correct('Correct answer related to Wireless Security'),
                        $this->wrong('Incorrect option A for Wireless Security'),
                        $this->wrong('Incorrect option B for Wireless Security'),
                        $this->wrong('Incorrect option C for Wireless Security'),
                    ],
                    'This question tests understanding of Wireless Security and its practical applications.',
                    'medium', 'approved'),
                $this->q(
                    'What are the main components of Wireless Security?',
                    [
                        $this->correct('Correct answer related to Wireless Security'),
                        $this->wrong('Incorrect option A for Wireless Security'),
                        $this->wrong('Incorrect option B for Wireless Security'),
                        $this->wrong('Incorrect option C for Wireless Security'),
                    ],
                    'This question tests understanding of Wireless Security and its practical applications.',
                    'medium', 'approved'),
                $this->q(
                    'What is a key benefit of implementing Wireless Security?',
                    [
                        $this->correct('Correct answer related to Wireless Security'),
                        $this->wrong('Incorrect option A for Wireless Security'),
                        $this->wrong('Incorrect option B for Wireless Security'),
                        $this->wrong('Incorrect option C for Wireless Security'),
                    ],
                    'This question tests understanding of Wireless Security and its practical applications.',
                    'medium', 'approved'),
                $this->q(
                    'In a production environment, how would you optimize Wireless Security?',
                    [
                        $this->correct('Correct answer related to Wireless Security'),
                        $this->wrong('Incorrect option A for Wireless Security'),
                        $this->wrong('Incorrect option B for Wireless Security'),
                        $this->wrong('Incorrect option C for Wireless Security'),
                    ],
                    'This question tests understanding of Wireless Security and its practical applications.',
                    'hard', 'approved'),
            ],

            'Physical Access Control' => [
                $this->q(
                    'What is the primary purpose of Physical Access Control?',
                    [
                        $this->correct('Correct answer related to Physical Access Control'),
                        $this->wrong('Incorrect option A for Physical Access Control'),
                        $this->wrong('Incorrect option B for Physical Access Control'),
                        $this->wrong('Incorrect option C for Physical Access Control'),
                    ],
                    'This question tests understanding of Physical Access Control and its practical applications.',
                    'easy', 'approved'),
                $this->q(
                    'What is the primary purpose of Physical Access Control?',
                    [
                        $this->correct('Correct answer related to Physical Access Control'),
                        $this->wrong('Incorrect option A for Physical Access Control'),
                        $this->wrong('Incorrect option B for Physical Access Control'),
                        $this->wrong('Incorrect option C for Physical Access Control'),
                    ],
                    'This question tests understanding of Physical Access Control and its practical applications.',
                    'easy', 'approved'),
                $this->q(
                    'How does Physical Access Control improve system performance?',
                    [
                        $this->correct('Correct answer related to Physical Access Control'),
                        $this->wrong('Incorrect option A for Physical Access Control'),
                        $this->wrong('Incorrect option B for Physical Access Control'),
                        $this->wrong('Incorrect option C for Physical Access Control'),
                    ],
                    'This question tests understanding of Physical Access Control and its practical applications.',
                    'medium', 'approved'),
                $this->q(
                    'How does Physical Access Control improve system performance?',
                    [
                        $this->correct('Correct answer related to Physical Access Control'),
                        $this->wrong('Incorrect option A for Physical Access Control'),
                        $this->wrong('Incorrect option B for Physical Access Control'),
                        $this->wrong('Incorrect option C for Physical Access Control'),
                    ],
                    'This question tests understanding of Physical Access Control and its practical applications.',
                    'medium', 'approved'),
                $this->q(
                    'What is a key benefit of implementing Physical Access Control?',
                    [
                        $this->correct('Correct answer related to Physical Access Control'),
                        $this->wrong('Incorrect option A for Physical Access Control'),
                        $this->wrong('Incorrect option B for Physical Access Control'),
                        $this->wrong('Incorrect option C for Physical Access Control'),
                    ],
                    'This question tests understanding of Physical Access Control and its practical applications.',
                    'medium', 'approved'),
                $this->q(
                    'How would you troubleshoot issues related to Physical Access Control?',
                    [
                        $this->correct('Correct answer related to Physical Access Control'),
                        $this->wrong('Incorrect option A for Physical Access Control'),
                        $this->wrong('Incorrect option B for Physical Access Control'),
                        $this->wrong('Incorrect option C for Physical Access Control'),
                    ],
                    'This question tests understanding of Physical Access Control and its practical applications.',
                    'hard', 'approved'),
            ],

            'Logical Access Control' => [
                $this->q(
                    'Which statement about Logical Access Control is correct?',
                    [
                        $this->correct('Correct answer related to Logical Access Control'),
                        $this->wrong('Incorrect option A for Logical Access Control'),
                        $this->wrong('Incorrect option B for Logical Access Control'),
                        $this->wrong('Incorrect option C for Logical Access Control'),
                    ],
                    'This question tests understanding of Logical Access Control and its practical applications.',
                    'easy', 'approved'),
                $this->q(
                    'What is Logical Access Control used for?',
                    [
                        $this->correct('Correct answer related to Logical Access Control'),
                        $this->wrong('Incorrect option A for Logical Access Control'),
                        $this->wrong('Incorrect option B for Logical Access Control'),
                        $this->wrong('Incorrect option C for Logical Access Control'),
                    ],
                    'This question tests understanding of Logical Access Control and its practical applications.',
                    'easy', 'approved'),
                $this->q(
                    'How does Logical Access Control improve system performance?',
                    [
                        $this->correct('Correct answer related to Logical Access Control'),
                        $this->wrong('Incorrect option A for Logical Access Control'),
                        $this->wrong('Incorrect option B for Logical Access Control'),
                        $this->wrong('Incorrect option C for Logical Access Control'),
                    ],
                    'This question tests understanding of Logical Access Control and its practical applications.',
                    'medium', 'approved'),
                $this->q(
                    'What is a key benefit of implementing Logical Access Control?',
                    [
                        $this->correct('Correct answer related to Logical Access Control'),
                        $this->wrong('Incorrect option A for Logical Access Control'),
                        $this->wrong('Incorrect option B for Logical Access Control'),
                        $this->wrong('Incorrect option C for Logical Access Control'),
                    ],
                    'This question tests understanding of Logical Access Control and its practical applications.',
                    'medium', 'approved'),
                $this->q(
                    'Which scenario best demonstrates the use of Logical Access Control?',
                    [
                        $this->correct('Correct answer related to Logical Access Control'),
                        $this->wrong('Incorrect option A for Logical Access Control'),
                        $this->wrong('Incorrect option B for Logical Access Control'),
                        $this->wrong('Incorrect option C for Logical Access Control'),
                    ],
                    'This question tests understanding of Logical Access Control and its practical applications.',
                    'medium', 'approved'),
                $this->q(
                    'What are the security implications of Logical Access Control?',
                    [
                        $this->correct('Correct answer related to Logical Access Control'),
                        $this->wrong('Incorrect option A for Logical Access Control'),
                        $this->wrong('Incorrect option B for Logical Access Control'),
                        $this->wrong('Incorrect option C for Logical Access Control'),
                    ],
                    'This question tests understanding of Logical Access Control and its practical applications.',
                    'hard', 'approved'),
            ],

            'Identity Management' => [
                $this->q(
                    'What is Identity Management used for?',
                    [
                        $this->correct('Correct answer related to Identity Management'),
                        $this->wrong('Incorrect option A for Identity Management'),
                        $this->wrong('Incorrect option B for Identity Management'),
                        $this->wrong('Incorrect option C for Identity Management'),
                    ],
                    'This question tests understanding of Identity Management and its practical applications.',
                    'easy', 'approved'),
                $this->q(
                    'Which statement about Identity Management is correct?',
                    [
                        $this->correct('Correct answer related to Identity Management'),
                        $this->wrong('Incorrect option A for Identity Management'),
                        $this->wrong('Incorrect option B for Identity Management'),
                        $this->wrong('Incorrect option C for Identity Management'),
                    ],
                    'This question tests understanding of Identity Management and its practical applications.',
                    'easy', 'approved'),
                $this->q(
                    'What are the main components of Identity Management?',
                    [
                        $this->correct('Correct answer related to Identity Management'),
                        $this->wrong('Incorrect option A for Identity Management'),
                        $this->wrong('Incorrect option B for Identity Management'),
                        $this->wrong('Incorrect option C for Identity Management'),
                    ],
                    'This question tests understanding of Identity Management and its practical applications.',
                    'medium', 'approved'),
                $this->q(
                    'How does Identity Management improve system performance?',
                    [
                        $this->correct('Correct answer related to Identity Management'),
                        $this->wrong('Incorrect option A for Identity Management'),
                        $this->wrong('Incorrect option B for Identity Management'),
                        $this->wrong('Incorrect option C for Identity Management'),
                    ],
                    'This question tests understanding of Identity Management and its practical applications.',
                    'medium', 'approved'),
                $this->q(
                    'Which scenario best demonstrates the use of Identity Management?',
                    [
                        $this->correct('Correct answer related to Identity Management'),
                        $this->wrong('Incorrect option A for Identity Management'),
                        $this->wrong('Incorrect option B for Identity Management'),
                        $this->wrong('Incorrect option C for Identity Management'),
                    ],
                    'This question tests understanding of Identity Management and its practical applications.',
                    'medium', 'approved'),
                $this->q(
                    'How would you troubleshoot issues related to Identity Management?',
                    [
                        $this->correct('Correct answer related to Identity Management'),
                        $this->wrong('Incorrect option A for Identity Management'),
                        $this->wrong('Incorrect option B for Identity Management'),
                        $this->wrong('Incorrect option C for Identity Management'),
                    ],
                    'This question tests understanding of Identity Management and its practical applications.',
                    'hard', 'approved'),
            ],

            'Access Control Models' => [
                $this->q(
                    'Which of the following best describes Access Control Models?',
                    [
                        $this->correct('Correct answer related to Access Control Models'),
                        $this->wrong('Incorrect option A for Access Control Models'),
                        $this->wrong('Incorrect option B for Access Control Models'),
                        $this->wrong('Incorrect option C for Access Control Models'),
                    ],
                    'This question tests understanding of Access Control Models and its practical applications.',
                    'easy', 'approved'),
                $this->q(
                    'What is Access Control Models used for?',
                    [
                        $this->correct('Correct answer related to Access Control Models'),
                        $this->wrong('Incorrect option A for Access Control Models'),
                        $this->wrong('Incorrect option B for Access Control Models'),
                        $this->wrong('Incorrect option C for Access Control Models'),
                    ],
                    'This question tests understanding of Access Control Models and its practical applications.',
                    'easy', 'approved'),
                $this->q(
                    'Which scenario best demonstrates the use of Access Control Models?',
                    [
                        $this->correct('Correct answer related to Access Control Models'),
                        $this->wrong('Incorrect option A for Access Control Models'),
                        $this->wrong('Incorrect option B for Access Control Models'),
                        $this->wrong('Incorrect option C for Access Control Models'),
                    ],
                    'This question tests understanding of Access Control Models and its practical applications.',
                    'medium', 'approved'),
                $this->q(
                    'What are the main components of Access Control Models?',
                    [
                        $this->correct('Correct answer related to Access Control Models'),
                        $this->wrong('Incorrect option A for Access Control Models'),
                        $this->wrong('Incorrect option B for Access Control Models'),
                        $this->wrong('Incorrect option C for Access Control Models'),
                    ],
                    'This question tests understanding of Access Control Models and its practical applications.',
                    'medium', 'approved'),
                $this->q(
                    'Which scenario best demonstrates the use of Access Control Models?',
                    [
                        $this->correct('Correct answer related to Access Control Models'),
                        $this->wrong('Incorrect option A for Access Control Models'),
                        $this->wrong('Incorrect option B for Access Control Models'),
                        $this->wrong('Incorrect option C for Access Control Models'),
                    ],
                    'This question tests understanding of Access Control Models and its practical applications.',
                    'medium', 'approved'),
                $this->q(
                    'How would you troubleshoot issues related to Access Control Models?',
                    [
                        $this->correct('Correct answer related to Access Control Models'),
                        $this->wrong('Incorrect option A for Access Control Models'),
                        $this->wrong('Incorrect option B for Access Control Models'),
                        $this->wrong('Incorrect option C for Access Control Models'),
                    ],
                    'This question tests understanding of Access Control Models and its practical applications.',
                    'hard', 'approved'),
            ],

            'Single Sign-On and Federation' => [
                $this->q(
                    'Which of the following best describes Single Sign-On and Federation?',
                    [
                        $this->correct('Correct answer related to Single Sign-On and Federation'),
                        $this->wrong('Incorrect option A for Single Sign-On and Federation'),
                        $this->wrong('Incorrect option B for Single Sign-On and Federation'),
                        $this->wrong('Incorrect option C for Single Sign-On and Federation'),
                    ],
                    'This question tests understanding of Single Sign-On and Federation and its practical applications.',
                    'easy', 'approved'),
                $this->q(
                    'Which statement about Single Sign-On and Federation is correct?',
                    [
                        $this->correct('Correct answer related to Single Sign-On and Federation'),
                        $this->wrong('Incorrect option A for Single Sign-On and Federation'),
                        $this->wrong('Incorrect option B for Single Sign-On and Federation'),
                        $this->wrong('Incorrect option C for Single Sign-On and Federation'),
                    ],
                    'This question tests understanding of Single Sign-On and Federation and its practical applications.',
                    'easy', 'approved'),
                $this->q(
                    'What is a key benefit of implementing Single Sign-On and Federation?',
                    [
                        $this->correct('Correct answer related to Single Sign-On and Federation'),
                        $this->wrong('Incorrect option A for Single Sign-On and Federation'),
                        $this->wrong('Incorrect option B for Single Sign-On and Federation'),
                        $this->wrong('Incorrect option C for Single Sign-On and Federation'),
                    ],
                    'This question tests understanding of Single Sign-On and Federation and its practical applications.',
                    'medium', 'approved'),
                $this->q(
                    'What is a key benefit of implementing Single Sign-On and Federation?',
                    [
                        $this->correct('Correct answer related to Single Sign-On and Federation'),
                        $this->wrong('Incorrect option A for Single Sign-On and Federation'),
                        $this->wrong('Incorrect option B for Single Sign-On and Federation'),
                        $this->wrong('Incorrect option C for Single Sign-On and Federation'),
                    ],
                    'This question tests understanding of Single Sign-On and Federation and its practical applications.',
                    'medium', 'approved'),
                $this->q(
                    'How does Single Sign-On and Federation improve system performance?',
                    [
                        $this->correct('Correct answer related to Single Sign-On and Federation'),
                        $this->wrong('Incorrect option A for Single Sign-On and Federation'),
                        $this->wrong('Incorrect option B for Single Sign-On and Federation'),
                        $this->wrong('Incorrect option C for Single Sign-On and Federation'),
                    ],
                    'This question tests understanding of Single Sign-On and Federation and its practical applications.',
                    'medium', 'approved'),
                $this->q(
                    'How would you troubleshoot issues related to Single Sign-On and Federation?',
                    [
                        $this->correct('Correct answer related to Single Sign-On and Federation'),
                        $this->wrong('Incorrect option A for Single Sign-On and Federation'),
                        $this->wrong('Incorrect option B for Single Sign-On and Federation'),
                        $this->wrong('Incorrect option C for Single Sign-On and Federation'),
                    ],
                    'This question tests understanding of Single Sign-On and Federation and its practical applications.',
                    'hard', 'approved'),
            ],

            'Assessment and Testing Strategies' => [
                $this->q(
                    'Which statement about Assessment and Testing Strategies is correct?',
                    [
                        $this->correct('Correct answer related to Assessment and Testing Strategies'),
                        $this->wrong('Incorrect option A for Assessment and Testing Strategies'),
                        $this->wrong('Incorrect option B for Assessment and Testing Strategies'),
                        $this->wrong('Incorrect option C for Assessment and Testing Strategies'),
                    ],
                    'This question tests understanding of Assessment and Testing Strategies and its practical applications.',
                    'easy', 'approved'),
                $this->q(
                    'What is Assessment and Testing Strategies used for?',
                    [
                        $this->correct('Correct answer related to Assessment and Testing Strategies'),
                        $this->wrong('Incorrect option A for Assessment and Testing Strategies'),
                        $this->wrong('Incorrect option B for Assessment and Testing Strategies'),
                        $this->wrong('Incorrect option C for Assessment and Testing Strategies'),
                    ],
                    'This question tests understanding of Assessment and Testing Strategies and its practical applications.',
                    'easy', 'approved'),
                $this->q(
                    'How does Assessment and Testing Strategies improve system performance?',
                    [
                        $this->correct('Correct answer related to Assessment and Testing Strategies'),
                        $this->wrong('Incorrect option A for Assessment and Testing Strategies'),
                        $this->wrong('Incorrect option B for Assessment and Testing Strategies'),
                        $this->wrong('Incorrect option C for Assessment and Testing Strategies'),
                    ],
                    'This question tests understanding of Assessment and Testing Strategies and its practical applications.',
                    'medium', 'approved'),
                $this->q(
                    'What is a key benefit of implementing Assessment and Testing Strategies?',
                    [
                        $this->correct('Correct answer related to Assessment and Testing Strategies'),
                        $this->wrong('Incorrect option A for Assessment and Testing Strategies'),
                        $this->wrong('Incorrect option B for Assessment and Testing Strategies'),
                        $this->wrong('Incorrect option C for Assessment and Testing Strategies'),
                    ],
                    'This question tests understanding of Assessment and Testing Strategies and its practical applications.',
                    'medium', 'approved'),
                $this->q(
                    'What is a key benefit of implementing Assessment and Testing Strategies?',
                    [
                        $this->correct('Correct answer related to Assessment and Testing Strategies'),
                        $this->wrong('Incorrect option A for Assessment and Testing Strategies'),
                        $this->wrong('Incorrect option B for Assessment and Testing Strategies'),
                        $this->wrong('Incorrect option C for Assessment and Testing Strategies'),
                    ],
                    'This question tests understanding of Assessment and Testing Strategies and its practical applications.',
                    'medium', 'approved'),
                $this->q(
                    'What are the security implications of Assessment and Testing Strategies?',
                    [
                        $this->correct('Correct answer related to Assessment and Testing Strategies'),
                        $this->wrong('Incorrect option A for Assessment and Testing Strategies'),
                        $this->wrong('Incorrect option B for Assessment and Testing Strategies'),
                        $this->wrong('Incorrect option C for Assessment and Testing Strategies'),
                    ],
                    'This question tests understanding of Assessment and Testing Strategies and its practical applications.',
                    'hard', 'approved'),
            ],

            'Security Control Testing' => [
                $this->q(
                    'Which of the following best describes Security Control Testing?',
                    [
                        $this->correct('Correct answer related to Security Control Testing'),
                        $this->wrong('Incorrect option A for Security Control Testing'),
                        $this->wrong('Incorrect option B for Security Control Testing'),
                        $this->wrong('Incorrect option C for Security Control Testing'),
                    ],
                    'This question tests understanding of Security Control Testing and its practical applications.',
                    'easy', 'approved'),
                $this->q(
                    'What is Security Control Testing used for?',
                    [
                        $this->correct('Correct answer related to Security Control Testing'),
                        $this->wrong('Incorrect option A for Security Control Testing'),
                        $this->wrong('Incorrect option B for Security Control Testing'),
                        $this->wrong('Incorrect option C for Security Control Testing'),
                    ],
                    'This question tests understanding of Security Control Testing and its practical applications.',
                    'easy', 'approved'),
                $this->q(
                    'Which scenario best demonstrates the use of Security Control Testing?',
                    [
                        $this->correct('Correct answer related to Security Control Testing'),
                        $this->wrong('Incorrect option A for Security Control Testing'),
                        $this->wrong('Incorrect option B for Security Control Testing'),
                        $this->wrong('Incorrect option C for Security Control Testing'),
                    ],
                    'This question tests understanding of Security Control Testing and its practical applications.',
                    'medium', 'approved'),
                $this->q(
                    'What is a key benefit of implementing Security Control Testing?',
                    [
                        $this->correct('Correct answer related to Security Control Testing'),
                        $this->wrong('Incorrect option A for Security Control Testing'),
                        $this->wrong('Incorrect option B for Security Control Testing'),
                        $this->wrong('Incorrect option C for Security Control Testing'),
                    ],
                    'This question tests understanding of Security Control Testing and its practical applications.',
                    'medium', 'approved'),
                $this->q(
                    'What is a key benefit of implementing Security Control Testing?',
                    [
                        $this->correct('Correct answer related to Security Control Testing'),
                        $this->wrong('Incorrect option A for Security Control Testing'),
                        $this->wrong('Incorrect option B for Security Control Testing'),
                        $this->wrong('Incorrect option C for Security Control Testing'),
                    ],
                    'This question tests understanding of Security Control Testing and its practical applications.',
                    'medium', 'approved'),
                $this->q(
                    'In a production environment, how would you optimize Security Control Testing?',
                    [
                        $this->correct('Correct answer related to Security Control Testing'),
                        $this->wrong('Incorrect option A for Security Control Testing'),
                        $this->wrong('Incorrect option B for Security Control Testing'),
                        $this->wrong('Incorrect option C for Security Control Testing'),
                    ],
                    'This question tests understanding of Security Control Testing and its practical applications.',
                    'hard', 'approved'),
            ],

            'Security Audits' => [
                $this->q(
                    'What is the primary purpose of Security Audits?',
                    [
                        $this->correct('Correct answer related to Security Audits'),
                        $this->wrong('Incorrect option A for Security Audits'),
                        $this->wrong('Incorrect option B for Security Audits'),
                        $this->wrong('Incorrect option C for Security Audits'),
                    ],
                    'This question tests understanding of Security Audits and its practical applications.',
                    'easy', 'approved'),
                $this->q(
                    'Which of the following best describes Security Audits?',
                    [
                        $this->correct('Correct answer related to Security Audits'),
                        $this->wrong('Incorrect option A for Security Audits'),
                        $this->wrong('Incorrect option B for Security Audits'),
                        $this->wrong('Incorrect option C for Security Audits'),
                    ],
                    'This question tests understanding of Security Audits and its practical applications.',
                    'easy', 'approved'),
                $this->q(
                    'How does Security Audits improve system performance?',
                    [
                        $this->correct('Correct answer related to Security Audits'),
                        $this->wrong('Incorrect option A for Security Audits'),
                        $this->wrong('Incorrect option B for Security Audits'),
                        $this->wrong('Incorrect option C for Security Audits'),
                    ],
                    'This question tests understanding of Security Audits and its practical applications.',
                    'medium', 'approved'),
                $this->q(
                    'How does Security Audits improve system performance?',
                    [
                        $this->correct('Correct answer related to Security Audits'),
                        $this->wrong('Incorrect option A for Security Audits'),
                        $this->wrong('Incorrect option B for Security Audits'),
                        $this->wrong('Incorrect option C for Security Audits'),
                    ],
                    'This question tests understanding of Security Audits and its practical applications.',
                    'medium', 'approved'),
                $this->q(
                    'Which scenario best demonstrates the use of Security Audits?',
                    [
                        $this->correct('Correct answer related to Security Audits'),
                        $this->wrong('Incorrect option A for Security Audits'),
                        $this->wrong('Incorrect option B for Security Audits'),
                        $this->wrong('Incorrect option C for Security Audits'),
                    ],
                    'This question tests understanding of Security Audits and its practical applications.',
                    'medium', 'approved'),
                $this->q(
                    'In a production environment, how would you optimize Security Audits?',
                    [
                        $this->correct('Correct answer related to Security Audits'),
                        $this->wrong('Incorrect option A for Security Audits'),
                        $this->wrong('Incorrect option B for Security Audits'),
                        $this->wrong('Incorrect option C for Security Audits'),
                    ],
                    'This question tests understanding of Security Audits and its practical applications.',
                    'hard', 'approved'),
            ],

            'Vulnerability Assessment Tools' => [
                $this->q(
                    'Which of the following best describes Vulnerability Assessment Tools?',
                    [
                        $this->correct('Correct answer related to Vulnerability Assessment Tools'),
                        $this->wrong('Incorrect option A for Vulnerability Assessment Tools'),
                        $this->wrong('Incorrect option B for Vulnerability Assessment Tools'),
                        $this->wrong('Incorrect option C for Vulnerability Assessment Tools'),
                    ],
                    'This question tests understanding of Vulnerability Assessment Tools and its practical applications.',
                    'easy', 'approved'),
                $this->q(
                    'What is the primary purpose of Vulnerability Assessment Tools?',
                    [
                        $this->correct('Correct answer related to Vulnerability Assessment Tools'),
                        $this->wrong('Incorrect option A for Vulnerability Assessment Tools'),
                        $this->wrong('Incorrect option B for Vulnerability Assessment Tools'),
                        $this->wrong('Incorrect option C for Vulnerability Assessment Tools'),
                    ],
                    'This question tests understanding of Vulnerability Assessment Tools and its practical applications.',
                    'easy', 'approved'),
                $this->q(
                    'What is a key benefit of implementing Vulnerability Assessment Tools?',
                    [
                        $this->correct('Correct answer related to Vulnerability Assessment Tools'),
                        $this->wrong('Incorrect option A for Vulnerability Assessment Tools'),
                        $this->wrong('Incorrect option B for Vulnerability Assessment Tools'),
                        $this->wrong('Incorrect option C for Vulnerability Assessment Tools'),
                    ],
                    'This question tests understanding of Vulnerability Assessment Tools and its practical applications.',
                    'medium', 'approved'),
                $this->q(
                    'What are the main components of Vulnerability Assessment Tools?',
                    [
                        $this->correct('Correct answer related to Vulnerability Assessment Tools'),
                        $this->wrong('Incorrect option A for Vulnerability Assessment Tools'),
                        $this->wrong('Incorrect option B for Vulnerability Assessment Tools'),
                        $this->wrong('Incorrect option C for Vulnerability Assessment Tools'),
                    ],
                    'This question tests understanding of Vulnerability Assessment Tools and its practical applications.',
                    'medium', 'approved'),
                $this->q(
                    'How does Vulnerability Assessment Tools improve system performance?',
                    [
                        $this->correct('Correct answer related to Vulnerability Assessment Tools'),
                        $this->wrong('Incorrect option A for Vulnerability Assessment Tools'),
                        $this->wrong('Incorrect option B for Vulnerability Assessment Tools'),
                        $this->wrong('Incorrect option C for Vulnerability Assessment Tools'),
                    ],
                    'This question tests understanding of Vulnerability Assessment Tools and its practical applications.',
                    'medium', 'approved'),
                $this->q(
                    'In a production environment, how would you optimize Vulnerability Assessment Tools?',
                    [
                        $this->correct('Correct answer related to Vulnerability Assessment Tools'),
                        $this->wrong('Incorrect option A for Vulnerability Assessment Tools'),
                        $this->wrong('Incorrect option B for Vulnerability Assessment Tools'),
                        $this->wrong('Incorrect option C for Vulnerability Assessment Tools'),
                    ],
                    'This question tests understanding of Vulnerability Assessment Tools and its practical applications.',
                    'hard', 'approved'),
            ],

            'Test Output Analysis' => [
                $this->q(
                    'What is Test Output Analysis used for?',
                    [
                        $this->correct('Correct answer related to Test Output Analysis'),
                        $this->wrong('Incorrect option A for Test Output Analysis'),
                        $this->wrong('Incorrect option B for Test Output Analysis'),
                        $this->wrong('Incorrect option C for Test Output Analysis'),
                    ],
                    'This question tests understanding of Test Output Analysis and its practical applications.',
                    'easy', 'approved'),
                $this->q(
                    'What is the primary purpose of Test Output Analysis?',
                    [
                        $this->correct('Correct answer related to Test Output Analysis'),
                        $this->wrong('Incorrect option A for Test Output Analysis'),
                        $this->wrong('Incorrect option B for Test Output Analysis'),
                        $this->wrong('Incorrect option C for Test Output Analysis'),
                    ],
                    'This question tests understanding of Test Output Analysis and its practical applications.',
                    'easy', 'approved'),
                $this->q(
                    'What are the main components of Test Output Analysis?',
                    [
                        $this->correct('Correct answer related to Test Output Analysis'),
                        $this->wrong('Incorrect option A for Test Output Analysis'),
                        $this->wrong('Incorrect option B for Test Output Analysis'),
                        $this->wrong('Incorrect option C for Test Output Analysis'),
                    ],
                    'This question tests understanding of Test Output Analysis and its practical applications.',
                    'medium', 'approved'),
                $this->q(
                    'What is a key benefit of implementing Test Output Analysis?',
                    [
                        $this->correct('Correct answer related to Test Output Analysis'),
                        $this->wrong('Incorrect option A for Test Output Analysis'),
                        $this->wrong('Incorrect option B for Test Output Analysis'),
                        $this->wrong('Incorrect option C for Test Output Analysis'),
                    ],
                    'This question tests understanding of Test Output Analysis and its practical applications.',
                    'medium', 'approved'),
                $this->q(
                    'Which scenario best demonstrates the use of Test Output Analysis?',
                    [
                        $this->correct('Correct answer related to Test Output Analysis'),
                        $this->wrong('Incorrect option A for Test Output Analysis'),
                        $this->wrong('Incorrect option B for Test Output Analysis'),
                        $this->wrong('Incorrect option C for Test Output Analysis'),
                    ],
                    'This question tests understanding of Test Output Analysis and its practical applications.',
                    'medium', 'approved'),
                $this->q(
                    'In a production environment, how would you optimize Test Output Analysis?',
                    [
                        $this->correct('Correct answer related to Test Output Analysis'),
                        $this->wrong('Incorrect option A for Test Output Analysis'),
                        $this->wrong('Incorrect option B for Test Output Analysis'),
                        $this->wrong('Incorrect option C for Test Output Analysis'),
                    ],
                    'This question tests understanding of Test Output Analysis and its practical applications.',
                    'hard', 'approved'),
            ],

            'Investigations' => [
                $this->q(
                    'Which statement about Investigations is correct?',
                    [
                        $this->correct('Correct answer related to Investigations'),
                        $this->wrong('Incorrect option A for Investigations'),
                        $this->wrong('Incorrect option B for Investigations'),
                        $this->wrong('Incorrect option C for Investigations'),
                    ],
                    'This question tests understanding of Investigations and its practical applications.',
                    'easy', 'approved'),
                $this->q(
                    'What is Investigations used for?',
                    [
                        $this->correct('Correct answer related to Investigations'),
                        $this->wrong('Incorrect option A for Investigations'),
                        $this->wrong('Incorrect option B for Investigations'),
                        $this->wrong('Incorrect option C for Investigations'),
                    ],
                    'This question tests understanding of Investigations and its practical applications.',
                    'easy', 'approved'),
                $this->q(
                    'How does Investigations improve system performance?',
                    [
                        $this->correct('Correct answer related to Investigations'),
                        $this->wrong('Incorrect option A for Investigations'),
                        $this->wrong('Incorrect option B for Investigations'),
                        $this->wrong('Incorrect option C for Investigations'),
                    ],
                    'This question tests understanding of Investigations and its practical applications.',
                    'medium', 'approved'),
                $this->q(
                    'What are the main components of Investigations?',
                    [
                        $this->correct('Correct answer related to Investigations'),
                        $this->wrong('Incorrect option A for Investigations'),
                        $this->wrong('Incorrect option B for Investigations'),
                        $this->wrong('Incorrect option C for Investigations'),
                    ],
                    'This question tests understanding of Investigations and its practical applications.',
                    'medium', 'approved'),
                $this->q(
                    'What are the main components of Investigations?',
                    [
                        $this->correct('Correct answer related to Investigations'),
                        $this->wrong('Incorrect option A for Investigations'),
                        $this->wrong('Incorrect option B for Investigations'),
                        $this->wrong('Incorrect option C for Investigations'),
                    ],
                    'This question tests understanding of Investigations and its practical applications.',
                    'medium', 'approved'),
                $this->q(
                    'How would you troubleshoot issues related to Investigations?',
                    [
                        $this->correct('Correct answer related to Investigations'),
                        $this->wrong('Incorrect option A for Investigations'),
                        $this->wrong('Incorrect option B for Investigations'),
                        $this->wrong('Incorrect option C for Investigations'),
                    ],
                    'This question tests understanding of Investigations and its practical applications.',
                    'hard', 'approved'),
            ],

            'Logging and Monitoring' => [
                $this->q(
                    'What is the primary purpose of Logging and Monitoring?',
                    [
                        $this->correct('Correct answer related to Logging and Monitoring'),
                        $this->wrong('Incorrect option A for Logging and Monitoring'),
                        $this->wrong('Incorrect option B for Logging and Monitoring'),
                        $this->wrong('Incorrect option C for Logging and Monitoring'),
                    ],
                    'This question tests understanding of Logging and Monitoring and its practical applications.',
                    'easy', 'approved'),
                $this->q(
                    'What is Logging and Monitoring used for?',
                    [
                        $this->correct('Correct answer related to Logging and Monitoring'),
                        $this->wrong('Incorrect option A for Logging and Monitoring'),
                        $this->wrong('Incorrect option B for Logging and Monitoring'),
                        $this->wrong('Incorrect option C for Logging and Monitoring'),
                    ],
                    'This question tests understanding of Logging and Monitoring and its practical applications.',
                    'easy', 'approved'),
                $this->q(
                    'What are the main components of Logging and Monitoring?',
                    [
                        $this->correct('Correct answer related to Logging and Monitoring'),
                        $this->wrong('Incorrect option A for Logging and Monitoring'),
                        $this->wrong('Incorrect option B for Logging and Monitoring'),
                        $this->wrong('Incorrect option C for Logging and Monitoring'),
                    ],
                    'This question tests understanding of Logging and Monitoring and its practical applications.',
                    'medium', 'approved'),
                $this->q(
                    'What are the main components of Logging and Monitoring?',
                    [
                        $this->correct('Correct answer related to Logging and Monitoring'),
                        $this->wrong('Incorrect option A for Logging and Monitoring'),
                        $this->wrong('Incorrect option B for Logging and Monitoring'),
                        $this->wrong('Incorrect option C for Logging and Monitoring'),
                    ],
                    'This question tests understanding of Logging and Monitoring and its practical applications.',
                    'medium', 'approved'),
                $this->q(
                    'How does Logging and Monitoring improve system performance?',
                    [
                        $this->correct('Correct answer related to Logging and Monitoring'),
                        $this->wrong('Incorrect option A for Logging and Monitoring'),
                        $this->wrong('Incorrect option B for Logging and Monitoring'),
                        $this->wrong('Incorrect option C for Logging and Monitoring'),
                    ],
                    'This question tests understanding of Logging and Monitoring and its practical applications.',
                    'medium', 'approved'),
                $this->q(
                    'What are the security implications of Logging and Monitoring?',
                    [
                        $this->correct('Correct answer related to Logging and Monitoring'),
                        $this->wrong('Incorrect option A for Logging and Monitoring'),
                        $this->wrong('Incorrect option B for Logging and Monitoring'),
                        $this->wrong('Incorrect option C for Logging and Monitoring'),
                    ],
                    'This question tests understanding of Logging and Monitoring and its practical applications.',
                    'hard', 'approved'),
            ],

            'Resource Provisioning' => [
                $this->q(
                    'What is Resource Provisioning used for?',
                    [
                        $this->correct('Correct answer related to Resource Provisioning'),
                        $this->wrong('Incorrect option A for Resource Provisioning'),
                        $this->wrong('Incorrect option B for Resource Provisioning'),
                        $this->wrong('Incorrect option C for Resource Provisioning'),
                    ],
                    'This question tests understanding of Resource Provisioning and its practical applications.',
                    'easy', 'approved'),
                $this->q(
                    'Which of the following best describes Resource Provisioning?',
                    [
                        $this->correct('Correct answer related to Resource Provisioning'),
                        $this->wrong('Incorrect option A for Resource Provisioning'),
                        $this->wrong('Incorrect option B for Resource Provisioning'),
                        $this->wrong('Incorrect option C for Resource Provisioning'),
                    ],
                    'This question tests understanding of Resource Provisioning and its practical applications.',
                    'easy', 'approved'),
                $this->q(
                    'What is a key benefit of implementing Resource Provisioning?',
                    [
                        $this->correct('Correct answer related to Resource Provisioning'),
                        $this->wrong('Incorrect option A for Resource Provisioning'),
                        $this->wrong('Incorrect option B for Resource Provisioning'),
                        $this->wrong('Incorrect option C for Resource Provisioning'),
                    ],
                    'This question tests understanding of Resource Provisioning and its practical applications.',
                    'medium', 'approved'),
                $this->q(
                    'What are the main components of Resource Provisioning?',
                    [
                        $this->correct('Correct answer related to Resource Provisioning'),
                        $this->wrong('Incorrect option A for Resource Provisioning'),
                        $this->wrong('Incorrect option B for Resource Provisioning'),
                        $this->wrong('Incorrect option C for Resource Provisioning'),
                    ],
                    'This question tests understanding of Resource Provisioning and its practical applications.',
                    'medium', 'approved'),
                $this->q(
                    'What is a key benefit of implementing Resource Provisioning?',
                    [
                        $this->correct('Correct answer related to Resource Provisioning'),
                        $this->wrong('Incorrect option A for Resource Provisioning'),
                        $this->wrong('Incorrect option B for Resource Provisioning'),
                        $this->wrong('Incorrect option C for Resource Provisioning'),
                    ],
                    'This question tests understanding of Resource Provisioning and its practical applications.',
                    'medium', 'approved'),
                $this->q(
                    'What is the best practice for implementing Resource Provisioning at scale?',
                    [
                        $this->correct('Correct answer related to Resource Provisioning'),
                        $this->wrong('Incorrect option A for Resource Provisioning'),
                        $this->wrong('Incorrect option B for Resource Provisioning'),
                        $this->wrong('Incorrect option C for Resource Provisioning'),
                    ],
                    'This question tests understanding of Resource Provisioning and its practical applications.',
                    'hard', 'approved'),
            ],

            'Foundational Security Operations' => [
                $this->q(
                    'Which of the following best describes Foundational Security Operations?',
                    [
                        $this->correct('Correct answer related to Foundational Security Operations'),
                        $this->wrong('Incorrect option A for Foundational Security Operations'),
                        $this->wrong('Incorrect option B for Foundational Security Operations'),
                        $this->wrong('Incorrect option C for Foundational Security Operations'),
                    ],
                    'This question tests understanding of Foundational Security Operations and its practical applications.',
                    'easy', 'approved'),
                $this->q(
                    'Which of the following best describes Foundational Security Operations?',
                    [
                        $this->correct('Correct answer related to Foundational Security Operations'),
                        $this->wrong('Incorrect option A for Foundational Security Operations'),
                        $this->wrong('Incorrect option B for Foundational Security Operations'),
                        $this->wrong('Incorrect option C for Foundational Security Operations'),
                    ],
                    'This question tests understanding of Foundational Security Operations and its practical applications.',
                    'easy', 'approved'),
                $this->q(
                    'Which scenario best demonstrates the use of Foundational Security Operations?',
                    [
                        $this->correct('Correct answer related to Foundational Security Operations'),
                        $this->wrong('Incorrect option A for Foundational Security Operations'),
                        $this->wrong('Incorrect option B for Foundational Security Operations'),
                        $this->wrong('Incorrect option C for Foundational Security Operations'),
                    ],
                    'This question tests understanding of Foundational Security Operations and its practical applications.',
                    'medium', 'approved'),
                $this->q(
                    'Which scenario best demonstrates the use of Foundational Security Operations?',
                    [
                        $this->correct('Correct answer related to Foundational Security Operations'),
                        $this->wrong('Incorrect option A for Foundational Security Operations'),
                        $this->wrong('Incorrect option B for Foundational Security Operations'),
                        $this->wrong('Incorrect option C for Foundational Security Operations'),
                    ],
                    'This question tests understanding of Foundational Security Operations and its practical applications.',
                    'medium', 'approved'),
                $this->q(
                    'What are the main components of Foundational Security Operations?',
                    [
                        $this->correct('Correct answer related to Foundational Security Operations'),
                        $this->wrong('Incorrect option A for Foundational Security Operations'),
                        $this->wrong('Incorrect option B for Foundational Security Operations'),
                        $this->wrong('Incorrect option C for Foundational Security Operations'),
                    ],
                    'This question tests understanding of Foundational Security Operations and its practical applications.',
                    'medium', 'approved'),
                $this->q(
                    'In a production environment, how would you optimize Foundational Security Operations?',
                    [
                        $this->correct('Correct answer related to Foundational Security Operations'),
                        $this->wrong('Incorrect option A for Foundational Security Operations'),
                        $this->wrong('Incorrect option B for Foundational Security Operations'),
                        $this->wrong('Incorrect option C for Foundational Security Operations'),
                    ],
                    'This question tests understanding of Foundational Security Operations and its practical applications.',
                    'hard', 'approved'),
            ],

            'Incident Management' => [
                $this->q(
                    'Which of the following best describes Incident Management?',
                    [
                        $this->correct('Correct answer related to Incident Management'),
                        $this->wrong('Incorrect option A for Incident Management'),
                        $this->wrong('Incorrect option B for Incident Management'),
                        $this->wrong('Incorrect option C for Incident Management'),
                    ],
                    'This question tests understanding of Incident Management and its practical applications.',
                    'easy', 'approved'),
                $this->q(
                    'What is the primary purpose of Incident Management?',
                    [
                        $this->correct('Correct answer related to Incident Management'),
                        $this->wrong('Incorrect option A for Incident Management'),
                        $this->wrong('Incorrect option B for Incident Management'),
                        $this->wrong('Incorrect option C for Incident Management'),
                    ],
                    'This question tests understanding of Incident Management and its practical applications.',
                    'easy', 'approved'),
                $this->q(
                    'Which scenario best demonstrates the use of Incident Management?',
                    [
                        $this->correct('Correct answer related to Incident Management'),
                        $this->wrong('Incorrect option A for Incident Management'),
                        $this->wrong('Incorrect option B for Incident Management'),
                        $this->wrong('Incorrect option C for Incident Management'),
                    ],
                    'This question tests understanding of Incident Management and its practical applications.',
                    'medium', 'approved'),
                $this->q(
                    'Which scenario best demonstrates the use of Incident Management?',
                    [
                        $this->correct('Correct answer related to Incident Management'),
                        $this->wrong('Incorrect option A for Incident Management'),
                        $this->wrong('Incorrect option B for Incident Management'),
                        $this->wrong('Incorrect option C for Incident Management'),
                    ],
                    'This question tests understanding of Incident Management and its practical applications.',
                    'medium', 'approved'),
                $this->q(
                    'What are the main components of Incident Management?',
                    [
                        $this->correct('Correct answer related to Incident Management'),
                        $this->wrong('Incorrect option A for Incident Management'),
                        $this->wrong('Incorrect option B for Incident Management'),
                        $this->wrong('Incorrect option C for Incident Management'),
                    ],
                    'This question tests understanding of Incident Management and its practical applications.',
                    'medium', 'approved'),
                $this->q(
                    'How would you troubleshoot issues related to Incident Management?',
                    [
                        $this->correct('Correct answer related to Incident Management'),
                        $this->wrong('Incorrect option A for Incident Management'),
                        $this->wrong('Incorrect option B for Incident Management'),
                        $this->wrong('Incorrect option C for Incident Management'),
                    ],
                    'This question tests understanding of Incident Management and its practical applications.',
                    'hard', 'approved'),
            ],

            'Secure SDLC' => [
                $this->q(
                    'Which of the following best describes Secure SDLC?',
                    [
                        $this->correct('Correct answer related to Secure SDLC'),
                        $this->wrong('Incorrect option A for Secure SDLC'),
                        $this->wrong('Incorrect option B for Secure SDLC'),
                        $this->wrong('Incorrect option C for Secure SDLC'),
                    ],
                    'This question tests understanding of Secure SDLC and its practical applications.',
                    'easy', 'approved'),
                $this->q(
                    'What is the primary purpose of Secure SDLC?',
                    [
                        $this->correct('Correct answer related to Secure SDLC'),
                        $this->wrong('Incorrect option A for Secure SDLC'),
                        $this->wrong('Incorrect option B for Secure SDLC'),
                        $this->wrong('Incorrect option C for Secure SDLC'),
                    ],
                    'This question tests understanding of Secure SDLC and its practical applications.',
                    'easy', 'approved'),
                $this->q(
                    'What is a key benefit of implementing Secure SDLC?',
                    [
                        $this->correct('Correct answer related to Secure SDLC'),
                        $this->wrong('Incorrect option A for Secure SDLC'),
                        $this->wrong('Incorrect option B for Secure SDLC'),
                        $this->wrong('Incorrect option C for Secure SDLC'),
                    ],
                    'This question tests understanding of Secure SDLC and its practical applications.',
                    'medium', 'approved'),
                $this->q(
                    'What is a key benefit of implementing Secure SDLC?',
                    [
                        $this->correct('Correct answer related to Secure SDLC'),
                        $this->wrong('Incorrect option A for Secure SDLC'),
                        $this->wrong('Incorrect option B for Secure SDLC'),
                        $this->wrong('Incorrect option C for Secure SDLC'),
                    ],
                    'This question tests understanding of Secure SDLC and its practical applications.',
                    'medium', 'approved'),
                $this->q(
                    'What are the main components of Secure SDLC?',
                    [
                        $this->correct('Correct answer related to Secure SDLC'),
                        $this->wrong('Incorrect option A for Secure SDLC'),
                        $this->wrong('Incorrect option B for Secure SDLC'),
                        $this->wrong('Incorrect option C for Secure SDLC'),
                    ],
                    'This question tests understanding of Secure SDLC and its practical applications.',
                    'medium', 'approved'),
                $this->q(
                    'In a production environment, how would you optimize Secure SDLC?',
                    [
                        $this->correct('Correct answer related to Secure SDLC'),
                        $this->wrong('Incorrect option A for Secure SDLC'),
                        $this->wrong('Incorrect option B for Secure SDLC'),
                        $this->wrong('Incorrect option C for Secure SDLC'),
                    ],
                    'This question tests understanding of Secure SDLC and its practical applications.',
                    'hard', 'approved'),
            ],

            'Development Environments' => [
                $this->q(
                    'What is Development Environments used for?',
                    [
                        $this->correct('Correct answer related to Development Environments'),
                        $this->wrong('Incorrect option A for Development Environments'),
                        $this->wrong('Incorrect option B for Development Environments'),
                        $this->wrong('Incorrect option C for Development Environments'),
                    ],
                    'This question tests understanding of Development Environments and its practical applications.',
                    'easy', 'approved'),
                $this->q(
                    'What is the primary purpose of Development Environments?',
                    [
                        $this->correct('Correct answer related to Development Environments'),
                        $this->wrong('Incorrect option A for Development Environments'),
                        $this->wrong('Incorrect option B for Development Environments'),
                        $this->wrong('Incorrect option C for Development Environments'),
                    ],
                    'This question tests understanding of Development Environments and its practical applications.',
                    'easy', 'approved'),
                $this->q(
                    'How does Development Environments improve system performance?',
                    [
                        $this->correct('Correct answer related to Development Environments'),
                        $this->wrong('Incorrect option A for Development Environments'),
                        $this->wrong('Incorrect option B for Development Environments'),
                        $this->wrong('Incorrect option C for Development Environments'),
                    ],
                    'This question tests understanding of Development Environments and its practical applications.',
                    'medium', 'approved'),
                $this->q(
                    'How does Development Environments improve system performance?',
                    [
                        $this->correct('Correct answer related to Development Environments'),
                        $this->wrong('Incorrect option A for Development Environments'),
                        $this->wrong('Incorrect option B for Development Environments'),
                        $this->wrong('Incorrect option C for Development Environments'),
                    ],
                    'This question tests understanding of Development Environments and its practical applications.',
                    'medium', 'approved'),
                $this->q(
                    'Which scenario best demonstrates the use of Development Environments?',
                    [
                        $this->correct('Correct answer related to Development Environments'),
                        $this->wrong('Incorrect option A for Development Environments'),
                        $this->wrong('Incorrect option B for Development Environments'),
                        $this->wrong('Incorrect option C for Development Environments'),
                    ],
                    'This question tests understanding of Development Environments and its practical applications.',
                    'medium', 'approved'),
                $this->q(
                    'In a production environment, how would you optimize Development Environments?',
                    [
                        $this->correct('Correct answer related to Development Environments'),
                        $this->wrong('Incorrect option A for Development Environments'),
                        $this->wrong('Incorrect option B for Development Environments'),
                        $this->wrong('Incorrect option C for Development Environments'),
                    ],
                    'This question tests understanding of Development Environments and its practical applications.',
                    'hard', 'approved'),
            ],

            'Software Security Effectiveness' => [
                $this->q(
                    'Which statement about Software Security Effectiveness is correct?',
                    [
                        $this->correct('Correct answer related to Software Security Effectiveness'),
                        $this->wrong('Incorrect option A for Software Security Effectiveness'),
                        $this->wrong('Incorrect option B for Software Security Effectiveness'),
                        $this->wrong('Incorrect option C for Software Security Effectiveness'),
                    ],
                    'This question tests understanding of Software Security Effectiveness and its practical applications.',
                    'easy', 'approved'),
                $this->q(
                    'Which statement about Software Security Effectiveness is correct?',
                    [
                        $this->correct('Correct answer related to Software Security Effectiveness'),
                        $this->wrong('Incorrect option A for Software Security Effectiveness'),
                        $this->wrong('Incorrect option B for Software Security Effectiveness'),
                        $this->wrong('Incorrect option C for Software Security Effectiveness'),
                    ],
                    'This question tests understanding of Software Security Effectiveness and its practical applications.',
                    'easy', 'approved'),
                $this->q(
                    'What are the main components of Software Security Effectiveness?',
                    [
                        $this->correct('Correct answer related to Software Security Effectiveness'),
                        $this->wrong('Incorrect option A for Software Security Effectiveness'),
                        $this->wrong('Incorrect option B for Software Security Effectiveness'),
                        $this->wrong('Incorrect option C for Software Security Effectiveness'),
                    ],
                    'This question tests understanding of Software Security Effectiveness and its practical applications.',
                    'medium', 'approved'),
                $this->q(
                    'How does Software Security Effectiveness improve system performance?',
                    [
                        $this->correct('Correct answer related to Software Security Effectiveness'),
                        $this->wrong('Incorrect option A for Software Security Effectiveness'),
                        $this->wrong('Incorrect option B for Software Security Effectiveness'),
                        $this->wrong('Incorrect option C for Software Security Effectiveness'),
                    ],
                    'This question tests understanding of Software Security Effectiveness and its practical applications.',
                    'medium', 'approved'),
                $this->q(
                    'What is a key benefit of implementing Software Security Effectiveness?',
                    [
                        $this->correct('Correct answer related to Software Security Effectiveness'),
                        $this->wrong('Incorrect option A for Software Security Effectiveness'),
                        $this->wrong('Incorrect option B for Software Security Effectiveness'),
                        $this->wrong('Incorrect option C for Software Security Effectiveness'),
                    ],
                    'This question tests understanding of Software Security Effectiveness and its practical applications.',
                    'medium', 'approved'),
                $this->q(
                    'How would you troubleshoot issues related to Software Security Effectiveness?',
                    [
                        $this->correct('Correct answer related to Software Security Effectiveness'),
                        $this->wrong('Incorrect option A for Software Security Effectiveness'),
                        $this->wrong('Incorrect option B for Software Security Effectiveness'),
                        $this->wrong('Incorrect option C for Software Security Effectiveness'),
                    ],
                    'This question tests understanding of Software Security Effectiveness and its practical applications.',
                    'hard', 'approved'),
            ],

            'Acquired Software Security' => [
                $this->q(
                    'Which of the following best describes Acquired Software Security?',
                    [
                        $this->correct('Correct answer related to Acquired Software Security'),
                        $this->wrong('Incorrect option A for Acquired Software Security'),
                        $this->wrong('Incorrect option B for Acquired Software Security'),
                        $this->wrong('Incorrect option C for Acquired Software Security'),
                    ],
                    'This question tests understanding of Acquired Software Security and its practical applications.',
                    'easy', 'approved'),
                $this->q(
                    'Which of the following best describes Acquired Software Security?',
                    [
                        $this->correct('Correct answer related to Acquired Software Security'),
                        $this->wrong('Incorrect option A for Acquired Software Security'),
                        $this->wrong('Incorrect option B for Acquired Software Security'),
                        $this->wrong('Incorrect option C for Acquired Software Security'),
                    ],
                    'This question tests understanding of Acquired Software Security and its practical applications.',
                    'easy', 'approved'),
                $this->q(
                    'What is a key benefit of implementing Acquired Software Security?',
                    [
                        $this->correct('Correct answer related to Acquired Software Security'),
                        $this->wrong('Incorrect option A for Acquired Software Security'),
                        $this->wrong('Incorrect option B for Acquired Software Security'),
                        $this->wrong('Incorrect option C for Acquired Software Security'),
                    ],
                    'This question tests understanding of Acquired Software Security and its practical applications.',
                    'medium', 'approved'),
                $this->q(
                    'Which scenario best demonstrates the use of Acquired Software Security?',
                    [
                        $this->correct('Correct answer related to Acquired Software Security'),
                        $this->wrong('Incorrect option A for Acquired Software Security'),
                        $this->wrong('Incorrect option B for Acquired Software Security'),
                        $this->wrong('Incorrect option C for Acquired Software Security'),
                    ],
                    'This question tests understanding of Acquired Software Security and its practical applications.',
                    'medium', 'approved'),
                $this->q(
                    'How does Acquired Software Security improve system performance?',
                    [
                        $this->correct('Correct answer related to Acquired Software Security'),
                        $this->wrong('Incorrect option A for Acquired Software Security'),
                        $this->wrong('Incorrect option B for Acquired Software Security'),
                        $this->wrong('Incorrect option C for Acquired Software Security'),
                    ],
                    'This question tests understanding of Acquired Software Security and its practical applications.',
                    'medium', 'approved'),
                $this->q(
                    'In a production environment, how would you optimize Acquired Software Security?',
                    [
                        $this->correct('Correct answer related to Acquired Software Security'),
                        $this->wrong('Incorrect option A for Acquired Software Security'),
                        $this->wrong('Incorrect option B for Acquired Software Security'),
                        $this->wrong('Incorrect option C for Acquired Software Security'),
                    ],
                    'This question tests understanding of Acquired Software Security and its practical applications.',
                    'hard', 'approved'),
            ],

            'Database Security' => [
                $this->q(
                    'Which statement about Database Security is correct?',
                    [
                        $this->correct('Correct answer related to Database Security'),
                        $this->wrong('Incorrect option A for Database Security'),
                        $this->wrong('Incorrect option B for Database Security'),
                        $this->wrong('Incorrect option C for Database Security'),
                    ],
                    'This question tests understanding of Database Security and its practical applications.',
                    'easy', 'approved'),
                $this->q(
                    'What is Database Security used for?',
                    [
                        $this->correct('Correct answer related to Database Security'),
                        $this->wrong('Incorrect option A for Database Security'),
                        $this->wrong('Incorrect option B for Database Security'),
                        $this->wrong('Incorrect option C for Database Security'),
                    ],
                    'This question tests understanding of Database Security and its practical applications.',
                    'easy', 'approved'),
                $this->q(
                    'What is a key benefit of implementing Database Security?',
                    [
                        $this->correct('Correct answer related to Database Security'),
                        $this->wrong('Incorrect option A for Database Security'),
                        $this->wrong('Incorrect option B for Database Security'),
                        $this->wrong('Incorrect option C for Database Security'),
                    ],
                    'This question tests understanding of Database Security and its practical applications.',
                    'medium', 'approved'),
                $this->q(
                    'What are the main components of Database Security?',
                    [
                        $this->correct('Correct answer related to Database Security'),
                        $this->wrong('Incorrect option A for Database Security'),
                        $this->wrong('Incorrect option B for Database Security'),
                        $this->wrong('Incorrect option C for Database Security'),
                    ],
                    'This question tests understanding of Database Security and its practical applications.',
                    'medium', 'approved'),
                $this->q(
                    'What is a key benefit of implementing Database Security?',
                    [
                        $this->correct('Correct answer related to Database Security'),
                        $this->wrong('Incorrect option A for Database Security'),
                        $this->wrong('Incorrect option B for Database Security'),
                        $this->wrong('Incorrect option C for Database Security'),
                    ],
                    'This question tests understanding of Database Security and its practical applications.',
                    'medium', 'approved'),
                $this->q(
                    'What is the best practice for implementing Database Security at scale?',
                    [
                        $this->correct('Correct answer related to Database Security'),
                        $this->wrong('Incorrect option A for Database Security'),
                        $this->wrong('Incorrect option B for Database Security'),
                        $this->wrong('Incorrect option C for Database Security'),
                    ],
                    'This question tests understanding of Database Security and its practical applications.',
                    'hard', 'approved'),
            ],

        ];
    }
}
