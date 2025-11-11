<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all roles
        $superAdmin = Role::where('name', 'super_admin')->first();
        $contentManager = Role::where('name', 'content_manager')->first();
        $supportStaff = Role::where('name', 'support_staff')->first();

        // Get all permissions
        $allPermissions = Permission::all();
        
        // Super Admin: All permissions (26 permissions)
        if ($superAdmin) {
            $superAdmin->permissions()->sync($allPermissions->pluck('id'));
            $this->command->info('✓ Assigned all ' . $allPermissions->count() . ' permissions to Super Admin');
        }

        // Content Manager: Content Management + View Learners (17 permissions)
        if ($contentManager) {
            $contentManagerPermissions = Permission::whereIn('name', [
                // Content Management (16 permissions)
                'certifications.create',
                'certifications.delete',
                'certifications.edit',
                'certifications.view',
                'domains.create',
                'domains.delete',
                'domains.edit',
                'domains.view',
                'topics.create',
                'topics.delete',
                'topics.edit',
                'topics.view',
                'questions.create',
                'questions.delete',
                'questions.edit',
                'questions.view',
                // Learner Management (1 permission - read-only)
                'learners.view',
            ])->pluck('id');
            
            $contentManager->permissions()->sync($contentManagerPermissions);
            $this->command->info('✓ Assigned ' . $contentManagerPermissions->count() . ' permissions to Content Manager');
        }

        // Support Staff: View Learners only (1 permission)
        if ($supportStaff) {
            $supportStaffPermissions = Permission::whereIn('name', [
                'learners.view',
            ])->pluck('id');
            
            $supportStaff->permissions()->sync($supportStaffPermissions);
            $this->command->info('✓ Assigned ' . $supportStaffPermissions->count() . ' permission to Support Staff');
        }
    }
}
