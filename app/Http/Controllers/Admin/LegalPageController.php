<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LegalPage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class LegalPageController extends Controller
{
    public function index()
    {
        $pages = LegalPage::orderBy('created_at', 'desc')->get();
        return view('admin.legal-pages.index', compact('pages'));
    }

    public function create()
    {
        return view('admin.legal-pages.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:legal_pages',
            'content' => 'required|string',
            'meta_description' => 'nullable|string|max:255',
            'is_published' => 'boolean',
        ]);

        $validated['version'] = 1;

        LegalPage::create($validated);

        return redirect()->route('admin.legal-pages.index')
            ->with('success', 'Legal page created successfully.');
    }

    public function show(LegalPage $legalPage)
    {
        return view('admin.legal-pages.show', compact('legalPage'));
    }

    public function edit(LegalPage $legalPage)
    {
        return view('admin.legal-pages.edit', compact('legalPage'));
    }

    public function update(Request $request, LegalPage $legalPage)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:legal_pages,slug,' . $legalPage->id,
            'content' => 'required|string',
            'meta_description' => 'nullable|string|max:255',
            'is_published' => 'boolean',
        ]);

        // Increment version on content change
        if ($legalPage->content !== $validated['content']) {
            $validated['version'] = $legalPage->version + 1;
        }

        $legalPage->update($validated);

        return redirect()->route('admin.legal-pages.index')
            ->with('success', 'Legal page updated successfully.');
    }

    public function destroy(LegalPage $legalPage)
    {
        $legalPage->delete();

        return redirect()->route('admin.legal-pages.index')
            ->with('success', 'Legal page deleted successfully.');
    }
}
