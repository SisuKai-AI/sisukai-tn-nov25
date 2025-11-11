<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Certification;
use App\Models\CertificationLandingQuizQuestion;
use App\Models\Question;
use Illuminate\Http\Request;

class LandingQuizQuestionController extends Controller
{
    public function index()
    {
        $certifications = Certification::withCount('landingQuizQuestions')
            ->orderBy('name')
            ->paginate(20);

        return view('admin.landing-quiz-questions.index', compact('certifications'));
    }

    public function edit(Certification $certification)
    {
        $selectedQuestions = $certification->landingQuizQuestions()
            ->with('question')
            ->orderBy('order')
            ->get();

        $availableQuestions = Question::where('certification_id', $certification->id)
            ->where('status', 'approved')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.landing-quiz-questions.edit', compact(
            'certification',
            'selectedQuestions',
            'availableQuestions'
        ));
    }

    public function update(Request $request, Certification $certification)
    {
        $request->validate([
            'question_ids' => 'required|array|min:5|max:5',
            'question_ids.*' => 'required|exists:questions,id',
        ], [
            'question_ids.min' => 'You must select exactly 5 questions.',
            'question_ids.max' => 'You must select exactly 5 questions.',
        ]);

        CertificationLandingQuizQuestion::where('certification_id', $certification->id)->delete();

        foreach ($request->question_ids as $order => $questionId) {
            CertificationLandingQuizQuestion::create([
                'certification_id' => $certification->id,
                'question_id' => $questionId,
                'order' => $order + 1,
            ]);
        }

        return redirect()
            ->route('admin.landing-quiz-questions.edit', $certification)
            ->with('success', 'Landing page quiz questions updated successfully! 5 questions selected.');
    }

    public function destroy(Certification $certification)
    {
        CertificationLandingQuizQuestion::where('certification_id', $certification->id)->delete();

        return redirect()
            ->route('admin.landing-quiz-questions.index')
            ->with('success', 'All landing page quiz questions removed for ' . $certification->name);
    }

    public function analytics()
    {
        $certifications = Certification::withCount([
            'landingQuizQuestions',
            'landingQuizAttempts',
            'landingQuizAttempts as converted_attempts_count' => function ($query) {
                $query->where('converted_to_registration', true);
            }
        ])
        ->having('landing_quiz_attempts_count', '>', 0)
        ->orderBy('landing_quiz_attempts_count', 'desc')
        ->get()
        ->map(function ($cert) {
            $cert->conversion_rate = $cert->landing_quiz_attempts_count > 0
                ? round(($cert->converted_attempts_count / $cert->landing_quiz_attempts_count) * 100, 2)
                : 0;
            return $cert;
        });

        return view('admin.landing-quiz-questions.analytics', compact('certifications'));
    }
}
