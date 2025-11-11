<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'name' => 'super_admin',
                'display_name' => 'Super Admin',
                'description' => 'Full access to all modules and features. Can manage admin users, learners, content, system settings, audit logs, database backup/restore, and subscriptions.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'content_manager',
                'display_name' => 'Content Manager',
                'description' => 'Can create/edit/delete certifications, domains, topics, questions. Can import questions and manage blog posts/FAQ. Cannot manage admin users or change system settings.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'support_staff',
                'display_name' => 'Support Staff',
                'description' => 'Read-only access to learner data. Can view learner profiles and activity, assist with account issues. Cannot edit content or manage subscriptions.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('roles')->insert($roles);
    }
}
