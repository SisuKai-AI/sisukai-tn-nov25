<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HelpCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class HelpCategoryController extends Controller
{
    /**
     * Display a listing of help categories
     */
    public function index()
    {
        $categories = HelpCategory::withCount('articles')
            ->orderBy('order')
            ->paginate(20);
        
        return view('admin.help-categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new help category
     */
    public function create()
    {
        return view('admin.help-categories.create');
    }

    /**
     * Store a newly created help category
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|unique:help_categories,slug',
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:50',
            'order' => 'nullable|integer|min:0',
        ]);

        // Auto-generate slug if not provided
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        HelpCategory::create($validated);

        return redirect()
            ->route('admin.help-categories.index')
            ->with('success', 'Help category created successfully!');
    }

    /**
     * Show the form for editing a help category
     */
    public function edit(HelpCategory $helpCategory)
    {
        return view('admin.help-categories.edit', compact('helpCategory'));
    }

    /**
     * Update the specified help category
     */
    public function update(Request $request, HelpCategory $helpCategory)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|unique:help_categories,slug,' . $helpCategory->id,
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:50',
            'order' => 'nullable|integer|min:0',
        ]);

        $helpCategory->update($validated);

        return redirect()
            ->route('admin.help-categories.index')
            ->with('success', 'Help category updated successfully!');
    }

    /**
     * Remove the specified help category
     */
    public function destroy(HelpCategory $helpCategory)
    {
        $helpCategory->delete();

        return redirect()
            ->route('admin.help-categories.index')
            ->with('success', 'Help category deleted successfully!');
    }
}
