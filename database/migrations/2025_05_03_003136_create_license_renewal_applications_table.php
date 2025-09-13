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
        Schema::create('license_renewal_applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('license_id')->constrained('licenses')->onDelete('cascade');
            $table->string('application_number')->unique();
            $table->foreignId('vehicle_owners_id')->nullable()->constrained('vehicle_owners')->nullOnDelete();
            $table->foreignId('vehicle_id')->nullable()->constrained('vehicles')->nullOnDelete();
            $table->foreignId('license_type_id')->nullable()->constrained('license_types')->nullOnDelete();
            $table->foreignId('license_purpose_id')->nullable()->constrained('license_purposes')->nullOnDelete();
            $table->foreignId('route_id')->nullable()->constrained('routes')->nullOnDelete();
            $table->date('requested_start_date');
            $table->date('requested_end_date');
            $table->enum('status', ['Pending', 
            'Approved', 
            'Rejected'])->default('Pending');
            $table->text('rejection_reason')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('license_renewal_applications');
    }
};