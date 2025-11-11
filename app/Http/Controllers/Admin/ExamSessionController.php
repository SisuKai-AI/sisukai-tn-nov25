<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Certification;
use App\Models\ExamAttempt;
use App\Models\Learner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ExamSessionController extends Controller
{
    /**
     * Display a listing of exam sessions.
     */
    public function index(Request $request)
    {
        $query = ExamAttempt::with(['learner', 'certification']);

        // Filter by exam type
        if ($request->filled('exam_type') && $request->exam_type !== 'all') {
            $query->where('exam_type', $request->exam_type);
        }

        // Filter by certification
        if ($request->filled('certification_id')) {
            $query->where('certification_id', $request->certification_id);
        }

        // Filter by status
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        // Search by learner name or email
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('learner', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Date range filter
        if ($request->filled('date_from')) {
            $query->whereDate('started_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('started_at', '<=', $request->date_to);
        }

        // Order by most recent
        $query->orderBy('created_at', 'desc');

        $examSessions = $query->paginate(25)->withQueryString();

        // Statistics
        $totalSessions = ExamAttempt::count();
        $activeSessions = ExamAttempt::where('status', ExamAttempt::STATUS_IN_PROGRESS)->count();
        $completedSessions = ExamAttempt::where('status', ExamAttempt::STATUS_COMPLETED)->count();
        $averageScore = ExamAttempt::where('status', ExamAttempt::STATUS_COMPLETED)
            ->avg('score_percentage') ?? 0;

        // Get all certifications for filter dropdown
        $certifications = Certification::orderBy('name')->get();

        return view('admin.exam-sessions.index', compact(
            'examSessions',
            'totalSessions',
            'activeSessions',
            'completedSessions',
            'averageScore',
            'certifications'
        ));
    }

    /**
     * Show the form for creating a new exam session.
     */
    public function create()
    {
        $certifications = Certification::with('domains')->orderBy('name')->get();
        $learners = Learner::where('status', 'active')->orderBy('name')->get();

        return view('admin.exam-sessions.create', compact('certifications', 'learners'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'learner_id' => 'required|exists:learners,id',
            'certification_id' => 'required|exists:certifications,id',
            'exam_type' => 'required|in:benchmark,practice,final',
            'time_limit_minutes' => 'nullable|integer|min:5|max:300',
            'total_questions' => 'required|integer|min:5|max:200',
            'passing_score' => 'required|integer|min:0|max:100',
            'difficulty_level' => 'nullable|in:easy,medium,hard,mixed',
            'adaptive_mode' => 'boolean',
        ]);

        $validated['status'] = ExamAttempt::STATUS_CREATED;
        $validated['adaptive_mode'] = $request->has('adaptive_mode');

        // Get the next attempt number for this learner and certification
        $attemptNumber = ExamAttempt::where('learner_id', $validated['learner_id'])
            ->where('certification_id', $validated['certification_id'])
            ->where('exam_type', $validated['exam_type'])
            ->max('attempt_number') + 1;

        $validated['attempt_number'] = $attemptNumber;

        $examSession = ExamAttempt::create($validated);

        return redirect()
            ->route('admin.exam-sessions.show', $examSession)
            ->with('success', 'Exam session created successfully.');
    }

    /**
     * Display the specified exam session.
     */
    public function show(ExamAttempt $examSession)
    {
        $examSession->load(['learner', 'certification.domains', 'examAnswers.question.topic.domain']);

        // Get domain scores if exam is completed
        $domainScores = [];
        $weakDomains = [];
        if ($examSession->isCompleted()) {
            $domainScores = $examSession->getDomainScores();
            $weakDomains = $examSession->getWeakDomains();
        }

        return view('admin.exam-sessions.show', compact('examSession', 'domainScores', 'weakDomains'));
    }

    /**
     * Show the form for editing the specified exam session.
     */
    public function edit(ExamAttempt $examSession)
    {
        // Only allow editing if exam hasn't started
        if ($examSession->status !== ExamAttempt::STATUS_CREATED) {
            return redirect()
                ->route('admin.exam-sessions.show', $examSession)
                ->with('error', 'Cannot edit exam session that has already started.');
        }

        $certifications = Certification::with('domains')->orderBy('name')->get();
        $learners = Learner::where('status', 'active')->orderBy('name')->get();

        return view('admin.exam-sessions.edit', compact('examSession', 'certifications', 'learners'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ExamAttempt $examSession)
    {
        // Only allow updating if exam hasn't started
        if ($examSession->status !== ExamAttempt::STATUS_CREATED) {
            return redirect()
                ->route('admin.exam-sessions.show', $examSession)
                ->with('error', 'Cannot update exam session that has already started.');
        }

        $validated = $request->validate([
            'learner_id' => 'required|exists:learners,id',
            'certification_id' => 'required|exists:certifications,id',
            'exam_type' => 'required|in:benchmark,practice,final',
            'time_limit_minutes' => 'nullable|integer|min:5|max:300',
            'total_questions' => 'required|integer|min:5|max:200',
            'passing_score' => 'required|integer|min:0|max:100',
            'difficulty_level' => 'nullable|in:easy,medium,hard,mixed',
            'adaptive_mode' => 'boolean',
        ]);

        $validated['adaptive_mode'] = $request->has('adaptive_mode');

        $examSession->update($validated);

        return redirect()
            ->route('admin.exam-sessions.show', $examSession)
            ->with('success', 'Exam session updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ExamAttempt $examSession)
    {
        // Only allow deletion if exam hasn't started
        if ($examSession->status !== ExamAttempt::STATUS_CREATED) {
            return redirect()
                ->route('admin.exam-sessions.index')
                ->with('error', 'Cannot delete exam session that has already started.');
        }

        $examSession->delete();

        return redirect()
            ->route('admin.exam-sessions.index')
            ->with('success', 'Exam session deleted successfully.');
    }

    /**
     * Display exam session analytics dashboard.
     */
    public function analytics()
    {
        // Overview statistics
        $totalSessions = ExamAttempt::count();
        $benchmarkCount = ExamAttempt::benchmark()->count();
        $practiceCount = ExamAttempt::practice()->count();
        $finalCount = ExamAttempt::final()->count();
        $overallAvgScore = ExamAttempt::completed()->avg('score_percentage') ?? 0;
        $overallPassRate = ExamAttempt::completed()->count() > 0
            ? (ExamAttempt::completed()->where('passed', true)->count() / ExamAttempt::completed()->count()) * 100
            : 0;

        // Exam type breakdown
        $benchmarkStats = [
            'count' => $benchmarkCount,
            'avg_score' => ExamAttempt::benchmark()->completed()->avg('score_percentage') ?? 0,
            'completion_rate' => $benchmarkCount > 0
                ? (ExamAttempt::benchmark()->completed()->count() / $benchmarkCount) * 100
                : 0,
        ];

        $practiceStats = [
            'count' => $practiceCount,
            'avg_score' => ExamAttempt::practice()->completed()->avg('score_percentage') ?? 0,
            'completion_rate' => $practiceCount > 0
                ? (ExamAttempt::practice()->completed()->count() / $practiceCount) * 100
                : 0,
        ];

        $finalStats = [
            'count' => $finalCount,
            'avg_score' => ExamAttempt::final()->completed()->avg('score_percentage') ?? 0,
            'pass_rate' => ExamAttempt::final()->completed()->count() > 0
                ? (ExamAttempt::final()->completed()->where('passed', true)->count() / ExamAttempt::final()->completed()->count()) * 100
                : 0,
        ];

        // Top performers
        $topPerformers = Learner::select('learners.*')
            ->selectRaw('COUNT(DISTINCT exam_attempts.certification_id) as certifications_attempted')
            ->selectRaw('AVG(exam_attempts.score_percentage) as avg_score')
            ->selectRaw('COUNT(exam_attempts.id) as total_sessions')
            ->selectRaw('SUM(CASE WHEN exam_attempts.passed = 1 THEN 1 ELSE 0 END) * 100.0 / COUNT(exam_attempts.id) as pass_rate')
            ->join('exam_attempts', 'learners.id', '=', 'exam_attempts.learner_id')
            ->where('exam_attempts.status', ExamAttempt::STATUS_COMPLETED)
            ->groupBy('learners.id', 'learners.name', 'learners.email', 'learners.status', 'learners.created_at', 'learners.updated_at', 'learners.password')
            ->orderByDesc('avg_score')
            ->limit(10)
            ->get();

        // Recent activity
        $recentActivity = ExamAttempt::with(['learner', 'certification'])
            ->completed()
            ->orderBy('completed_at', 'desc')
            ->limit(10)
            ->get();

        return view('admin.exam-sessions.analytics', compact(
            'totalSessions',
            'benchmarkCount',
            'practiceCount',
            'finalCount',
            'overallAvgScore',
            'overallPassRate',
            'benchmarkStats',
            'practiceStats',
            'finalStats',
            'topPerformers',
            'recentActivity'
        ));
    }
}

