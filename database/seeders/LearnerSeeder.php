<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Learner;
use Illuminate\Support\Facades\Hash;

class LearnerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create test learner accounts
        $learners = [
            [
                'name' => 'Test Learner',
                'email' => 'learner@sisukai.com',
                'password' => Hash::make('password123'),
                'status' => 'active',
                'email_verified_at' => now(),
            ],
            [
                'name' => 'John Doe',
                'email' => 'john.doe@example.com',
                'password' => Hash::make('password123'),
                'status' => 'active',
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Jane Smith',
                'email' => 'jane.smith@example.com',
                'password' => Hash::make('password123'),
                'status' => 'active',
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Mike Johnson',
                'email' => 'mike.johnson@example.com',
                'password' => Hash::make('password123'),
                'status' => 'disabled',
                'email_verified_at' => now(),
            ],
        ];

        foreach ($learners as $learnerData) {
            Learner::updateOrCreate(
                ['email' => $learnerData['email']],
                $learnerData
            );
        }

        $this->command->info('Created ' . count($learners) . ' test learner accounts.');
    }
}
