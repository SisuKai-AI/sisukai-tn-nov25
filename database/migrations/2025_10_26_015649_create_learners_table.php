<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Create learners table with UUID primary key
        Schema::create('learners', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->enum('status', ['active', 'disabled'])->default('active');
            $table->rememberToken();
            $table->timestamps();
        });

        // Migrate existing learner data from users to learners with UUID generation
        $learners = DB::table('users')->where('user_type', 'learner')->get();
        foreach ($learners as $learner) {
            DB::table('learners')->insert([
                'id' => Str::uuid()->toString(),
                'name' => $learner->name,
                'email' => $learner->email,
                'email_verified_at' => $learner->email_verified_at,
                'password' => $learner->password,
                'status' => $learner->status,
                'remember_token' => $learner->remember_token,
                'created_at' => $learner->created_at,
                'updated_at' => $learner->updated_at,
            ]);
        }

        // Delete learner records from users table
        DB::statement("DELETE FROM users WHERE user_type = 'learner'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Migrate learners back to users table
        DB::statement("
            INSERT INTO users (id, name, email, email_verified_at, password, user_type, status, remember_token, created_at, updated_at)
            SELECT id, name, email, email_verified_at, password, 'learner', status, remember_token, created_at, updated_at
            FROM learners
        ");

        // Drop learners table
        Schema::dropIfExists('learners');
    }
};
