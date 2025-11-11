<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Http\Request;

class RolePermissionController extends Controller
{
    /**
     * Show the form for editing role permissions
     */
    public function edit(Role $role)
    {
        $role->load('permissions');
        
        // Get all permissions grouped by category
        $permissions = Permission::orderBy('category')
            ->orderBy('display_name')
            ->get()
            ->groupBy('category');
        
        // Get IDs of permissions already assigned to this role
        $assignedPermissionIds = $role->permissions->pluck('id')->toArray();
        
        return view('admin.roles.permissions', compact('role', 'permissions', 'assignedPermissionIds'));
    }
    
    /**
     * Update role permissions
     */
    public function update(Request $request, Role $role)
    {
        $request->validate([
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,id'
        ]);
        
        // Sync permissions (this will add new ones and remove unselected ones)
        $role->permissions()->sync($request->input('permissions', []));
        
        return redirect()
            ->route('admin.roles.permissions.edit', $role)
            ->with('success', 'Permissions updated successfully for ' . $role->display_name);
    }
}
