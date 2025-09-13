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
        Schema::create('charges', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vehicle_owner_id')->constrained('vehicle_owners')->onDelete('cascade');
            $table->decimal('amount', 10, 2); // Charge amount with 2 decimal places
            $table->string('description'); // Description of the charge
            $table->string('reference_number')->nullable(); // Optional reference number
            $table->enum('status', [
                'pending',
                'Invoiced',
                'cancelled'
            ])->default('pending');
            $table->date('due_date')->nullable(); // When the charge is due
            $table->date('payment_date')->nullable(); // When the charge was paid
            $table->string('payment_method')->nullable(); // How the charge was paid
            $table->foreignId('created_by')->nullable()->constrained('users'); // User who created the charge
            $table->foreignId('updated_by')->nullable()->constrained('users'); // User who last updated the charge
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('charges');
    }
};
