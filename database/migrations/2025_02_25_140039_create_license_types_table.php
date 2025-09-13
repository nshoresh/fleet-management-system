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
        Schema::create('license_types', function (Blueprint $table) {
            $table->id();
            $table->string('type_name');
            $table->string('type_description')->nullable(); // Description of the license type
            $table->enum('type_category', ['Commercial', 'Personal', 'Special'])->nullable(); // Category of the license type
            $table->boolean('is_active')->default(true); // Whether the license type is active or not
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('license_types');
    }
};
