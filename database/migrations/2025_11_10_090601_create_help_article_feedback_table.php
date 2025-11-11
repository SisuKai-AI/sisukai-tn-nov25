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
        Schema::create('help_article_feedback', function (Blueprint $table) {
            $table->id();
            $table->foreignId('help_article_id')->constrained('help_articles')->onDelete('cascade');
            $table->string('session_id', 255)->index(); // Track by session to prevent duplicate votes
            $table->boolean('is_helpful'); // true = helpful, false = not helpful
            $table->text('comment')->nullable(); // Optional feedback comment
            $table->string('ip_address', 45)->nullable(); // Store IP for analytics
            $table->timestamps();
            
            // Ensure one vote per session per article
            $table->unique(['help_article_id', 'session_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('help_article_feedback');
    }
};
