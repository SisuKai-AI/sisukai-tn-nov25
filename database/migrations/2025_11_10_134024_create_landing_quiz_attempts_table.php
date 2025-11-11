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
        Schema::create('landing_quiz_attempts', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('certification_id');
            $table->string('session_id');
            $table->integer('score')->comment('Score out of 5');
            $table->json('answers')->nullable()->comment('Array of {question_id, selected_answer, is_correct}');
            $table->timestamp('completed_at')->nullable();
            $table->boolean('converted_to_registration')->default(false);
            $table->uuid('learner_id')->nullable()->comment('Set after registration if conversion happens');
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->timestamps();

            // Foreign keys
            $table->foreign('certification_id')
                ->references('id')
                ->on('certifications')
                ->onDelete('cascade');
            
            $table->foreign('learner_id')
                ->references('id')
                ->on('learners')
                ->onDelete('set null');

            // Indexes
            $table->index('session_id');
            $table->index('certification_id');
            $table->index('completed_at');
            $table->index('converted_to_registration');
            $table->index(['certification_id', 'converted_to_registration'], 'idx_cert_converted');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('landing_quiz_attempts');
    }
};
