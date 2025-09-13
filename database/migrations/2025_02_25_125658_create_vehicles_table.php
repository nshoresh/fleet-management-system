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
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            // UUID stringring for the vehicle
            $table->string('uuid')->unique();
            $table->string('year'); // Vehicle manufacturing year
            $table->string('vin')->unique(); // Vehicle Identification Number (unique)
            $table->string('color')->nullable(); // Vehicle color
            $table->string('license_plate'); // License plate number (unique)
            $table->string('engine_number')->nullable();
            $table->string('chassis_number')->nullable();
            $table->string('vehicle_type')->nullable();
            $table->string('engine_type')->nullable(); // Engine type (e.g., V8, Electric)
            $table->integer('mileage')->nullable(); // Vehicle mileage in kilometers or miles
            $table->date('registration_date')->nullable(); // Date when the vehicle was registered
            $table->enum('status', ['active', 'inactive', 'sold'])->default('active'); // Vehicle status
            $table->foreignId('vehicle_make_id')->constrained('vehicle_makes')->onDelete('cascade'); // Foreign key to vehicle_makes
            $table->foreignId('vehicle_model_id')->constrained('vehicle_make_models')->onDelete('cascade'); // Foreign key to vehicle_make_models
            $table->foreignId('vehicle_owner_id')->constrained('vehicle_owners')->onDelete('cascade'); // Foreign key to vehicle_owners
            $table->foreignId('vehicle_type_id')->constrained('vehicle_types')->onDelete('cascade'); // Foreign key to vehicle_types
            $table->string('transmission_type')->nullable(); // Transmission type (e.g., Automatic, Manual)
            $table->string('fuel_type')->nullable(); // Fuel type (e.g., Gasoline, Diesel)
            $table->integer('seating_capacity')->nullable(); // Number of seats in the vehicle
            $table->string('vehicle_condition')->nullable(); // Condition of the vehicle (e.g., New, Used)
            $table->string('additional_features')->nullable(); // Additional features (e.g., GPS, Leather seats)
            $table->string('insurance_status')->nullable(); // Insurance status (e.g., Insured, Not Insured)
            $table->date('last_service_date')->nullable(); // Date of the last service
            // Additional fields for heavy vehicles
            $table->float('gross_vehicle_weight')->nullable(); // Gross Vehicle Weight (GVW)
            $table->float('gross_trailer_weight')->nullable(); // Gross Trailer Weight (GTW)
            $table->float('payload_capacity')->nullable(); // Payload capacity of the vehicle
            $table->float('tire_capacity')->nullable(); // Tire capacity (e.g., load rating)
            $table->string('axle_configuration')->nullable(); // Axle configuration (e.g., single, tandem, triple)
            $table->integer('number_of_axles')->nullable(); // Number of axles
            $table->float('engine_power')->nullable(); // Engine power in horsepower or kilowatts
            $table->float('torque')->nullable();
            $table->timestamps();
            $table->softDeletes(); // Soft delete column
            $table->string('created_by')->nullable(); // User who created the record

            // Composite unique keys
            $table->unique(['vin', 'vehicle_make_id', 'vehicle_model_id', 'license_plate'], 'unique_vehicle_vin_make_model');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};
