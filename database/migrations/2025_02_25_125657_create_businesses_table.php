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
        Schema::create('businesses', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('name');
            $table->string('type');
            $table->string('phone');
            $table->string('email')->unique();
            $table->text('address');
            $table->string('registration_number')->unique();
            $table->date('registration_date');
            $table->enum('status', ['pending', 'approved', 'rejected', 'suspended'])->default('pending');
            $table->enum('verification_status', ['unverified', 'verified', 'rejected'])->default('unverified');
            $table->timestamps();

            // Indexes for better performance
            $table->index('uuid');
            $table->index('status');
            $table->index('verification_status');
            $table->index('email');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('businesses');
    }
};
