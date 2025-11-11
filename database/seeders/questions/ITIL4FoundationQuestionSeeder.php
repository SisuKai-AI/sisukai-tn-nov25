<?php

namespace Database\Seeders\Questions;

class ITIL4FoundationQuestionSeeder extends BaseQuestionSeeder
{
    protected function getCertificationSlug(): string
    {
        return 'itil-4-foundation';
    }

    protected function getQuestionsData(): array
    {
        return [
            'Key Concepts of Service Management' => [
                $this->q('What is a service in ITIL 4?', [$this->correct('A means of enabling value co-creation by facilitating outcomes customers want'), $this->wrong('A software application'), $this->wrong('A support ticket'), $this->wrong('A server')], 'Services enable value for customers by facilitating outcomes without the customer managing specific costs and risks.', 'easy', 'approved'),
                $this->q('What is value in ITIL 4?', [$this->correct('The perceived benefits, usefulness, and importance of something'), $this->wrong('The cost of a service'), $this->wrong('The number of features'), $this->wrong('The service level agreement')], 'Value is defined by the customer based on perceived benefits, usefulness, and importance in achieving their objectives.', 'medium', 'approved'),
                $this->q('What are the four dimensions of service management?', [$this->correct('Organizations and People, Information and Technology, Partners and Suppliers, Value Streams and Processes'), $this->wrong('People, Process, Products, Performance'), $this->wrong('Strategy, Design, Transition, Operation'), $this->wrong('Plan, Do, Check, Act')], 'The four dimensions ensure a holistic approach to service management, considering all aspects that contribute to value.', 'medium', 'approved'),
            ],
            'The Service Value System' => [
                $this->q('What is the ITIL Service Value System (SVS)?', [$this->correct('A model showing how components work together to enable value creation'), $this->wrong('A service catalog'), $this->wrong('A ticketing system'), $this->wrong('A monitoring tool')], 'The SVS describes how all components and activities work together to facilitate value creation through services.', 'medium', 'approved'),
                $this->q('What is the purpose of the guiding principles?', [$this->correct('To provide recommendations that guide organizations in all circumstances'), $this->wrong('To define strict rules'), $this->wrong('To replace processes'), $this->wrong('To measure performance')], 'The seven guiding principles provide universal recommendations applicable to any organization in any situation.', 'easy', 'approved'),
                $this->q('What is continual improvement in ITIL 4?', [$this->correct('An organizational practice focused on aligning practices and services with changing business needs'), $this->wrong('A one-time project'), $this->wrong('Only fixing incidents'), $this->wrong('Annual reviews')], 'Continual improvement is an ongoing effort to align and realign services with changing business needs through incremental improvements.', 'easy', 'approved'),
            ],
            'The Seven Guiding Principles' => [
                $this->q('What does "Focus on value" mean?', [$this->correct('Everything should link back to value for stakeholders'), $this->wrong('Reduce costs at all times'), $this->wrong('Maximize profit'), $this->wrong('Deliver as many features as possible')], 'Every action should create value for stakeholders, considering both the service provider and consumer perspectives.', 'easy', 'approved'),
                $this->q('What does "Start where you are" mean?', [$this->correct('Assess the current state before starting improvement'), $this->wrong('Always start from scratch'), $this->wrong('Never change existing processes'), $this->wrong('Ignore past work')], 'Don\'t start from scratch; assess what exists and can be reused before building something new.', 'easy', 'approved'),
                $this->q('What does "Progress iteratively with feedback" mean?', [$this->correct('Work in small, manageable sections with feedback loops'), $this->wrong('Complete everything before getting feedback'), $this->wrong('Never change the plan'), $this->wrong('Avoid feedback')], 'Break work into smaller, manageable sections and use feedback to adjust and improve continuously.', 'medium', 'approved'),
            ],
            'Service Value Chain' => [
                $this->q('What are the six activities in the Service Value Chain?', [$this->correct('Plan, Improve, Engage, Design & Transition, Obtain/Build, Deliver & Support'), $this->wrong('Plan, Do, Check, Act, Review, Close'), $this->wrong('Strategy, Design, Transition, Operation, Improvement, Closure'), $this->wrong('Initiate, Plan, Execute, Monitor, Control, Close')], 'The Service Value Chain provides a flexible operating model for value creation through six interconnected activities.', 'medium', 'approved'),
                $this->q('What is the purpose of the "Engage" activity?', [$this->correct('To provide understanding of stakeholder needs and maintain relationships'), $this->wrong('To build services'), $this->wrong('To fix incidents'), $this->wrong('To plan improvements')], 'Engage ensures continual engagement with stakeholders to understand their needs and maintain good relationships.', 'medium', 'approved'),
            ],
            'ITIL Practices' => [
                $this->q('What is Incident Management?', [$this->correct('Minimizing the negative impact of incidents by restoring normal service quickly'), $this->wrong('Preventing all incidents'), $this->wrong('Finding the root cause'), $this->wrong('Making changes to systems')], 'Incident Management focuses on restoring normal service operation as quickly as possible to minimize business impact.', 'easy', 'approved'),
                $this->q('What is Problem Management?', [$this->correct('Reducing the likelihood and impact of incidents by identifying causes'), $this->wrong('Fixing all incidents'), $this->wrong('Implementing changes'), $this->wrong('Providing user support')], 'Problem Management identifies and manages the causes of incidents to prevent their recurrence.', 'easy', 'approved'),
                $this->q('What is Change Enablement (formerly Change Management)?', [$this->correct('Ensuring changes are assessed, authorized, and managed to minimize risk'), $this->wrong('Preventing all changes'), $this->wrong('Fixing incidents'), $this->wrong('Managing problems')], 'Change Enablement ensures changes are properly assessed, authorized, prioritized, and scheduled to minimize risk.', 'easy', 'approved'),
            ],
            'Additional ITIL Practices' => [
                $this->q('What is Service Desk?', [$this->correct('The single point of contact between service provider and users'), $this->wrong('A physical desk'), $this->wrong('Only for incident logging'), $this->wrong('A ticketing tool')], 'The Service Desk is the single point of contact, handling incidents, service requests, and communication with users.', 'easy', 'approved'),
                $this->q('What is Service Level Management?', [$this->correct('Setting clear targets for service levels and ensuring they are met'), $this->wrong('Creating service catalogs'), $this->wrong('Fixing incidents'), $this->wrong('Managing changes')], 'Service Level Management defines, monitors, and manages service levels through SLAs, ensuring services meet agreed targets.', 'medium', 'approved'),
                $this->q('What is the difference between an incident and a problem?', [$this->correct('An incident is an unplanned interruption, a problem is the cause of incidents'), $this->wrong('They are the same'), $this->wrong('A problem is less serious'), $this->wrong('An incident is the root cause')], 'Incidents are unplanned interruptions or reductions in service quality, while problems are the causes of one or more incidents.', 'easy', 'approved'),
            ],
        ];
    }
}

