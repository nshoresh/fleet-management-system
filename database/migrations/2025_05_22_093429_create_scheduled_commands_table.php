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
        Schema::create('scheduled_commands', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('command'); // The artisan command to run
            $table->string('arguments')->nullable(); // JSON string of arguments
            $table->string('cron_expression'); // Cron expression for scheduling
            $table->boolean('is_active')->default(true);
            $table->timestamp('last_run_at')->nullable();
            $table->timestamp('next_run_at')->nullable();
            $table->text('description')->nullable();
            $table->integer('timeout')->default(300); // Timeout in seconds
            $table->boolean('run_in_background')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('scheduled_commands');
    }
};
