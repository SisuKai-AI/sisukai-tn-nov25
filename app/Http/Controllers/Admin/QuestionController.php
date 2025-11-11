<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\Topic;
use App\Models\Certification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class QuestionController extends Controller
{
    /**
     * Display a listing of questions.
     */
    public function index(Request $request)
    {
        $query = Question::with(['topic.domain.certification', 'answers']);
        $topic = null;

        // Filter by topic (for topic-scoped view)
        if ($request->has('topic_id')) {
            $topic = Topic::with(['domain.certification'])->findOrFail($request->topic_id);
            $query->where('topic_id', $topic->id);
        }

        // Filter by certification
        if ($request->has('certification_id') && $request->certification_id != '') {
            $certId = $request->certification_id;
            $query->whereHas('topic.domain.certification', function ($q) use ($certId) {
                $q->where('id', $certId);
            });
        }

        // Filter by difficulty
        if ($request->has('difficulty') && $request->difficulty != '') {
            $query->where('difficulty', $request->difficulty);
        }

        // Filter by status
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        $questions = $query->orderBy('created_at', 'desc')->paginate(20);
        $certifications = Certification::orderBy('name')->get();

        return view('admin.questions.index', compact('questions', 'certifications', 'topic'));
    }

    /**
     * Show the form for creating a new question.
     */
    public function create(Request $request)
    {
        $certifications = Certification::with('domains.topics')->orderBy('name')->get();
        $selectedTopic = $request->has('topic_id') ? Topic::with('domain.certification')->find($request->topic_id) : null;

        return view('admin.questions.create', compact('certifications', 'selectedTopic'));
    }

    /**
     * Store a newly created question in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'topic_id' => 'required|exists:topics,id',
            'question_text' => 'required|string',
            'explanation' => 'nullable|string',
            'difficulty' => 'required|in:easy,medium,hard',
            'status' => 'required|in:draft,pending_review,approved,archived',
            'answers' => 'required|array|min:2|max:6',
            'answers.*.answer_text' => 'required|string',
            'answers.*.is_correct' => 'required|boolean',
        ]);

        // Validate that exactly one answer is correct
        $correctCount = collect($validated['answers'])->where('is_correct', true)->count();
        if ($correctCount !== 1) {
            return back()->withErrors(['answers' => 'Exactly one answer must be marked as correct.'])->withInput();
        }

        DB::beginTransaction();
        try {
            $question = Question::create([
                'topic_id' => $validated['topic_id'],
                'question_text' => $validated['question_text'],
                'explanation' => $validated['explanation'],
                'difficulty' => $validated['difficulty'],
                'status' => $validated['status'],
                'created_by' => Auth::id(),
            ]);

            // Create answers
            foreach ($validated['answers'] as $index => $answerData) {
                $question->answers()->create([
                    'answer_text' => $answerData['answer_text'],
                    'is_correct' => $answerData['is_correct'],
                    'order' => $index + 1,
                ]);
            }

            DB::commit();

            return redirect()
                ->route('admin.questions.show', $question)
                ->with('success', 'Question created successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Failed to create question: ' . $e->getMessage()])->withInput();
        }
    }

    /**
     * Display the specified question.
     */
    public function show(Question $question)
    {
        $question->load(['topic.domain.certification', 'answers']);
        return view('admin.questions.show', compact('question'));
    }

    /**
     * Show the form for editing the specified question.
     */
    public function edit(Question $question)
    {
        $question->load(['topic.domain.certification', 'answers']);
        $certifications = Certification::with('domains.topics')->orderBy('name')->get();

        return view('admin.questions.edit', compact('question', 'certifications'));
    }

    /**
     * Update the specified question in storage.
     */
    public function update(Request $request, Question $question)
    {
        $validated = $request->validate([
            'topic_id' => 'required|exists:topics,id',
            'question_text' => 'required|string',
            'explanation' => 'nullable|string',
            'difficulty' => 'required|in:easy,medium,hard',
            'status' => 'required|in:draft,pending_review,approved,archived',
            'answers' => 'required|array|min:2|max:6',
            'answers.*.id' => 'nullable|exists:answers,id',
            'answers.*.answer_text' => 'required|string',
            'answers.*.is_correct' => 'required|boolean',
        ]);

        // Validate that exactly one answer is correct
        $correctCount = collect($validated['answers'])->where('is_correct', true)->count();
        if ($correctCount !== 1) {
            return back()->withErrors(['answers' => 'Exactly one answer must be marked as correct.'])->withInput();
        }

        DB::beginTransaction();
        try {
            $question->update([
                'topic_id' => $validated['topic_id'],
                'question_text' => $validated['question_text'],
                'explanation' => $validated['explanation'],
                'difficulty' => $validated['difficulty'],
                'status' => $validated['status'],
            ]);

            // Get existing answer IDs
            $existingAnswerIds = $question->answers->pluck('id')->toArray();
            $submittedAnswerIds = collect($validated['answers'])->pluck('id')->filter()->toArray();

            // Delete removed answers
            $answersToDelete = array_diff($existingAnswerIds, $submittedAnswerIds);
            if (!empty($answersToDelete)) {
                $question->answers()->whereIn('id', $answersToDelete)->delete();
            }

            // Update or create answers
            foreach ($validated['answers'] as $index => $answerData) {
                if (isset($answerData['id'])) {
                    // Update existing answer
                    $question->answers()->where('id', $answerData['id'])->update([
                        'answer_text' => $answerData['answer_text'],
                        'is_correct' => $answerData['is_correct'],
                        'order' => $index + 1,
                    ]);
                } else {
                    // Create new answer
                    $question->answers()->create([
                        'answer_text' => $answerData['answer_text'],
                        'is_correct' => $answerData['is_correct'],
                        'order' => $index + 1,
                    ]);
                }
            }

            DB::commit();

            return redirect()
                ->route('admin.questions.show', $question)
                ->with('success', 'Question updated successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Failed to update question: ' . $e->getMessage()])->withInput();
        }
    }

    /**
     * Remove the specified question from storage.
     */
    public function destroy(Question $question)
    {
        $question->delete();

        return redirect()
            ->route('admin.questions.index')
            ->with('success', 'Question deleted successfully!');
    }

    /**
     * Approve a question.
     */
    public function approve(Question $question)
    {
        $question->update(['status' => 'approved']);

        return redirect()
            ->back()
            ->with('success', 'Question approved successfully!');
    }

    /**
     * Archive a question.
     */
    public function archive(Question $question)
    {
        $question->update(['status' => 'archived']);

        return redirect()
            ->back()
            ->with('success', 'Question archived successfully!');
    }

    /**
     * Bulk approve questions.
     */
    public function bulkApprove(Request $request)
    {
        $request->validate([
            'question_ids' => 'required|json'
        ]);

        $questionIds = json_decode($request->question_ids);
        
        if (empty($questionIds)) {
            return redirect()
                ->back()
                ->withErrors(['error' => 'No questions selected.']);
        }

        $count = Question::whereIn('id', $questionIds)
            ->where('status', 'draft')
            ->update(['status' => 'approved']);

        return redirect()
            ->back()
            ->with('success', "Successfully approved {$count} question(s)!");
    }
}

