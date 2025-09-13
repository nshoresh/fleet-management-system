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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number')->unique(); // Unique invoice identifier
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // User who created the invoice
            $table->foreignId('vehicle_owner_id')->constrained('vehicle_owners')->onDelete('cascade'); // Vehicle owner being billed
            $table->decimal('amount', 10, 2); // Total invoice amount
            $table->string('currency');
            $table->date('invoice_date'); // Date the invoice was issued
            $table->date('due_date'); // Payment due date
            $table->enum('status', ['draft', 'sent', 'paid', 'overdue', 'cancelled'])->default('draft'); // Invoice status
            $table->text('notes')->nullable(); // Optional notes about the invoice
            $table->longText('terms_and_conditions')->nullable(); // Optional terms and conditions
            $table->string('payment_method')->nullable(); // Method of payment
            $table->timestamp('paid_at')->nullable(); // When the invoice was paid
            $table->decimal('tax_amount', 8, 2)->default(0.00); // Tax amount
            $table->decimal('discount_amount', 8, 2)->default(0.00); // Discount amount
            $table->timestamps();
            $table->softDeletes(); // Allow for soft deletion of invoices
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
