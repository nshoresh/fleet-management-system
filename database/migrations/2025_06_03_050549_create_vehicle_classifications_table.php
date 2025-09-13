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
        Schema::create('vehicle_classifications', function (Blueprint $table) {
            $table->id();
            $table->string('classification_name'); // Name for the vehicle classification
            $table->float('min_weight', 8, 2)->nullable(); // Minimum weight in kg
            $table->float('max_weight', 8, 2)->nullable(); // Maximum weight in kg
            $table->decimal('rdc_fee', 8, 2)->default(0.00); // Road use fee in pgk
            $table->text('description')->nullable(); // Description of the vehicle classification
            $table->boolean('is_active')->default(true); // Whether the classification is active or not
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicle_classifications');
    }
};
