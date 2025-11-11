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
        Schema::create('payments', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('learner_id');
            $table->enum('payment_type', ['single_cert', 'subscription_monthly', 'subscription_annual']);
            $table->uuid('certification_id')->nullable()->comment('For single cert purchases');
            $table->uuid('subscription_plan_id')->nullable()->comment('For subscription purchases');
            $table->decimal('amount', 10, 2);
            $table->string('currency', 3)->default('USD');
            $table->enum('status', ['pending', 'completed', 'failed', 'refunded'])->default('pending');
            $table->enum('payment_processor', ['stripe', 'paddle']);
            $table->string('processor_payment_id')->nullable()->comment('Stripe payment intent ID or Paddle order ID');
            $table->string('processor_customer_id')->nullable()->comment('Stripe customer ID or Paddle customer ID');
            $table->json('metadata')->nullable()->comment('Additional payment data');
            $table->timestamp('paid_at')->nullable();
            $table->timestamp('refunded_at')->nullable();
            $table->timestamps();

            // Foreign keys
            $table->foreign('learner_id')
                ->references('id')
                ->on('learners')
                ->onDelete('cascade');
            
            $table->foreign('certification_id')
                ->references('id')
                ->on('certifications')
                ->onDelete('set null');
            
            $table->foreign('subscription_plan_id')
                ->references('id')
                ->on('subscription_plans')
                ->onDelete('set null');

            // Indexes
            $table->index('learner_id');
            $table->index('status');
            $table->index(['payment_processor', 'processor_payment_id'], 'idx_processor_payment');
            $table->index('paid_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
