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
        Schema::create('practice_session_questions', function (Blueprint $table) {
            $table->string('practice_session_id', 36);
            $table->string('question_id', 36);
            $table->integer('question_order');
            
            $table->primary(['practice_session_id', 'question_id'], 'practice_session_questions_primary');
            
            $table->foreign('practice_session_id', 'practice_session_questions_session_fk')
                ->references('id')
                ->on('practice_sessions')
                ->onDelete('cascade');
            
            $table->foreign('question_id', 'practice_session_questions_question_fk')
                ->references('id')
                ->on('questions')
                ->onDelete('cascade');
            
            $table->index('question_order');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('practice_session_questions');
    }
};
