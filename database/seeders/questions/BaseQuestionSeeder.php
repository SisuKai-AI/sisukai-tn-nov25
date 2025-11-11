<?php

namespace Database\Seeders\Questions;

use App\Models\Question;
use App\Models\Answer;
use App\Models\Topic;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

abstract class BaseQuestionSeeder extends Seeder
{
    /**
     * The certification slug this seeder is for
     */
    abstract protected function getCertificationSlug(): string;
    
    /**
     * Get questions data for this certification
     * Returns array of [topic_name => [questions]]
     */
    abstract protected function getQuestionsData(): array;
    
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $certificationSlug = $this->getCertificationSlug();
        $questionsData = $this->getQuestionsData();
        
        $this->command->info("Seeding questions for: {$certificationSlug}");
        
        $totalQuestions = 0;
        $totalAnswers = 0;
        
        DB::transaction(function () use ($questionsData, $certificationSlug, &$totalQuestions, &$totalAnswers) {
            foreach ($questionsData as $topicName => $questions) {
                $topic = Topic::whereHas('domain.certification', function ($query) use ($certificationSlug) {
                    $query->where('slug', $certificationSlug);
                })->where('name', $topicName)->first();
                
                if (!$topic) {
                    $this->command->warn("Topic not found: {$topicName}");
                    continue;
                }
                
                foreach ($questions as $questionData) {
                    $question = Question::create([
                        'topic_id' => $topic->id,
                        'question_text' => $questionData['question'],
                        'explanation' => $questionData['explanation'] ?? null,
                        'difficulty' => $questionData['difficulty'] ?? 'medium',
                        'status' => $questionData['status'] ?? 'draft',
                    ]);
                    
                    $totalQuestions++;
                    
                    foreach ($questionData['answers'] as $answerData) {
                        Answer::create([
                            'question_id' => $question->id,
                            'answer_text' => $answerData['text'],
                            'is_correct' => $answerData['correct'],
                        ]);
                        $totalAnswers++;
                    }
                }
            }
        });
        
        $this->command->info("✓ Created {$totalQuestions} questions with {$totalAnswers} answers");
    }
    
    /**
     * Helper to create a question array
     */
    protected function q(string $question, array $answers, string $explanation = '', string $difficulty = 'medium', string $status = 'draft'): array
    {
        return [
            'question' => $question,
            'answers' => $answers,
            'explanation' => $explanation,
            'difficulty' => $difficulty,
            'status' => $status,
        ];
    }
    
    /**
     * Helper to create a correct answer
     */
    protected function correct(string $text): array
    {
        return ['text' => $text, 'correct' => true];
    }
    
    /**
     * Helper to create an incorrect answer
     */
    protected function wrong(string $text): array
    {
        return ['text' => $text, 'correct' => false];
    }
}

