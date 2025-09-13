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
        Schema::create('license_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('license_application_id')
              ->constrained()
              ->cascadeOnDelete();
            $table->string('file_path');
            $table->foreignId('uploaded_by')
              ->constrained('users')
              ->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('license_documents');
    }
};
