<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Learner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LearnerController extends Controller
{
    /**
     * Display a listing of learners.
     */
    public function index(Request $request)
    {
        $query = Learner::query();

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Status filter
        if ($request->filled('status')) {
            // For future implementation when we add status field
        }

        $learners = $query->latest()->paginate(15);

        return view('admin.learners.index', compact('learners'));
    }

    /**
     * Show the form for creating a new learner.
     */
    public function create()
    {
        return view('admin.learners.create');
    }

    /**
     * Store a newly created learner in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:learners',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $learner = Learner::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()->route('admin.learners.index')
            ->with('success', 'Learner created successfully!');
    }

    /**
     * Display the specified learner.
     */
    public function show(Learner $learner)
    {
        return view('admin.learners.show', compact('learner'));
    }

    /**
     * Show the form for editing the specified learner.
     */
    public function edit(Learner $learner)
    {
        return view('admin.learners.edit', compact('learner'));
    }

    /**
     * Update the specified learner in storage.
     */
    public function update(Request $request, Learner $learner)
    {

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:learners,email,' . $learner->id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $learner->name = $validated['name'];
        $learner->email = $validated['email'];
        
        if ($request->filled('password')) {
            $learner->password = Hash::make($validated['password']);
        }
        
        $learner->save();

        return redirect()->route('admin.learners.show', $learner)
            ->with('success', 'Learner updated successfully!');
    }

    /**
     * Remove the specified learner from storage.
     */
    public function destroy(Learner $learner)
    {

        $learner->delete();

        return redirect()->route('admin.learners.index')
            ->with('success', 'Learner deleted successfully!');
    }

    /**
     * Toggle the status of the specified learner.
     */
    public function toggleStatus(Learner $learner)
    {

        $newStatus = $learner->status === 'active' ? 'disabled' : 'active';
        
        // Check permission based on the action
        $requiredPermission = $newStatus === 'disabled' ? 'learners.disable' : 'learners.enable';
        
        if (!auth()->user()->hasPermission($requiredPermission)) {
            abort(403, 'You do not have permission to ' . ($newStatus === 'disabled' ? 'disable' : 'enable') . ' learner accounts.');
        }
        $learner->status = $newStatus;
        $learner->save();

        $message = $newStatus === 'disabled' 
            ? 'Learner account has been disabled successfully!' 
            : 'Learner account has been enabled successfully!';

        return redirect()->back()->with('success', $message);
    }
}
