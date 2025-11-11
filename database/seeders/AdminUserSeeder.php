<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Super Admin user
        $superAdmin = User::updateOrCreate(
            ['email' => 'admin@sisukai.com'],
            [
                'name' => 'Super Admin',
                'email' => 'admin@sisukai.com',
                'password' => Hash::make('password123'),
                'user_type' => 'admin',
                'email_verified_at' => now(),
            ]
        );
        
        $superAdminRole = Role::where('name', 'super_admin')->first();
        if ($superAdminRole) {
            $superAdmin->roles()->syncWithoutDetaching([$superAdminRole->id]);
        }
        
        // Create Content Manager user
        $contentManager = User::updateOrCreate(
            ['email' => 'content@sisukai.com'],
            [
                'name' => 'Content Manager',
                'email' => 'content@sisukai.com',
                'password' => Hash::make('password123'),
                'user_type' => 'admin',
                'email_verified_at' => now(),
            ]
        );
        
        $contentManagerRole = Role::where('name', 'content_manager')->first();
        if ($contentManagerRole) {
            $contentManager->roles()->syncWithoutDetaching([$contentManagerRole->id]);
        }
        
        // Create Support Staff user
        $supportStaff = User::updateOrCreate(
            ['email' => 'support@sisukai.com'],
            [
                'name' => 'Support Staff',
                'email' => 'support@sisukai.com',
                'password' => Hash::make('password123'),
                'user_type' => 'admin',
                'email_verified_at' => now(),
            ]
        );
        
        $supportStaffRole = Role::where('name', 'support_staff')->first();
        if ($supportStaffRole) {
            $supportStaff->roles()->syncWithoutDetaching([$supportStaffRole->id]);
        }

    }
}
