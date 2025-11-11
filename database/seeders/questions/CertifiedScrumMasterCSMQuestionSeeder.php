<?php

namespace Database\Seeders\Questions;

class CertifiedScrumMasterCSMQuestionSeeder extends BaseQuestionSeeder
{
    protected function getCertificationSlug(): string
    {
        return 'certified-scrummaster-csm';
    }

    protected function getQuestionsData(): array
    {
        return [
            'Scrum Framework' => [
                $this->q('What are the three pillars of Scrum?', [$this->correct('Transparency, Inspection, and Adaptation'), $this->wrong('Planning, Execution, and Delivery'), $this->wrong('People, Process, and Product'), $this->wrong('Speed, Quality, and Value')], 'Scrum is built on transparency (visibility), inspection (regular review), and adaptation (continuous improvement).', 'easy', 'approved'),
                $this->q('What are the five Scrum values?', [$this->correct('Commitment, Focus, Openness, Respect, and Courage'), $this->wrong('Speed, Quality, Efficiency, Teamwork, and Innovation'), $this->wrong('Planning, Building, Testing, Deploying, and Reviewing'), $this->wrong('Leadership, Communication, Collaboration, Trust, and Excellence')], 'The five Scrum values guide team behavior and decision-making.', 'medium', 'approved'),
                $this->q('What is empiricism in Scrum?', [$this->correct('Making decisions based on observation and experience'), $this->wrong('Following a detailed plan'), $this->wrong('Predicting the future'), $this->wrong('Avoiding changes')], 'Empiricism means knowledge comes from experience and making decisions based on what is observed, not predicted.', 'medium', 'approved'),
            ],
            'Scrum Roles' => [
                $this->q('What is the primary responsibility of the Scrum Master?', [$this->correct('To facilitate Scrum and remove impediments'), $this->wrong('To manage the team'), $this->wrong('To write user stories'), $this->wrong('To test the product')], 'The Scrum Master is a servant-leader who facilitates Scrum, coaches the team, and removes impediments.', 'easy', 'approved'),
                $this->q('What is the Product Owner responsible for?', [$this->correct('Maximizing the value of the product and managing the Product Backlog'), $this->wrong('Managing the team'), $this->wrong('Running daily standups'), $this->wrong('Writing code')], 'The Product Owner maximizes product value by managing and prioritizing the Product Backlog based on stakeholder needs.', 'easy', 'approved'),
                $this->q('Who is responsible for the Sprint Backlog?', [$this->correct('The Development Team'), $this->wrong('The Scrum Master'), $this->wrong('The Product Owner'), $this->wrong('The stakeholders')], 'The Development Team owns the Sprint Backlog and decides how to accomplish the work.', 'medium', 'approved'),
            ],
            'Scrum Events' => [
                $this->q('What is the purpose of Sprint Planning?', [$this->correct('To plan the work for the upcoming Sprint'), $this->wrong('To review the previous Sprint'), $this->wrong('To demonstrate the product'), $this->wrong('To remove impediments')], 'Sprint Planning defines what can be delivered in the Sprint and how the work will be achieved.', 'easy', 'approved'),
                $this->q('What is the timebox for a Daily Scrum in a one-month Sprint?', [$this->correct('15 minutes'), $this->wrong('30 minutes'), $this->wrong('1 hour'), $this->wrong('2 hours')], 'The Daily Scrum is always timeboxed to 15 minutes regardless of Sprint length.', 'easy', 'approved'),
                $this->q('What is the purpose of the Sprint Retrospective?', [$this->correct('To inspect how the last Sprint went and plan improvements'), $this->wrong('To demonstrate the product'), $this->wrong('To plan the next Sprint'), $this->wrong('To review the Product Backlog')], 'The Sprint Retrospective allows the team to inspect their process and create a plan for improvements.', 'easy', 'approved'),
            ],
            'Scrum Artifacts' => [
                $this->q('What is the Product Backlog?', [$this->correct('An ordered list of everything needed in the product'), $this->wrong('A list of completed features'), $this->wrong('The Sprint plan'), $this->wrong('A list of bugs')], 'The Product Backlog is a living, ordered list of product requirements maintained by the Product Owner.', 'easy', 'approved'),
                $this->q('What is the Sprint Backlog?', [$this->correct('The set of Product Backlog items selected for the Sprint plus the plan'), $this->wrong('All items in the Product Backlog'), $this->wrong('Completed work'), $this->wrong('The project schedule')], 'The Sprint Backlog is the Sprint Goal, selected Product Backlog items, and the plan for delivering them.', 'medium', 'approved'),
                $this->q('What is the Increment?', [$this->correct('The sum of all Product Backlog items completed during a Sprint'), $this->wrong('A single feature'), $this->wrong('The Sprint plan'), $this->wrong('The Product Backlog')], 'The Increment is the sum of all completed Product Backlog items, meeting the Definition of Done.', 'easy', 'approved'),
            ],
            'Scrum Master Responsibilities' => [
                $this->q('How does a Scrum Master serve the Development Team?', [$this->correct('By coaching, removing impediments, and facilitating Scrum events'), $this->wrong('By assigning tasks'), $this->wrong('By writing code'), $this->wrong('By testing the product')], 'The Scrum Master serves the Development Team through coaching, facilitation, and removing impediments.', 'easy', 'approved'),
                $this->q('How does a Scrum Master serve the Product Owner?', [$this->correct('By helping with Product Backlog management and facilitating collaboration'), $this->wrong('By writing user stories'), $this->wrong('By prioritizing the backlog'), $this->wrong('By making product decisions')], 'The Scrum Master helps the Product Owner with backlog management techniques and facilitates stakeholder collaboration.', 'medium', 'approved'),
                $this->q('How does a Scrum Master serve the organization?', [$this->correct('By leading Scrum adoption and helping understand empirical product development'), $this->wrong('By managing all projects'), $this->wrong('By making business decisions'), $this->wrong('By hiring team members')], 'The Scrum Master helps the organization adopt Scrum and understand empirical approaches to complex work.', 'medium', 'approved'),
            ],
        ];
    }
}

