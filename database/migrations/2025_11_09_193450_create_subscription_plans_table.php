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
        Schema::create('subscription_plans', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // e.g., "Free Trial", "Single-Cert", "All-Access"
            $table->string('slug')->unique(); // e.g., "free-trial", "single-cert", "all-access"
            $table->text('description')->nullable();
            $table->decimal('price_monthly', 10, 2)->default(0);
            $table->decimal('price_annual', 10, 2)->default(0);
            $table->integer('trial_days')->default(0); // Number of trial days
            $table->integer('certification_limit')->nullable(); // NULL = unlimited
            $table->boolean('has_analytics')->default(false);
            $table->boolean('has_practice_sessions')->default(true);
            $table->boolean('has_benchmark_exams')->default(true);
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscription_plans');
    }
};
