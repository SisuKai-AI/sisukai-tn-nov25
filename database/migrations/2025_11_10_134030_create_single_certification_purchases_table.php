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
        Schema::create('single_certification_purchases', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('learner_id');
            $table->uuid('certification_id');
            $table->uuid('payment_id');
            $table->decimal('price_paid', 10, 2);
            $table->timestamp('purchased_at');
            $table->timestamp('expires_at')->nullable()->comment('NULL = lifetime access');
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            // Foreign keys
            $table->foreign('learner_id')
                ->references('id')
                ->on('learners')
                ->onDelete('cascade');
            
            $table->foreign('certification_id')
                ->references('id')
                ->on('certifications')
                ->onDelete('cascade');
            
            $table->foreign('payment_id')
                ->references('id')
                ->on('payments')
                ->onDelete('cascade');

            // Unique constraint - one purchase per learner per certification
            $table->unique(['learner_id', 'certification_id'], 'unique_learner_cert');

            // Indexes
            $table->index('learner_id');
            $table->index('certification_id');
            $table->index('is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('single_certification_purchases');
    }
};
