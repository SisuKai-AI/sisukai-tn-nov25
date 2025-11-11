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
        Schema::table('learners', function (Blueprint $table) {
            $table->timestamp('trial_started_at')->nullable()->after('updated_at');
            $table->timestamp('trial_ends_at')->nullable()->after('trial_started_at');
            $table->uuid('trial_certification_id')->nullable()->comment('Certification enrolled during trial')->after('trial_ends_at');
            $table->boolean('has_had_trial')->default(false)->comment('Prevent multiple trials')->after('trial_certification_id');
            $table->string('stripe_customer_id')->nullable()->after('has_had_trial');
            $table->string('paddle_customer_id')->nullable()->after('stripe_customer_id');
            
            // Foreign key for trial certification
            $table->foreign('trial_certification_id')
                ->references('id')
                ->on('certifications')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('learners', function (Blueprint $table) {
            $table->dropForeign(['trial_certification_id']);
            $table->dropColumn([
                'trial_started_at',
                'trial_ends_at',
                'trial_certification_id',
                'has_had_trial',
                'stripe_customer_id',
                'paddle_customer_id',
            ]);
        });
    }
};
