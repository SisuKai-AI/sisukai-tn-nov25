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
            $table->boolean('two_factor_enabled')->default(false)->after('email_verified_at');
            $table->string('two_factor_method')->nullable()->after('two_factor_enabled'); // 'email' or 'sms'
            $table->string('two_factor_code', 6)->nullable()->after('two_factor_method');
            $table->timestamp('two_factor_expires_at')->nullable()->after('two_factor_code');
            $table->string('two_factor_phone')->nullable()->after('two_factor_expires_at'); // For future SMS support
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('learners', function (Blueprint $table) {
            $table->dropColumn([
                'two_factor_enabled',
                'two_factor_method',
                'two_factor_code',
                'two_factor_expires_at',
                'two_factor_phone'
            ]);
        });
    }
};
