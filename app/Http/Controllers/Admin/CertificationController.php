<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Certification;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CertificationController extends Controller
{
    /**
     * Display a listing of the certifications.
     */
    public function index(Request $request)
    {
        $query = Certification::withCount(['domains', 'examAttempts', 'certificates']);

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('slug', 'like', "%{$search}%")
                  ->orWhere('provider', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Filter by provider
        if ($request->filled('provider')) {
            $query->where('provider', $request->provider);
        }

        // Filter by status
        if ($request->filled('status')) {
            $isActive = $request->status === 'active' ? 1 : 0;
            $query->where('is_active', $isActive);
        }

        // Sorting
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        $certifications = $query->paginate(15)->withQueryString();
        
        // Get unique providers for filter dropdown
        $providers = Certification::select('provider')
            ->distinct()
            ->orderBy('provider')
            ->pluck('provider');

        return view('admin.certifications.index', compact('certifications', 'providers'));
    }

    /**
     * Show the form for creating a new certification.
     */
    public function create()
    {
        return view('admin.certifications.create');
    }

    /**
     * Store a newly created certification in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:certifications,slug',
            'description' => 'required|string',
            'provider' => 'required|string|max:255',
            'exam_question_count' => 'required|integer|min:1',
            'exam_duration_minutes' => 'required|integer|min:1',
            'passing_score' => 'required|integer|min:0|max:100',
            'price_single_cert' => 'required|numeric|min:0',
            'is_active' => 'boolean',
        ]);

        // Generate slug if not provided
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }
        
        // Ensure all required fields are present
        if (!isset($validated['is_active'])) {
            $validated['is_active'] = false;
        }

        $certification = Certification::create($validated);

        return redirect()
            ->route('admin.certifications.show', $certification)
            ->with('success', 'Certification created successfully!');
    }

    /**
     * Display the specified certification.
     */
    public function show(Certification $certification)
    {
        $certification->load(['domains.topics', 'examAttempts', 'certificates']);
        
        $stats = [
            'total_domains' => $certification->domains()->count(),
            'total_topics' => $certification->domains()->withCount('topics')->get()->sum('topics_count'),
            'total_questions' => $certification->domains()
                ->join('topics', 'domains.id', '=', 'topics.domain_id')
                ->join('questions', 'topics.id', '=', 'questions.topic_id')
                ->count(),
            'total_attempts' => $certification->examAttempts()->count(),
            'passed_attempts' => $certification->examAttempts()->where('passed', true)->count(),
            'total_certificates' => $certification->certificates()->count(),
        ];

        return view('admin.certifications.show', compact('certification', 'stats'));
    }

    /**
     * Show the form for editing the specified certification.
     */
    public function edit(Certification $certification)
    {
        return view('admin.certifications.edit', compact('certification'));
    }

    /**
     * Update the specified certification in storage.
     */
    public function update(Request $request, Certification $certification)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:certifications,slug,' . $certification->id,
            'description' => 'required|string',
            'provider' => 'required|string|max:255',
            'exam_question_count' => 'required|integer|min:1',
            'exam_duration_minutes' => 'required|integer|min:1',
            'passing_score' => 'required|integer|min:0|max:100',
            'price_single_cert' => 'required|numeric|min:0',
            'is_active' => 'boolean',
        ]);

        // Generate slug if not provided
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        $certification->update($validated);

        return redirect()
            ->route('admin.certifications.show', $certification)
            ->with('success', 'Certification updated successfully!');
    }

    /**
     * Remove the specified certification from storage.
     */
    public function destroy(Certification $certification)
    {
        $name = $certification->name;
        $certification->delete();

        return redirect()
            ->route('admin.certifications.index')
            ->with('success', "Certification '{$name}' deleted successfully!");
    }

    /**
     * Toggle the active status of the certification.
     */
    public function toggleStatus(Certification $certification)
    {
        $certification->update([
            'is_active' => !$certification->is_active
        ]);

        $status = $certification->is_active ? 'activated' : 'deactivated';

        return redirect()
            ->back()
            ->with('success', "Certification {$status} successfully!");
    }
}

