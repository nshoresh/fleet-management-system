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
        Schema::create('license_applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // User who applied for the license
            $table->foreignId('license_type_id')->constrained('license_types')->onDelete('restrict'); // Type of license being applied for
            $table->string('application_number')->unique(); // Unique identifier for the application
            $table->enum(
                'status',
                [
                    'Pending',
                    'Under Review',
                    'Approved',
                    'Rejected',
                    'Expired']
            )->default('Pending'); // Application status
            $table->date('submission_date'); // When the application was submitted
            $table->date('expiry_date')->nullable(); // When the license will expire if approved
            $table->text('purpose')->nullable(); // Purpose of the license application
            $table->text('rejection_reason')->nullable(); // Reason for rejection if applicable
            $table->foreignId('reviewed_by')->nullable()->constrained('users')->onDelete('set null'); // Admin who reviewed the application
            $table->timestamp('reviewed_at')->nullable(); // When the application was reviewed
            $table->boolean('terms_accepted')->default(false); // Whether the applicant accepted terms and conditions
            $table->json('supporting_documents')->nullable(); // JSON array of supporting document paths/references
            $table->json('additional_information')->nullable(); // Any additional information provided by the applicant
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('license_applications');
    }
};
