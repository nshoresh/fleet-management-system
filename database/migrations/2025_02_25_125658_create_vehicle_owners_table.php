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
        Schema::create('vehicle_owners', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique();
            $table->string('name'); // Owner's full name
            $table->string('contact_number')->nullable(); // Phone number
            $table->string('email')->unique()->nullable(); // Email (optional)
            $table->longText('address')->nullable(); // Physical address
            $table->foreignId('vehicle_owner_type_id')->constrained('vehicle_owner_types'); // Type of owner (Company, Individual, etc.)
            $table->string('business_name')->nullable(); // Name of the business (if applicable)
            $table->string('business_phone')->nullable(); // Business phone number
            $table->string('business_email')->nullable(); // Business email address
            $table->text('business_address')->nullable(); // Business address
            $table->string('business_registration_number')->nullable(); // Business registration number
            $table->string('business_type')->nullable(); // Type of business (e.g., LLC, Corporation, etc.)
            $table->string('business_tax_id')->nullable(); // Business Tax ID (if applicable)
            $table->string('business_website')->nullable(); // Business website URL
            $table->string('business_logo')->nullable(); // Business logo (if applicable)
            $table->string('business_contact_person')->nullable(); // Contact person in the business
            $table->string('business_contact_number')->nullable(); // Contact number for the business
            $table->string('id_number')->nullable(); // National ID or Business ID
            $table->string('id_type')->nullable(); // Type of ID (National ID, Business ID, etc.)
            $table->string('position')->nullable(); // Position in the company (if applicable)
            $table->date('business_registration_date')->nullable(); // Date of business registration
            $table->boolean('is_information_verified')->default(false); // Verification status
            $table->boolean('is_documents_verified')->default(false);
            $table->enum('status', ['active', 'inactive', 'pending', 'approved', 'declined'])->default('active'); // Owner status
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicle_owners');
    }
};
