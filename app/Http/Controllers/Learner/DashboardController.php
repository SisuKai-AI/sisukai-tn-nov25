<?php

namespace App\Http\Controllers\Learner;

use App\Http\Controllers\Controller;
use App\Models\PracticeSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Show the learner dashboard.
     */
    public function index()
    {
        $learner = auth('learner')->user();
        
        // Get enrolled certifications (limit to 3 for dashboard)
        $enrolledCertifications = $learner->certifications()
            ->wherePivot('status', '!=', 'dropped')
            ->limit(3)
            ->get();
        
        // Calculate statistics
        $completedPracticeSessions = $learner->practiceSessions()
            ->where('completed', true)
            ->get();
        
        $totalPracticeSessions = $completedPracticeSessions->count();
        $averageScore = $totalPracticeSessions > 0 
            ? round($completedPracticeSessions->avg('score_percentage'), 1)
            : 0;
        
        // Get recent practice sessions (last 5)
        $recentPracticeSessions = $learner->practiceSessions()
            ->where('completed', true)
            ->with('certification')
            ->orderBy('completed_at', 'desc')
            ->limit(5)
            ->get();
        
        // Calculate study streak (consecutive days with practice)
        $studyStreak = $this->calculateStudyStreak($learner);
        
        $stats = [
            'enrolled_certifications' => $learner->certifications()->count(),
            'practice_sessions' => $totalPracticeSessions,
            'average_score' => $averageScore,
            'study_streak' => $studyStreak,
            'exam_attempts' => $learner->examAttempts()->count(),
            'certificates_earned' => $learner->validCertificates()->count(),
        ];
        
        return view('learner.dashboard', compact('enrolledCertifications', 'stats', 'recentPracticeSessions'));
    }
    
    /**
     * Calculate the learner's study streak (consecutive days with practice).
     */
    private function calculateStudyStreak($learner)
    {
        $sessions = PracticeSession::where('learner_id', $learner->id)
            ->where('completed', true)
            ->orderBy('completed_at', 'desc')
            ->get();
        
        if ($sessions->isEmpty()) {
            return 0;
        }
        
        $streak = 0;
        $currentDate = now()->startOfDay();
        
        // Group sessions by date
        $sessionDates = $sessions->pluck('completed_at')
            ->map(fn($date) => $date->startOfDay())
            ->unique()
            ->values();
        
        // Check if there's a session today or yesterday
        $lastSessionDate = $sessionDates->first();
        $daysDiff = $currentDate->diffInDays($lastSessionDate);
        
        if ($daysDiff > 1) {
            return 0; // Streak broken
        }
        
        // Count consecutive days
        $expectedDate = $lastSessionDate;
        foreach ($sessionDates as $sessionDate) {
            if ($sessionDate->equalTo($expectedDate)) {
                $streak++;
                $expectedDate = $expectedDate->subDay();
            } else {
                break;
            }
        }
        
        return $streak;
    }
}
