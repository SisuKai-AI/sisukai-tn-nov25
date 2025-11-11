# SisuKai Certification Management System

## Overview

The **SisuKai Certification Management System** is a comprehensive solution for managing professional certification exams, practice sessions, and certificate issuance within the SisuKai learning management platform. This system enables learners to prepare for and take certification exams, track their progress, and earn verifiable certificates upon successful completion.

## System Architecture

The certification system consists of **11 interconnected entities** organized into four logical groups:

### 1. Core Certification Structure
- **Certification**: Main certification exam definitions
- **Domain**: Knowledge domains within certifications
- **Topic**: Specific topics within domains
- **Question**: Exam questions linked to topics
- **Answer**: Multiple-choice answer options for questions

### 2. Practice System
- **PracticeSession**: Learner practice sessions
- **PracticeAnswer**: Answers submitted during practice

### 3. Exam System
- **ExamAttempt**: Formal exam attempts by learners
- **ExamAnswer**: Answers submitted during exams

### 4. Support Features
- **FlaggedQuestion**: Questions flagged by learners for review
- **Certificate**: Issued certificates for passed exams

## Database Schema

### Entity Relationship Diagram

```
Certification (1) ──< (N) Domain (1) ──< (N) Topic (1) ──< (N) Question (1) ──< (N) Answer
     │                                                           │
     │                                                           │
     ├──< (N) PracticeSession (1) ──< (N) PracticeAnswer ───────┤
     │                                                           │
     ├──< (N) ExamAttempt (1) ──< (N) ExamAnswer ───────────────┤
     │              │                                            │
     │              │                                            │
     ├──< (N) Certificate                                        │
     │                                                           │
     └──< (N) FlaggedQuestion ───────────────────────────────────┘

Learner (1) ──< (N) PracticeSession
Learner (1) ──< (N) ExamAttempt
Learner (1) ──< (N) Certificate
Learner (1) ──< (N) FlaggedQuestion
```

## Entity Details

### 1. Certification

**Purpose**: Defines a certification exam with its configuration and requirements.

**Key Fields**:
- `id` (UUID): Primary key
- `name` (string): Certification name
- `slug` (string): URL-friendly identifier
- `description` (text): Detailed description
- `provider` (string): Certification provider/vendor
- `exam_question_count` (integer): Number of questions in exam
- `exam_duration_minutes` (integer): Time limit for exam
- `passing_score` (integer): Passing percentage (0-100)
- `price_single_cert` (decimal): Price for single certification
- `is_active` (boolean): Active status
- `deleted_at` (timestamp): Soft delete timestamp

**Relationships**:
- Has many: Domains, PracticeSessions, ExamAttempts, Certificates, FlaggedQuestions

**Business Rules**:
- Only active certifications can be taken by learners
- Soft deletes preserve historical data
- Slug must be unique for URL routing

---

### 2. Domain

**Purpose**: Represents knowledge domains within a certification (e.g., "Security", "Networking").

**Key Fields**:
- `id` (UUID): Primary key
- `certification_id` (UUID): Foreign key to Certification
- `name` (string): Domain name
- `description` (text): Domain description
- `order` (integer): Display order
- `deleted_at` (timestamp): Soft delete timestamp

**Relationships**:
- Belongs to: Certification
- Has many: Topics

**Business Rules**:
- Domains are ordered for structured presentation
- Cascading delete when certification is deleted
- Soft deletes for data preservation

---

### 3. Topic

**Purpose**: Specific topics within domains (e.g., "Encryption Methods" under "Security").

**Key Fields**:
- `id` (UUID): Primary key
- `domain_id` (UUID): Foreign key to Domain
- `name` (string): Topic name
- `description` (text): Topic description
- `order` (integer): Display order
- `deleted_at` (timestamp): Soft delete timestamp

**Relationships**:
- Belongs to: Domain
- Has many: Questions

**Business Rules**:
- Topics organize questions hierarchically
- Ordered display within domains
- Cascading delete with domain

---

### 4. Question

**Purpose**: Multiple-choice questions for exams and practice sessions.

**Key Fields**:
- `id` (UUID): Primary key
- `topic_id` (UUID): Foreign key to Topic
- `question_text` (text): The question content
- `explanation` (text): Explanation of correct answer
- `difficulty` (enum): 'easy', 'medium', 'hard'
- `status` (enum): 'draft', 'pending_review', 'approved', 'archived'
- `created_by` (UUID): Foreign key to User who created question
- `deleted_at` (timestamp): Soft delete timestamp

**Relationships**:
- Belongs to: Topic
- Has many: Answers, PracticeAnswers, ExamAnswers, FlaggedQuestions
- Has one: CorrectAnswer (where is_correct = true)

**Business Rules**:
- Only approved questions appear in exams
- Each question must have exactly one correct answer
- Questions can be flagged by learners for review
- Soft deletes preserve question history

---

### 5. Answer

**Purpose**: Multiple-choice answer options for questions.

**Key Fields**:
- `id` (UUID): Primary key
- `question_id` (UUID): Foreign key to Question
- `answer_text` (text): Answer content
- `is_correct` (boolean): Correct answer flag
- `order` (integer): Display order
- `deleted_at` (timestamp): Soft delete timestamp

**Relationships**:
- Belongs to: Question
- Has many: PracticeAnswers, ExamAnswers

**Business Rules**:
- Each question must have exactly one correct answer (is_correct = true)
- Typically 4-5 answer options per question
- Answers are randomized during presentation
- Cascading delete with question

---

### 6. PracticeSession

**Purpose**: Tracks learner practice sessions for exam preparation.

**Key Fields**:
- `id` (UUID): Primary key
- `learner_id` (UUID): Foreign key to Learner
- `certification_id` (UUID): Foreign key to Certification
- `domain_id` (UUID): Optional domain-specific practice
- `topic_id` (UUID): Optional topic-specific practice
- `total_questions` (integer): Number of questions in session
- `correct_answers` (integer): Number of correct answers
- `score_percentage` (decimal): Calculated score percentage
- `status` (enum): 'in_progress', 'completed', 'abandoned'
- `started_at` (timestamp): Session start time
- `completed_at` (timestamp): Session completion time

**Relationships**:
- Belongs to: Learner, Certification, Domain (optional), Topic (optional)
- Has many: PracticeAnswers

**Business Rules**:
- Practice sessions can be certification-wide, domain-specific, or topic-specific
- Score is automatically calculated upon completion
- Sessions can be abandoned if not completed
- No time limits on practice sessions

---

### 7. PracticeAnswer

**Purpose**: Records answers submitted during practice sessions.

**Key Fields**:
- `id` (UUID): Primary key
- `session_id` (UUID): Foreign key to PracticeSession
- `question_id` (UUID): Foreign key to Question
- `answer_id` (UUID): Foreign key to Answer
- `is_correct` (boolean): Whether answer was correct
- `answered_at` (timestamp): When answer was submitted

**Relationships**:
- Belongs to: PracticeSession, Question, Answer

**Business Rules**:
- Correctness is evaluated immediately
- Learners can see explanations after answering
- Used for progress tracking and analytics

---

### 8. ExamAttempt

**Purpose**: Tracks formal certification exam attempts by learners.

**Key Fields**:
- `id` (UUID): Primary key
- `learner_id` (UUID): Foreign key to Learner
- `certification_id` (UUID): Foreign key to Certification
- `attempt_number` (integer): Sequential attempt number
- `total_questions` (integer): Number of questions in exam
- `correct_answers` (integer): Number of correct answers
- `score_percentage` (decimal): Calculated score percentage
- `passing_score` (integer): Required passing percentage
- `passed` (boolean): Whether learner passed
- `status` (enum): 'in_progress', 'completed', 'abandoned'
- `started_at` (timestamp): Exam start time
- `completed_at` (timestamp): Exam completion time
- `duration_minutes` (integer): Exam duration

**Relationships**:
- Belongs to: Learner, Certification
- Has many: ExamAnswers
- Has one: Certificate (if passed)

**Business Rules**:
- Exam attempts are timed based on certification duration
- Score is calculated upon completion
- Passing status determined by comparing score to passing_score
- Certificate is issued only for passed attempts
- Attempt number increments for each new attempt

---

### 9. ExamAnswer

**Purpose**: Records answers submitted during formal exam attempts.

**Key Fields**:
- `id` (UUID): Primary key
- `attempt_id` (UUID): Foreign key to ExamAttempt
- `question_id` (UUID): Foreign key to Question
- `answer_id` (UUID): Foreign key to Answer
- `is_correct` (boolean): Whether answer was correct
- `answered_at` (timestamp): When answer was submitted

**Relationships**:
- Belongs to: ExamAttempt, Question, Answer

**Business Rules**:
- Correctness is not revealed until exam completion
- Answers cannot be changed after submission
- Used for final score calculation
- Explanations shown only after exam completion

---

### 10. FlaggedQuestion

**Purpose**: Allows learners to flag questions for review or report issues.

**Key Fields**:
- `id` (UUID): Primary key
- `learner_id` (UUID): Foreign key to Learner
- `question_id` (UUID): Foreign key to Question
- `certification_id` (UUID): Foreign key to Certification
- `notes` (text): Learner's notes about the issue
- `flagged_at` (timestamp): When question was flagged

**Relationships**:
- Belongs to: Learner, Question, Certification

**Business Rules**:
- Learners can flag questions during practice or exams
- Unique constraint: one flag per learner per question
- Helps identify problematic questions
- No timestamps (uses flagged_at only)

---

### 11. Certificate

**Purpose**: Represents issued certificates for passed certification exams.

**Key Fields**:
- `id` (UUID): Primary key
- `learner_id` (UUID): Foreign key to Learner
- `certification_id` (UUID): Foreign key to Certification
- `exam_attempt_id` (UUID): Foreign key to ExamAttempt (unique)
- `certificate_number` (string): Unique certificate identifier
- `status` (enum): 'valid', 'revoked'
- `revocation_reason` (text): Reason for revocation
- `revoked_by` (UUID): Foreign key to User who revoked
- `issued_at` (timestamp): Certificate issue date
- `revoked_at` (timestamp): Revocation date

**Relationships**:
- Belongs to: Learner, Certification, ExamAttempt, RevokedBy (User)

**Business Rules**:
- One certificate per exam attempt (unique constraint)
- Certificate number format: `{CERT_CODE}-{YEAR}-{SEQUENCE}`
- Certificates can be revoked by administrators
- Valid certificates are publicly verifiable
- No standard timestamps (uses issued_at/revoked_at)

## Model Relationships

### Certification Model

```php
// Relationships
public function domains()
public function questions()
public function practiceSessions()
public function examAttempts()
public function certificates()
public function flaggedQuestions()

// Scopes
public function scopeActive($query)
public function scopeDraft($query)

// Methods
public function isActive(): bool
public function isArchived(): bool
```

### Domain Model

```php
// Relationships
public function certification()
public function topics()
public function questions()

// Scopes
public function scopeOrdered($query)
```

### Topic Model

```php
// Relationships
public function domain()
public function questions()
public function certification()

// Scopes
public function scopeOrdered($query)
```

### Question Model

```php
// Relationships
public function topic()
public function answers()
public function correctAnswer()
public function practiceAnswers()
public function examAnswers()
public function flaggedQuestions()
public function domain()
public function certification()

// Scopes
public function scopeActive($query)
public function scopeByDifficulty($query, $difficulty)
public function scopeByType($query, $type)

// Methods
public function isActive(): bool
public function isCorrectAnswer($answerId): bool
```

### Answer Model

```php
// Relationships
public function question()
public function practiceAnswers()
public function examAnswers()

// Scopes
public function scopeCorrect($query)
public function scopeOrdered($query)
```

### PracticeSession Model

```php
// Relationships
public function learner()
public function certification()
public function domain()
public function topic()
public function practiceAnswers()

// Scopes
public function scopeInProgress($query)
public function scopeCompleted($query)
public function scopeAbandoned($query)

// Methods
public function isInProgress(): bool
public function isCompleted(): bool
public function calculateScore(): void
public function markAsCompleted(): void
```

### PracticeAnswer Model

```php
// Relationships
public function session()
public function question()
public function answer()

// Scopes
public function scopeCorrect($query)
public function scopeIncorrect($query)
```

### ExamAttempt Model

```php
// Relationships
public function learner()
public function certification()
public function examAnswers()
public function certificate()

// Scopes
public function scopeInProgress($query)
public function scopeCompleted($query)
public function scopePassed($query)
public function scopeFailed($query)

// Methods
public function isInProgress(): bool
public function isCompleted(): bool
public function hasPassed(): bool
public function calculateScore(): void
public function markAsCompleted(): void
public function getDomainScores(): array
```

### ExamAnswer Model

```php
// Relationships
public function attempt()
public function question()
public function answer()

// Scopes
public function scopeCorrect($query)
public function scopeIncorrect($query)
```

### FlaggedQuestion Model

```php
// Relationships
public function learner()
public function question()
public function certification()

// Scopes
public function scopeForLearner($query, $learnerId)
public function scopeForCertification($query, $certificationId)
```

### Certificate Model

```php
// Relationships
public function learner()
public function certification()
public function examAttempt()
public function revokedBy()

// Scopes
public function scopeValid($query)
public function scopeRevoked($query)

// Methods
public function isValid(): bool
public function isRevoked(): bool
public function revoke(string $reason, $revokedBy = null): void
public static function generateCertificateNumber(Certification $cert, Learner $learner): string
```

### Learner Model (Extended)

```php
// New Certification Relationships
public function practiceSessions()
public function examAttempts()
public function certificates()
public function flaggedQuestions()
public function passedExams()
public function validCertificates()

// Methods
public function hasPassed($certificationId): bool
```

## Usage Examples

### Creating a Certification Structure

```php
// Create a certification
$certification = Certification::create([
    'name' => 'AWS Solutions Architect Associate',
    'slug' => 'aws-saa',
    'description' => 'AWS Solutions Architect certification...',
    'provider' => 'Amazon Web Services',
    'exam_question_count' => 65,
    'exam_duration_minutes' => 130,
    'passing_score' => 72,
    'price_single_cert' => 150.00,
    'is_active' => true,
]);

// Add domains
$domain = $certification->domains()->create([
    'name' => 'Design Resilient Architectures',
    'description' => 'Design resilient architectures...',
    'order' => 1,
]);

// Add topics
$topic = $domain->topics()->create([
    'name' => 'High Availability',
    'description' => 'Design highly available systems...',
    'order' => 1,
]);

// Add questions
$question = $topic->questions()->create([
    'question_text' => 'Which AWS service provides...?',
    'explanation' => 'The correct answer is...',
    'difficulty' => 'medium',
    'status' => 'approved',
]);

// Add answers
$question->answers()->createMany([
    ['answer_text' => 'Amazon EC2', 'is_correct' => false, 'order' => 1],
    ['answer_text' => 'Amazon S3', 'is_correct' => true, 'order' => 2],
    ['answer_text' => 'Amazon RDS', 'is_correct' => false, 'order' => 3],
    ['answer_text' => 'Amazon VPC', 'is_correct' => false, 'order' => 4],
]);
```

### Starting a Practice Session

```php
// Create practice session
$session = PracticeSession::create([
    'learner_id' => $learner->id,
    'certification_id' => $certification->id,
    'domain_id' => $domain->id, // Optional: domain-specific
    'status' => 'in_progress',
    'started_at' => now(),
]);

// Record practice answers
$session->practiceAnswers()->create([
    'question_id' => $question->id,
    'answer_id' => $selectedAnswer->id,
    'is_correct' => $question->isCorrectAnswer($selectedAnswer->id),
    'answered_at' => now(),
]);

// Complete session
$session->markAsCompleted();
```

### Taking an Exam

```php
// Start exam attempt
$attempt = ExamAttempt::create([
    'learner_id' => $learner->id,
    'certification_id' => $certification->id,
    'attempt_number' => $learner->examAttempts()
        ->where('certification_id', $certification->id)
        ->count() + 1,
    'passing_score' => $certification->passing_score,
    'status' => 'in_progress',
    'started_at' => now(),
    'duration_minutes' => $certification->exam_duration_minutes,
]);

// Record exam answers
$attempt->examAnswers()->create([
    'question_id' => $question->id,
    'answer_id' => $selectedAnswer->id,
    'is_correct' => $question->isCorrectAnswer($selectedAnswer->id),
    'answered_at' => now(),
]);

// Complete exam
$attempt->markAsCompleted();

// Issue certificate if passed
if ($attempt->passed) {
    $certificate = Certificate::create([
        'learner_id' => $learner->id,
        'certification_id' => $certification->id,
        'exam_attempt_id' => $attempt->id,
        'certificate_number' => Certificate::generateCertificateNumber(
            $certification,
            $learner
        ),
        'status' => 'valid',
        'issued_at' => now(),
    ]);
}
```

### Flagging a Question

```php
// Flag a question during practice or exam
FlaggedQuestion::create([
    'learner_id' => $learner->id,
    'question_id' => $question->id,
    'certification_id' => $certification->id,
    'notes' => 'The explanation seems incorrect...',
    'flagged_at' => now(),
]);
```

### Analyzing Performance

```php
// Get learner's practice history
$practiceSessions = $learner->practiceSessions()
    ->where('certification_id', $certification->id)
    ->completed()
    ->get();

// Get exam attempts
$examAttempts = $learner->examAttempts()
    ->where('certification_id', $certification->id)
    ->with('examAnswers.question.topic.domain')
    ->get();

// Get domain breakdown for an attempt
$domainScores = $attempt->getDomainScores();
// Returns: ['Domain Name' => ['total' => 10, 'correct' => 8, 'percentage' => 80]]

// Check if learner has passed
if ($learner->hasPassed($certification->id)) {
    $certificate = $learner->certificates()
        ->where('certification_id', $certification->id)
        ->valid()
        ->first();
}
```

## Migration Files

All migration files are located in `database/migrations/` with the following naming convention:

1. `2025_10_27_022613_create_certifications_table.php`
2. `2025_10_27_022623_create_domains_table.php`
3. `2025_10_27_022623_create_topics_table.php`
4. `2025_10_27_022623_create_questions_table.php`
5. `2025_10_27_022623_create_answers_table.php`
6. `2025_10_27_022830_create_practice_sessions_table.php`
7. `2025_10_27_022830_create_practice_answers_table.php`
8. `2025_10_27_022830_create_exam_attempts_table.php`
9. `2025_10_27_022831_create_exam_answers_table.php`
10. `2025_10_27_023013_create_flagged_questions_table.php`
11. `2025_10_27_023013_create_certificates_table.php`

### Running Migrations

```bash
# Run all migrations
php artisan migrate

# Rollback certification migrations
php artisan migrate:rollback --step=11

# Fresh migration (reset database)
php artisan migrate:fresh
```

## Model Files

All model files are located in `app/Models/`:

1. `Certification.php`
2. `Domain.php`
3. `Topic.php`
4. `Question.php`
5. `Answer.php`
6. `PracticeSession.php`
7. `PracticeAnswer.php`
8. `ExamAttempt.php`
9. `ExamAnswer.php`
10. `FlaggedQuestion.php`
11. `Certificate.php`
12. `Learner.php` (extended with certification relationships)

## Key Features

### 1. Hierarchical Content Organization
- Certifications → Domains → Topics → Questions → Answers
- Flexible practice at any level (certification, domain, or topic)
- Ordered display for structured learning paths

### 2. Practice Mode
- Unlimited practice sessions
- Immediate feedback with explanations
- Domain and topic-specific practice
- Progress tracking and analytics

### 3. Exam Mode
- Timed exams based on certification settings
- No feedback until completion
- Multiple attempts allowed
- Automatic scoring and pass/fail determination

### 4. Certificate Management
- Automatic certificate generation for passed exams
- Unique certificate numbers
- Certificate verification
- Revocation capability with audit trail

### 5. Quality Control
- Question flagging by learners
- Question status workflow (draft → review → approved)
- Soft deletes for data preservation
- Created by tracking for accountability

### 6. Analytics & Reporting
- Practice session history
- Exam attempt tracking
- Domain-level performance breakdown
- Learner progress tracking

## Security Considerations

1. **UUID Primary Keys**: All entities use UUIDs for non-sequential, secure identifiers
2. **Soft Deletes**: Core entities use soft deletes to preserve historical data
3. **Foreign Key Constraints**: Referential integrity enforced at database level
4. **Unique Constraints**: Certificate numbers and exam attempts properly constrained
5. **Audit Trail**: Created by, revoked by, and timestamp fields for accountability

## Performance Optimization

1. **Indexes**: Foreign keys automatically indexed
2. **Eager Loading**: Use `with()` to prevent N+1 queries
3. **Scopes**: Pre-defined query scopes for common filters
4. **Caching**: Consider caching active certifications and questions

## Future Enhancements

1. **Question Banks**: Randomized question selection from pools
2. **Adaptive Testing**: Difficulty-based question selection
3. **Expiring Certificates**: Add expiration dates and renewal process
4. **Multi-language Support**: Translate questions and content
5. **Question Types**: Add true/false, multiple-select, scenario-based questions
6. **Proctoring**: Integration with exam proctoring services
7. **Badge System**: Digital badges for achievements
8. **Learning Paths**: Prerequisite certifications and recommended sequences

## Support & Maintenance

### Database Backup
```bash
# Backup database
php artisan db:backup

# Restore from backup
php artisan db:restore backup-file.sql
```

### Data Seeding
Create seeders for sample certification data:
```bash
php artisan make:seeder CertificationSeeder
php artisan db:seed --class=CertificationSeeder
```

### Testing
```bash
# Run tests
php artisan test

# Run specific test suite
php artisan test --testsuite=Certification
```

## Conclusion

The SisuKai Certification Management System provides a robust, scalable foundation for managing professional certification exams. With its hierarchical content structure, flexible practice modes, secure exam delivery, and comprehensive certificate management, it supports the complete certification lifecycle from content creation to certificate issuance and verification.

---

**Version**: 1.0  
**Last Updated**: October 27, 2025  
**Author**: SisuKai Development Team

