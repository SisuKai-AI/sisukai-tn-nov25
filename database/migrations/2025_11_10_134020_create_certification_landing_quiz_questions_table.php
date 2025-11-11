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
        Schema::create('certification_landing_quiz_questions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('certification_id');
            $table->uuid('question_id');
            $table->integer('order')->default(0);
            $table->timestamps();

            // Foreign keys
            $table->foreign('certification_id')
                ->references('id')
                ->on('certifications')
                ->onDelete('cascade');
            
            $table->foreign('question_id')
                ->references('id')
                ->on('questions')
                ->onDelete('cascade');

            // Unique constraint - each question can only be selected once per certification
            $table->unique(['certification_id', 'question_id'], 'unique_cert_question');

            // Indexes
            $table->index('certification_id');
            $table->index(['certification_id', 'order'], 'idx_cert_order');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('certification_landing_quiz_questions');
    }
};
