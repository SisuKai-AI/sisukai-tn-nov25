<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Certification;
use App\Models\CertificationLandingQuizQuestion;
use App\Models\LandingQuizAttempt;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class LandingQuizController extends Controller
{
    /**
     * Get quiz questions for a certification
     */
    public function getQuestions($certificationSlug)
    {
        $certification = Certification::where('slug', $certificationSlug)
            ->where('is_active', true)
            ->firstOrFail();
        
        // Get the 5 selected quiz questions
        $quizQuestions = CertificationLandingQuizQuestion::where('certification_id', $certification->id)
            ->orderBy('order')
            ->with('question')
            ->get();
        
        if ($quizQuestions->count() !== 5) {
            return response()->json([
                'error' => 'Quiz not available for this certification'
            ], 404);
        }
        
        // Format questions for frontend (hide correct answers)
        $questions = $quizQuestions->map(function ($quizQuestion, $index) {
            $question = $quizQuestion->question;
            return [
                'id' => $question->id,
                'number' => $index + 1,
                'question_text' => $question->question_text,
                'option_a' => $question->option_a,
                'option_b' => $question->option_b,
                'option_c' => $question->option_c,
                'option_d' => $question->option_d,
                'difficulty' => $question->difficulty ?? 'medium',
            ];
        });
        
        // Generate session ID for tracking
        $sessionId = Session::get('quiz_session_id');
        if (!$sessionId) {
            $sessionId = Str::uuid()->toString();
            Session::put('quiz_session_id', $sessionId);
        }
        
        return response()->json([
            'certification' => [
                'id' => $certification->id,
                'name' => $certification->name,
                'slug' => $certification->slug,
            ],
            'questions' => $questions,
            'session_id' => $sessionId,
        ]);
    }
    
    /**
     * Submit answer for a single question
     */
    public function submitAnswer(Request $request)
    {
        $request->validate([
            'question_id' => 'required|exists:questions,id',
            'answer' => 'required|in:a,b,c,d',
            'session_id' => 'required|string',
        ]);
        
        $question = Question::findOrFail($request->question_id);
        $isCorrect = ($request->answer === $question->correct_answer);
        
        return response()->json([
            'correct' => $isCorrect,
            'correct_answer' => $question->correct_answer,
            'explanation' => $question->explanation,
        ]);
    }
    
    /**
     * Complete quiz and save attempt
     */
    public function completeQuiz(Request $request)
    {
        $request->validate([
            'certification_id' => 'required|exists:certifications,id',
            'session_id' => 'required|string',
            'score' => 'required|integer|min:0|max:5',
            'answers' => 'required|array|size:5',
        ]);
        
        // Save quiz attempt
        $attempt = LandingQuizAttempt::create([
            'id' => Str::uuid(),
            'certification_id' => $request->certification_id,
            'session_id' => $request->session_id,
            'score' => $request->score,
            'total_questions' => 5,
            'completed_at' => now(),
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);
        
        // Store attempt ID in session for registration flow
        Session::put('quiz_attempt_id', $attempt->id);
        Session::put('quiz_certification_id', $request->certification_id);
        
        // Calculate percentage
        $percentage = ($request->score / 5) * 100;
        
        // Generate result message
        $message = $this->getResultMessage($percentage);
        
        return response()->json([
            'attempt_id' => $attempt->id,
            'score' => $request->score,
            'total' => 5,
            'percentage' => $percentage,
            'message' => $message,
            'passed' => $percentage >= 60,
        ]);
    }
    
    /**
     * Get result message based on score
     */
    private function getResultMessage($percentage)
    {
        if ($percentage >= 80) {
            return "Excellent! You're well-prepared for this certification.";
        } elseif ($percentage >= 60) {
            return "Good start! With focused practice, you'll be ready to pass.";
        } elseif ($percentage >= 40) {
            return "You're on the right track. Our adaptive learning will help you improve.";
        } else {
            return "Don't worry! Our comprehensive practice questions will get you exam-ready.";
        }
    }
    
    /**
     * Track conversion (when user registers after quiz)
     */
    public function trackConversion(Request $request)
    {
        $request->validate([
            'attempt_id' => 'required|exists:landing_quiz_attempts,id',
        ]);
        
        $attempt = LandingQuizAttempt::findOrFail($request->attempt_id);
        $attempt->converted_to_registration = true;
        $attempt->save();
        
        return response()->json([
            'success' => true,
        ]);
    }
}
