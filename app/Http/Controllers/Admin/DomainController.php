<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Certification;
use App\Models\Domain;
use Illuminate\Http\Request;

class DomainController extends Controller
{
    /**
     * Display a listing of domains for a certification.
     */
    public function index(Certification $certification)
    {
        $domains = $certification->domains()->withCount('topics')->ordered()->get();
        return view('admin.domains.index', compact('certification', 'domains'));
    }

    /**
     * Show the form for creating a new domain.
     */
    public function create(Certification $certification)
    {
        return view('admin.domains.create', compact('certification'));
    }

    /**
     * Store a newly created domain in storage.
     */
    public function store(Request $request, Certification $certification)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'order' => 'nullable|integer|min:0',
        ]);

        $validated['certification_id'] = $certification->id;
        
        // Auto-set order if not provided
        if (!isset($validated['order'])) {
            $validated['order'] = $certification->domains()->max('order') + 1;
        }

        $domain = Domain::create($validated);

        return redirect()
            ->route('admin.certifications.domains.index', $certification)
            ->with('success', 'Domain created successfully!');
    }

    /**
     * Display the specified domain.
     */
    public function show(Certification $certification, Domain $domain)
    {
        $domain->load('topics');
        return view('admin.domains.show', compact('certification', 'domain'));
    }

    /**
     * Show the form for editing the specified domain.
     */
    public function edit(Certification $certification, Domain $domain)
    {
        return view('admin.domains.edit', compact('certification', 'domain'));
    }

    /**
     * Update the specified domain in storage.
     */
    public function update(Request $request, Certification $certification, Domain $domain)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'order' => 'nullable|integer|min:0',
        ]);

        $domain->update($validated);

        return redirect()
            ->route('admin.certifications.domains.index', $certification)
            ->with('success', 'Domain updated successfully!');
    }

    /**
     * Remove the specified domain from storage.
     */
    public function destroy(Certification $certification, Domain $domain)
    {
        $name = $domain->name;
        $domain->delete();

        return redirect()
            ->route('admin.certifications.domains.index', $certification)
            ->with('success', "Domain '{$name}' deleted successfully!");
    }
}

