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
        Schema::table('learner_subscriptions', function (Blueprint $table) {
            $table->enum('payment_processor', ['stripe', 'paddle'])->nullable()->after('subscription_plan_id');
            $table->string('processor_subscription_id')->nullable()->comment('Stripe subscription ID or Paddle subscription ID')->after('payment_processor');
            $table->string('processor_customer_id')->nullable()->comment('Stripe customer ID or Paddle customer ID')->after('processor_subscription_id');
            $table->timestamp('next_billing_date')->nullable()->after('ends_at');
            $table->boolean('auto_renew')->default(true)->after('next_billing_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('learner_subscriptions', function (Blueprint $table) {
            $table->dropColumn([
                'payment_processor',
                'processor_subscription_id',
                'processor_customer_id',
                'next_billing_date',
                'auto_renew',
            ]);
        });
    }
};
