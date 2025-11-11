<?php

namespace App\Http\Controllers\Learner;

use App\Http\Controllers\Controller;
use App\Models\Certification;
use App\Models\LandingQuizAttempt;
use App\Models\LearnerCertification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CertificationOnboardingController extends Controller
{
    /**
     * Show certification-specific onboarding page
     */
    public function show($certSlug)
    {
        $learner = Auth::guard('learner')->user();
        
        // Get certification
        $certification = Certification::where('slug', $certSlug)
            ->where('is_active', true)
            ->firstOrFail();
        
        // Get quiz attempt if available
        $quizAttemptId = session('onboarding_quiz_attempt_id');
        $quizAttempt = null;
        
        if ($quizAttemptId) {
            $quizAttempt = LandingQuizAttempt::find($quizAttemptId);
        }
        
        // Auto-enroll learner in certification
        $learnerCertification = LearnerCertification::firstOrCreate([
            'learner_id' => $learner->id,
            'certification_id' => $certification->id,
        ], [
            'id' => Str::uuid(),
            'enrolled_at' => now(),
            'status' => 'active',
        ]);
        
        // Clear onboarding session data
        session()->forget(['onboarding_cert_slug', 'onboarding_quiz_attempt_id']);
        
        return view('learner.certifications.onboarding', [
            'certification' => $certification,
            'learnerCertification' => $learnerCertification,
            'quizAttempt' => $quizAttempt,
        ]);
    }
}
