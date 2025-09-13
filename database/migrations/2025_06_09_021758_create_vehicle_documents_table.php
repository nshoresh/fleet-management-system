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
        Schema::create('vehicle_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vehicle_id')->constrained('vehicles')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('vehicle_owner_id')->constrained('vehicle_owners')->onDelete('cascade')->onUpdate('cascade');
            $table->enum('attchment_category', ['document', 'image'])->default('document');
            $table->string('attachment'); // e.g., 'registration', 'insurance', 'inspection', vehicle image.
            $table->string('file_name'); // Name of the file
            $table->string('image_type')->nullable(); // 'exterior', 'interior'
            $table->string('file_path')->nullable(); // Will store the Google Cloud Storage path.
            $table->string('mime_type')->nullable(); // MIME type of the file
            $table->unsignedBigInteger('file_size')->nullable(); // Size of the file in bytes
            $table->text('notes')->nullable(); // Additional notes about the document
            $table->date('issue_date')->nullable(); // Issue date for documents like insurance
            $table->boolean('is_verified')->default(false); // Whether the document has been verified
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicle_documents');
    }
};
