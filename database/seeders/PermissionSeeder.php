<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            // User Management
            ['name' => 'users.view', 'display_name' => 'View Users', 'description' => 'Can view list of users', 'category' => 'User Management'],
            ['name' => 'users.create', 'display_name' => 'Create Users', 'description' => 'Can create new users', 'category' => 'User Management'],
            ['name' => 'users.edit', 'display_name' => 'Edit Users', 'description' => 'Can edit existing users', 'category' => 'User Management'],
            ['name' => 'users.delete', 'display_name' => 'Delete Users', 'description' => 'Can delete users', 'category' => 'User Management'],
            
            // Learner Management
            ['name' => 'learners.view', 'display_name' => 'View Learners', 'description' => 'Can view list of learners', 'category' => 'Learner Management'],
            ['name' => 'learners.create', 'display_name' => 'Create Learners', 'description' => 'Can create new learners', 'category' => 'Learner Management'],
            ['name' => 'learners.edit', 'display_name' => 'Edit Learners', 'description' => 'Can edit existing learners', 'category' => 'Learner Management'],
            ['name' => 'learners.delete', 'display_name' => 'Delete Learners', 'description' => 'Can delete learners', 'category' => 'Learner Management'],
            
            // Certification Management
            ['name' => 'certifications.view', 'display_name' => 'View Certifications', 'description' => 'Can view list of certifications', 'category' => 'Content Management'],
            ['name' => 'certifications.create', 'display_name' => 'Create Certifications', 'description' => 'Can create new certifications', 'category' => 'Content Management'],
            ['name' => 'certifications.edit', 'display_name' => 'Edit Certifications', 'description' => 'Can edit existing certifications', 'category' => 'Content Management'],
            ['name' => 'certifications.delete', 'display_name' => 'Delete Certifications', 'description' => 'Can delete certifications', 'category' => 'Content Management'],
            
            // Domain Management
            ['name' => 'domains.view', 'display_name' => 'View Domains', 'description' => 'Can view list of domains', 'category' => 'Content Management'],
            ['name' => 'domains.create', 'display_name' => 'Create Domains', 'description' => 'Can create new domains', 'category' => 'Content Management'],
            ['name' => 'domains.edit', 'display_name' => 'Edit Domains', 'description' => 'Can edit existing domains', 'category' => 'Content Management'],
            ['name' => 'domains.delete', 'display_name' => 'Delete Domains', 'description' => 'Can delete domains', 'category' => 'Content Management'],
            
            // Topic Management
            ['name' => 'topics.view', 'display_name' => 'View Topics', 'description' => 'Can view list of topics', 'category' => 'Content Management'],
            ['name' => 'topics.create', 'display_name' => 'Create Topics', 'description' => 'Can create new topics', 'category' => 'Content Management'],
            ['name' => 'topics.edit', 'display_name' => 'Edit Topics', 'description' => 'Can edit existing topics', 'category' => 'Content Management'],
            ['name' => 'topics.delete', 'display_name' => 'Delete Topics', 'description' => 'Can delete topics', 'category' => 'Content Management'],
            
            // Question Management
            ['name' => 'questions.view', 'display_name' => 'View Questions', 'description' => 'Can view list of questions', 'category' => 'Content Management'],
            ['name' => 'questions.create', 'display_name' => 'Create Questions', 'description' => 'Can create new questions', 'category' => 'Content Management'],
            ['name' => 'questions.edit', 'display_name' => 'Edit Questions', 'description' => 'Can edit existing questions', 'category' => 'Content Management'],
            ['name' => 'questions.delete', 'display_name' => 'Delete Questions', 'description' => 'Can delete questions', 'category' => 'Content Management'],
            
            // Role Management
            ['name' => 'roles.view', 'display_name' => 'View Roles', 'description' => 'Can view list of roles', 'category' => 'Settings'],
            ['name' => 'roles.create', 'display_name' => 'Create Roles', 'description' => 'Can create new roles', 'category' => 'Settings'],
            ['name' => 'roles.edit', 'display_name' => 'Edit Roles', 'description' => 'Can edit existing roles', 'category' => 'Settings'],
            ['name' => 'roles.delete', 'display_name' => 'Delete Roles', 'description' => 'Can delete roles', 'category' => 'Settings'],
            
            // Permission Management
            ['name' => 'permissions.view', 'display_name' => 'View Permissions', 'description' => 'Can view list of permissions', 'category' => 'Settings'],
            ['name' => 'permissions.manage', 'display_name' => 'Manage Permissions', 'description' => 'Can assign permissions to roles', 'category' => 'Settings'],
            
            // System Settings
            ['name' => 'settings.view', 'display_name' => 'View Settings', 'description' => 'Can view system settings', 'category' => 'Settings'],
            ['name' => 'settings.edit', 'display_name' => 'Edit Settings', 'description' => 'Can edit system settings', 'category' => 'Settings'],
        ];

        foreach ($permissions as $permission) {
            Permission::create($permission);
        }
    }
}
