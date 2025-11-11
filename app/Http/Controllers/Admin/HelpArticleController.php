<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HelpArticle;
use App\Models\HelpCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class HelpArticleController extends Controller
{
    /**
     * Display a listing of help articles
     */
    public function index()
    {
        $articles = HelpArticle::with('category')
            ->orderBy('order')
            ->paginate(20);
        
        return view('admin.help-articles.index', compact('articles'));
    }

    /**
     * Show the form for creating a new help article
     */
    public function create()
    {
        $categories = HelpCategory::orderBy('order')->get();
        return view('admin.help-articles.create', compact('categories'));
    }

    /**
     * Store a newly created help article
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'nullable|exists:help_categories,id',
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|unique:help_articles,slug',
            'content' => 'required|string',
            'order' => 'nullable|integer|min:0',
            'is_featured' => 'nullable|boolean',
        ]);

        // Auto-generate slug if not provided
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        // Ensure is_featured is boolean
        $validated['is_featured'] = $request->has('is_featured');

        HelpArticle::create($validated);

        return redirect()
            ->route('admin.help-articles.index')
            ->with('success', 'Help article created successfully!');
    }

    /**
     * Show the form for editing a help article
     */
    public function edit(HelpArticle $helpArticle)
    {
        $categories = HelpCategory::orderBy('order')->get();
        return view('admin.help-articles.edit', compact('helpArticle', 'categories'));
    }

    /**
     * Update the specified help article
     */
    public function update(Request $request, HelpArticle $helpArticle)
    {
        $validated = $request->validate([
            'category_id' => 'nullable|exists:help_categories,id',
            'title' => 'required|string|max:255',
            'slug' => 'required|string|unique:help_articles,slug,' . $helpArticle->id,
            'content' => 'required|string',
            'order' => 'nullable|integer|min:0',
            'is_featured' => 'nullable|boolean',
        ]);

        // Ensure is_featured is boolean
        $validated['is_featured'] = $request->has('is_featured');

        $helpArticle->update($validated);

        return redirect()
            ->route('admin.help-articles.index')
            ->with('success', 'Help article updated successfully!');
    }

    /**
     * Remove the specified help article
     */
    public function destroy(HelpArticle $helpArticle)
    {
        $helpArticle->delete();

        return redirect()
            ->route('admin.help-articles.index')
            ->with('success', 'Help article deleted successfully!');
    }
}
