<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CertificationLandingQuizQuestionsSeeder extends Seeder
{
    /**
     * Seed landing page quiz questions for each certification.
     * 
     * This seeder is idempotent - it will skip certifications that already have quiz questions.
     * Selects 5 questions per certification with mixed difficulty (2 easy, 2 medium, 1 hard preferred).
     */
    public function run(): void
    {
        $this->command->info('Seeding certification landing quiz questions...');
        
        // Get all certifications
        $certifications = DB::table('certifications')->get();
        
        $totalCreated = 0;
        $totalSkipped = 0;
        
        foreach ($certifications as $certification) {
            // Skip if already seeded (idempotent)
            $existing = DB::table('certification_landing_quiz_questions')
                ->where('certification_id', $certification->id)
                ->count();
                
            if ($existing > 0) {
                $this->command->warn("  Quiz questions already exist for {$certification->name} ({$existing} questions), skipping...");
                $totalSkipped++;
                continue;
            }
            
            // Get questions for this certification through domains/topics
            $questions = $this->getQuestionsForCertification($certification->id);
            
            if ($questions->count() < 5) {
                $this->command->warn("  Not enough questions for {$certification->name} ({$questions->count()} available), skipping...");
                $totalSkipped++;
                continue;
            }
            
            // Select 5 questions with mixed difficulty
            $selectedQuestions = $this->selectQuizQuestions($questions);
            
            if ($selectedQuestions->count() < 5) {
                $this->command->warn("  Could not select 5 questions for {$certification->name}, skipping...");
                $totalSkipped++;
                continue;
            }
            
            // Insert with ordering
            $order = 1;
            foreach ($selectedQuestions as $question) {
                DB::table('certification_landing_quiz_questions')->insert([
                    'id' => Str::uuid()->toString(),
                    'certification_id' => $certification->id,
                    'question_id' => $question->id,
                    'order' => $order++,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
            
            $this->command->info("  ✓ Created quiz for {$certification->name} with 5 questions");
            $totalCreated++;
        }
        
        $this->command->info('');
        $this->command->info("Quiz questions seeded: {$totalCreated} certifications processed, {$totalSkipped} skipped");
    }
    
    /**
     * Get all active questions for a certification
     */
    private function getQuestionsForCertification($certificationId)
    {
        return DB::table('questions as q')
            ->join('topics as t', 'q.topic_id', '=', 't.id')
            ->join('domains as d', 't.domain_id', '=', 'd.id')
            ->where('d.certification_id', $certificationId)
            ->where('q.status', 'approved')
            ->select('q.id', 'q.difficulty', 'q.question_text', 't.name as topic_name', 'd.name as domain_name')
            ->get();
    }
    
    /**
     * Select 5 quiz questions with mixed difficulty and diverse topics
     * 
     * Strategy: 2 easy, 2 medium, 1 hard (if available)
     * Fallback: Fill with whatever is available
     */
    private function selectQuizQuestions($questions)
    {
        $selected = collect();
        
        // Get questions by difficulty
        $easy = $questions->where('difficulty', 'easy');
        $medium = $questions->where('difficulty', 'medium');
        $hard = $questions->where('difficulty', 'hard');
        
        // Select 2 easy (or as many as available)
        if ($easy->count() >= 2) {
            $selected = $selected->merge($easy->random(2));
        } elseif ($easy->count() > 0) {
            $selected = $selected->merge($easy);
        }
        
        // Select 2 medium (or as many as available)
        $remaining = 5 - $selected->count();
        if ($medium->count() >= 2 && $remaining >= 2) {
            $selected = $selected->merge($medium->random(2));
        } elseif ($medium->count() > 0 && $remaining > 0) {
            $toTake = min($remaining, $medium->count());
            $selected = $selected->merge($medium->random($toTake));
        }
        
        // Select 1 hard (or fill remaining with any available)
        $remaining = 5 - $selected->count();
        if ($remaining > 0) {
            if ($hard->count() > 0 && $remaining >= 1) {
                $selected = $selected->merge($hard->random(1));
                $remaining--;
            }
            
            // Fill any remaining slots with any available questions
            if ($remaining > 0) {
                $available = $questions->whereNotIn('id', $selected->pluck('id'));
                if ($available->count() > 0) {
                    $toTake = min($remaining, $available->count());
                    $selected = $selected->merge($available->random($toTake));
                }
            }
        }
        
        return $selected->take(5);
    }
}
