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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('payment_number')->unique(); // Unique payment identifier
            $table->foreignId('invoice_id')->constrained('invoices')->onDelete('cascade'); // Related invoice
            $table->foreignId('vehicle_owner_id')->constrained('vehicle_owners')->onDelete('cascade'); // Who made the payment
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // User who recorded the payment
            $table->decimal('amount', 10, 2); // Payment amount
            $table->string('currency'); // Currency of payment (matching invoice currency)
            $table->enum('payment_method', ['cash', 'check', 'bank_transfer', 'credit_card', 'debit_card', 'mobile_money', 'paypal', 'other']); // Expanded payment methods
            $table->string('transaction_reference')->nullable(); // Reference number from payment processor or check number
            $table->date('payment_date'); // Date the payment was made
            $table->text('notes')->nullable(); // Any additional information
            $table->string('receipt_number')->nullable()->unique(); // Optional receipt number
            // Payment verification
            $table->boolean('is_verified')->default(false); // Whether payment has been verified
            $table->foreignId('verified_by')->nullable()->constrained('users'); // Who verified the payment
            $table->timestamp('verified_at')->nullable(); // When payment was verified
            // Additional payment details
            $table->string('payer_name')->nullable(); // Name of person who made payment if different from vehicle owner
            $table->string('payer_contact')->nullable(); // Contact information of payer
            $table->json('payment_meta')->nullable(); // Store additional payment gateway metadata
            $table->string('bank_name')->nullable(); // For bank transfers or checks
            $table->string('check_number')->nullable(); // For check payments
            $table->string('card_last_four')->nullable(); // Last four digits of card (PCI compliant)
            $table->string('card_type')->nullable(); // Visa, Mastercard, etc.

            // Payment reconciliation
            $table->boolean('is_reconciled')->default(false); // Whether payment has been reconciled
            $table->foreignId('reconciled_by')->nullable()->constrained('users'); // Who reconciled the payment
            $table->timestamp('reconciled_at')->nullable(); // When payment was reconciled

            // Partial payment tracking
            $table->boolean('is_partial_payment')->default(false); // Whether this is a partial payment
            $table->decimal('remaining_balance', 10, 2)->nullable(); // Remaining balance after this payment

            // Refund tracking
            $table->boolean('is_refunded')->default(false); // Whether payment was refunded
            $table->decimal('refunded_amount', 10, 2)->nullable(); // How much was refunded
            $table->timestamp('refunded_at')->nullable(); // When the refund was processed
            $table->foreignId('refunded_by')->nullable()->constrained('users'); // Who processed the refund
            $table->string('refund_reference')->nullable(); // Reference for the refund transaction
            $table->text('refund_reason')->nullable(); // Why the refund was issued

            $table->timestamps();
            $table->softDeletes(); // Allow for soft deletion of payments
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
