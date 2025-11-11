<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('exam_attempts', function (Blueprint $table) {
            // Add exam session management fields
            $table->string('exam_type')->default('final')->after('completed_at'); // benchmark, practice, final
            $table->integer('time_limit_minutes')->nullable()->after('exam_type');
            $table->json('questions_per_domain')->nullable()->after('time_limit_minutes');
            $table->boolean('adaptive_mode')->default(false)->after('questions_per_domain');
            $table->string('difficulty_level')->nullable()->after('adaptive_mode'); // easy, medium, hard, mixed
            $table->integer('attempt_number')->default(1)->after('difficulty_level');
            $table->integer('correct_answers')->nullable()->after('attempt_number');
            $table->decimal('score_percentage', 5, 2)->nullable()->after('correct_answers');
            $table->integer('passing_score')->default(70)->after('score_percentage');
            $table->string('status', 20)->default('created')->after('passing_score'); // created, in_progress, completed, abandoned
            $table->integer('duration_minutes')->nullable()->after('status');
            
            // Add indexes for faster filtering
            $table->index('exam_type');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('exam_attempts', function (Blueprint $table) {
            $table->dropIndex(['exam_type']);
            $table->dropIndex(['status']);
            
            $table->dropColumn([
                'exam_type',
                'time_limit_minutes',
                'questions_per_domain',
                'adaptive_mode',
                'difficulty_level',
                'attempt_number',
                'correct_answers',
                'score_percentage',
                'passing_score',
                'status',
                'duration_minutes',
            ]);
        });
    }
};
