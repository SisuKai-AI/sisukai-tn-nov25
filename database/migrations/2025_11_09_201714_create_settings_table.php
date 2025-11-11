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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->string('type')->default('string'); // string, integer, boolean, json
            $table->text('description')->nullable();
            $table->timestamps();
        });
        
        // Insert default settings
        DB::table('settings')->insert([
            [
                'key' => 'trial_period_days',
                'value' => '7',
                'type' => 'integer',
                'description' => 'Number of days for free trial period',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'key' => 'site_name',
                'value' => 'SisuKai',
                'type' => 'string',
                'description' => 'Site name displayed in emails and pages',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'key' => 'support_email',
                'value' => 'support@sisukai.com',
                'type' => 'string',
                'description' => 'Support email address',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
