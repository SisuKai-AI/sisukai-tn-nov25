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
        Schema::create('payment_processor_settings', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->enum('processor', ['stripe', 'paddle']);
            $table->boolean('is_active')->default(false);
            $table->boolean('is_default')->default(false);
            $table->json('config')->comment('Encrypted API keys and settings');
            $table->timestamps();

            // Unique constraint - one record per processor
            $table->unique('processor');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_processor_settings');
    }
};
