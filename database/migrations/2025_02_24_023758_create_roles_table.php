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
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->enum('role_group', ['System', 'Client']);          // Role name (e.g., 'admin', 'user', 'editor')
            $table->string('slug')->unique();          // URL-friendly version of name
            $table->string('description')->nullable(); // Optional role description
            $table->boolean('is_active')->default(true); // Role status
            $table->timestamps();
            $table->softDeletes();                    // Adds deleted_at column for soft deletes
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('roles');
    }
};
