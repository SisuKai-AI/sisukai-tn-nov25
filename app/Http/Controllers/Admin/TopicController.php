<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Domain;
use App\Models\Topic;
use Illuminate\Http\Request;

class TopicController extends Controller
{
    /**
     * Display a listing of topics for a domain.
     */
    public function index(Domain $domain)
    {
        $domain->load('certification');
        $topics = $domain->topics()->withCount('questions')->ordered()->get();
        return view('admin.topics.index', compact('domain', 'topics'));
    }

    /**
     * Show the form for creating a new topic.
     */
    public function create(Domain $domain)
    {
        $domain->load('certification');
        return view('admin.topics.create', compact('domain'));
    }

    /**
     * Store a newly created topic in storage.
     */
    public function store(Request $request, Domain $domain)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'order' => 'nullable|integer|min:0',
        ]);

        $validated['domain_id'] = $domain->id;
        
        // Auto-set order if not provided
        if (!isset($validated['order'])) {
            $validated['order'] = $domain->topics()->max('order') + 1;
        }

        $topic = Topic::create($validated);

        return redirect()
            ->route('admin.domains.topics.index', $domain)
            ->with('success', 'Topic created successfully!');
    }

    /**
     * Display the specified topic.
     */
    public function show(Domain $domain, Topic $topic)
    {
        $domain->load('certification');
        $topic->load('questions');
        return view('admin.topics.show', compact('domain', 'topic'));
    }

    /**
     * Show the form for editing the specified topic.
     */
    public function edit(Domain $domain, Topic $topic)
    {
        $domain->load('certification');
        return view('admin.topics.edit', compact('domain', 'topic'));
    }

    /**
     * Update the specified topic in storage.
     */
    public function update(Request $request, Domain $domain, Topic $topic)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'order' => 'nullable|integer|min:0',
        ]);

        $topic->update($validated);

        return redirect()
            ->route('admin.domains.topics.index', $domain)
            ->with('success', 'Topic updated successfully!');
    }

    /**
     * Remove the specified topic from storage.
     */
    public function destroy(Domain $domain, Topic $topic)
    {
        $name = $topic->name;
        $topic->delete();

        return redirect()
            ->route('admin.domains.topics.index', $domain)
            ->with('success', "Topic '{$name}' deleted successfully!");
    }
}

