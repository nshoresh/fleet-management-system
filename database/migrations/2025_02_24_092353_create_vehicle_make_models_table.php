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
        Schema::create('vehicle_make_models', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vehicle_make_id')->constrained('vehicle_makes')->onDelete('cascade'); // Relationship with vehicle makes
            $table->string('name')->unique(); // Model name (e.g., Corolla, Mustang, Civic)
            $table->year('year')->nullable(); // Year of manufacture (optional)
            $table->string('body_type')->nullable(); // Body type (e.g., Sedan, SUV, Truck)
            $table->text('description')->nullable(); // Optional model description
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicle_make_models');
    }
};
