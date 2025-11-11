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
        Schema::table('subscription_plans', function (Blueprint $table) {
            $table->string('stripe_price_id_monthly')->nullable()->after('price_monthly');
            $table->string('stripe_price_id_annual')->nullable()->after('price_annual');
            $table->string('paddle_plan_id_monthly')->nullable()->after('stripe_price_id_annual');
            $table->string('paddle_plan_id_annual')->nullable()->after('paddle_plan_id_monthly');
            $table->integer('savings_percentage')->nullable()->comment('Annual savings vs monthly')->after('paddle_plan_id_annual');
            $table->boolean('is_featured')->default(false)->comment('Show "Best Value" badge')->after('is_active');
            $table->boolean('is_popular')->default(false)->comment('Show "Most Popular" badge')->after('is_featured');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('subscription_plans', function (Blueprint $table) {
            $table->dropColumn([
                'stripe_price_id_monthly',
                'stripe_price_id_annual',
                'paddle_plan_id_monthly',
                'paddle_plan_id_annual',
                'savings_percentage',
                'is_featured',
                'is_popular',
            ]);
        });
    }
};
