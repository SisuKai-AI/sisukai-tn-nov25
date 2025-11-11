<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Insert new permissions
        DB::table('permissions')->insert([
            [
                'name' => 'learners.enable',
                'display_name' => 'Enable Learners',
                'description' => 'Can enable learner accounts',
                'category' => 'Learner Management',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'learners.disable',
                'display_name' => 'Disable Learners',
                'description' => 'Can disable learner accounts',
                'category' => 'Learner Management',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove the permissions
        DB::table('permissions')->whereIn('name', ['learners.enable', 'learners.disable'])->delete();
    }
};

