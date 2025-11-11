<?php

namespace App\Http\Controllers\Learner;

use App\Http\Controllers\Controller;
use App\Models\Certification;
use App\Models\ExamAttempt;
use Illuminate\Http\Request;

class CertificationController extends Controller
{
    /**
     * Display all available certifications.
     */
    public function index(Request $request)
    {
        $query = Certification::where('is_active', true);
        
        // Search functionality
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%')
                  ->orWhere('provider', 'like', '%' . $request->search . '%');
            });
        }
        
        // Filter by provider
        if ($request->filled('provider')) {
            $query->where('provider', $request->provider);
        }
        
        $certifications = $query->orderBy('name')->paginate(12);
        
        $providers = Certification::where('is_active', true)
            ->distinct()
            ->orderBy('provider')
            ->pluck('provider');
        
        // Get learner's enrolled certification IDs
        $learner = auth('learner')->user();
        $enrolledIds = $learner->certifications()->pluck('certification_id')->toArray();
        
        return view('learner.certifications.index', compact('certifications', 'providers', 'enrolledIds'));
    }
    
    /**
     * Display certification details.
     */
    public function show(Certification $certification)
    {
        $learner = auth('learner')->user();
        
        // Get enrollment information
        $enrollment = $learner->certifications()
            ->where('certification_id', $certification->id)
            ->first();
        
        // Load domains with topics count
        $certification->load(['domains' => function($query) {
            $query->withCount('topics')->orderBy('order');
        }]);
        
        // Get statistics
        $stats = [
            'total_questions' => $certification->questions()->where('status', 'approved')->count(),
            'total_domains' => $certification->domains()->count(),
            'enrolled_learners' => $certification->learners()->count(),
        ];
        
        // Get learner's progress if enrolled
        $progress = null;
        if ($enrollment) {
            $progress = [
                'status' => $enrollment->pivot->status,
                'progress_percentage' => $enrollment->pivot->progress_percentage,
                'enrolled_at' => $enrollment->pivot->enrolled_at,
                'started_at' => $enrollment->pivot->started_at,
                'completed_at' => $enrollment->pivot->completed_at,
            ];
        }
        
        // Check benchmark status
        $benchmarkStatus = null;
        if ($enrollment) {
            $latestBenchmark = ExamAttempt::where('learner_id', $learner->id)
                ->where('certification_id', $certification->id)
                ->where('exam_type', 'benchmark')
                ->latest()
                ->first();
            
            if ($latestBenchmark) {
                $benchmarkStatus = [
                    'exists' => true,
                    'status' => $latestBenchmark->status,
                    'score' => $latestBenchmark->score_percentage,
                    'completed_at' => $latestBenchmark->completed_at,
                    'attempt_id' => $latestBenchmark->id,
                ];
            } else {
                $benchmarkStatus = [
                    'exists' => false,
                ];
            }
        }
        
        return view('learner.certifications.show', compact('certification', 'enrollment', 'stats', 'progress', 'benchmarkStatus'));
    }
    
    /**
     * Enroll learner in certification.
     */
    public function enroll(Certification $certification)
    {
        $learner = auth('learner')->user();
        
        // Check if already enrolled
        if ($learner->isEnrolledIn($certification->id)) {
            return back()->with('error', 'You are already enrolled in this certification.');
        }
        
        // Check if certification is active
        if (!$certification->is_active) {
            return back()->with('error', 'This certification is not currently available for enrollment.');
        }
        
        $learner->certifications()->attach($certification->id, [
            'id' => \Illuminate\Support\Str::uuid(),
            'status' => 'enrolled',
            'enrolled_at' => now(),
        ]);
        
        return back()->with('success', 'Successfully enrolled in ' . $certification->name . '!');
    }
    
    /**
     * Unenroll learner from certification.
     */
    public function unenroll(Certification $certification)
    {
        $learner = auth('learner')->user();
        
        // Check if enrolled
        if (!$learner->isEnrolledIn($certification->id)) {
            return back()->with('error', 'You are not enrolled in this certification.');
        }
        
        $learner->certifications()->detach($certification->id);
        
        return back()->with('success', 'Successfully unenrolled from ' . $certification->name . '.');
    }
    
    /**
     * Display learner's enrolled certifications.
     */
    public function myCertifications()
    {
        $learner = auth('learner')->user();
        
        $certifications = $learner->certifications()
            ->withCount([
                'practiceSessions as practice_sessions_count' => function($query) use ($learner) {
                    $query->where('learner_id', $learner->id);
                },
                'examAttempts as exam_attempts_count' => function($query) use ($learner) {
                    $query->where('learner_id', $learner->id);
                }
            ])
            ->get();
        
        return view('learner.certifications.my', compact('certifications'));
    }
}
