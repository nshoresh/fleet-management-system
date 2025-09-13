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
        Schema::create('licenses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vehicle_owners_id')->nullable()->constrained('vehicle_owners')->nullOnDelete();
            //$table->foreignId('vehicle_id')->nullable()->constrained('vehicles')->nullOnDelete(); // Add relationship to vehicles table
            $table->foreignId('vehicle_id')->unique()->constrained()->cascadeOnDelete();
            $table->string('registration_number');
            $table->foreignId('license_application_id')->constrained('license_applications')->onDelete('cascade');
            $table->foreignId('license_type_id')->nullable()->constrained('license_types')->nullOnDelete();
            $table->foreignId('license_purpose_id')->nullable()->constrained('license_purposes')->nullOnDelete();
            $table->foreignId('route_id')->nullable()->constrained('routes')->nullOnDelete();
            $table->date('license_start_date');
            $table->date('license_end_date');
            $table->enum('license_status', ['Active', 'Expired'])->default('Active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('licenses');
    }
};
