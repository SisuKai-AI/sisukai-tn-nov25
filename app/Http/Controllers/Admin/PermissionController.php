<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public function index(Request $request)
    {
        $query = Permission::withCount('roles');
        
        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('display_name', 'like', "%{$search}%")
                  ->orWhere('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }
        
        // Category filter
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }
        
        $permissions = $query->orderBy('category')
            ->orderBy('display_name')
            ->get()
            ->groupBy('category');
        
        // Get all unique categories for filter dropdown
        $categories = Permission::select('category')
            ->distinct()
            ->orderBy('category')
            ->pluck('category');
            
        return view('admin.permissions.index', compact('permissions', 'categories'));
    }

    public function show(Permission $permission)
    {
        $permission->load('roles.users');
        $permission->loadCount('roles');
        
        return view('admin.permissions.show', compact('permission'));
    }
}

