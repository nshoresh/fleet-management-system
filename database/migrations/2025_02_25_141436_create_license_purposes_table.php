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
        Schema::create('license_purposes', function (Blueprint $table) {
            $table->id();
            $table->string('purpose_name');
            $table->string('purpose_description')->nullable(); // Description of the license purpose
            $table->enum('purpose_category', ['Transportation', 'Construction', 'Agriculture', 'Special'])->nullable(); // Category of the license purpose
            $table->boolean('is_active')->default(true); // Whether the license purpose is active or not
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('license_purposes');
    }
};
