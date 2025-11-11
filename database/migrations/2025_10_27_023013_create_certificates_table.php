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
        Schema::create('certificates', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('learner_id');
            $table->uuid('certification_id');
            $table->uuid('exam_attempt_id')->unique();
            $table->string('certificate_number')->unique();
            $table->enum('status', ['valid', 'revoked'])->default('valid');
            $table->text('revocation_reason')->nullable();
            $table->uuid('revoked_by')->nullable();
            $table->timestamp('issued_at')->useCurrent();
            $table->timestamp('revoked_at')->nullable();

            $table->foreign('learner_id')->references('id')->on('learners')->onDelete('cascade');
            $table->foreign('certification_id')->references('id')->on('certifications')->onDelete('cascade');
            $table->foreign('exam_attempt_id')->references('id')->on('exam_attempts')->onDelete('cascade');
            $table->foreign('revoked_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('certificates');
    }
};
