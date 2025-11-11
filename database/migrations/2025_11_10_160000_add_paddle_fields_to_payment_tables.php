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
        // Add Paddle customer ID to learners table
        Schema::table('learners', function (Blueprint $table) {
            if (!Schema::hasColumn('learners', 'paddle_customer_id')) {
                $table->string('paddle_customer_id')->nullable()->after('stripe_customer_id');
                $table->index('paddle_customer_id');
            }
        });
        
        // Add Paddle subscription ID to learner_subscriptions table
        Schema::table('learner_subscriptions', function (Blueprint $table) {
            if (!Schema::hasColumn('learner_subscriptions', 'paddle_subscription_id')) {
                $table->string('paddle_subscription_id')->nullable()->after('stripe_subscription_id');
            }
            if (!Schema::hasColumn('learner_subscriptions', 'payment_processor')) {
                $table->string('payment_processor')->default('stripe')->after('paddle_subscription_id');
            }
            if (!Schema::hasColumn('learner_subscriptions', 'paddle_subscription_id')) {
                $table->index('paddle_subscription_id');
            }
        });
        
        // Add Paddle transaction ID to payments table
        Schema::table('payments', function (Blueprint $table) {
            if (!Schema::hasColumn('payments', 'paddle_transaction_id')) {
                $table->string('paddle_transaction_id')->nullable()->after('stripe_payment_intent_id');
            }
            if (!Schema::hasColumn('payments', 'payment_processor')) {
                $table->string('payment_processor')->default('stripe')->after('paddle_transaction_id');
            }
            if (!Schema::hasColumn('payments', 'paddle_transaction_id')) {
                $table->index('paddle_transaction_id');
            }
        });
        
        // Add Paddle transaction ID to single_certification_purchases table
        Schema::table('single_certification_purchases', function (Blueprint $table) {
            if (!Schema::hasColumn('single_certification_purchases', 'paddle_transaction_id')) {
                $table->string('paddle_transaction_id')->nullable()->after('stripe_payment_intent_id');
            }
            if (!Schema::hasColumn('single_certification_purchases', 'payment_processor')) {
                $table->string('payment_processor')->default('stripe')->after('paddle_transaction_id');
            }
            if (!Schema::hasColumn('single_certification_purchases', 'paddle_transaction_id')) {
                $table->index('paddle_transaction_id');
            }
        });
        
        // Add Paddle price IDs to subscription_plans table
        Schema::table('subscription_plans', function (Blueprint $table) {
            if (!Schema::hasColumn('subscription_plans', 'paddle_price_id_monthly')) {
                $table->string('paddle_price_id_monthly')->nullable()->after('stripe_price_id');
            }
            if (!Schema::hasColumn('subscription_plans', 'paddle_price_id_yearly')) {
                $table->string('paddle_price_id_yearly')->nullable()->after('paddle_price_id_monthly');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('learners', function (Blueprint $table) {
            $table->dropIndex(['paddle_customer_id']);
            $table->dropColumn('paddle_customer_id');
        });
        
        Schema::table('learner_subscriptions', function (Blueprint $table) {
            $table->dropIndex(['paddle_subscription_id']);
            $table->dropColumn(['paddle_subscription_id', 'payment_processor']);
        });
        
        Schema::table('payments', function (Blueprint $table) {
            $table->dropIndex(['paddle_transaction_id']);
            $table->dropColumn(['paddle_transaction_id', 'payment_processor']);
        });
        
        Schema::table('single_certification_purchases', function (Blueprint $table) {
            $table->dropIndex(['paddle_transaction_id']);
            $table->dropColumn(['paddle_transaction_id', 'payment_processor']);
        });
        
        Schema::table('subscription_plans', function (Blueprint $table) {
            $table->dropColumn(['paddle_price_id_monthly', 'paddle_price_id_yearly']);
        });
    }
};
