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
        Schema::create('rfid_tags', function (Blueprint $table) {
            $table->id();
            $table->string('tag_uid')->unique()->comment('Unique identifier of the RFID tag');
            $table->string('tag_type')->comment('Type of RFID tag (e.g., passive, active, semi-passive)');
            $table->string('frequency_range')->nullable()->comment('Frequency range the tag operates in');
            $table->boolean('is_active')->default(true);
            $table->string('status')->default('available')->comment('Status: available, assigned, lost, damaged');

            // Association fields
            $table->unsignedBigInteger('vehicle_id')->nullable();
            $table->foreign('vehicle_id')->references('id')->on('vehicles')->onDelete('set null');

            $table->unsignedBigInteger('license_id')->nullable();
            $table->foreign('license_id')->references('id')->on('licenses')->onDelete('set null');

            $table->unsignedBigInteger('assigned_to_user_id')->nullable();
            $table->foreign('assigned_to_user_id')->references('id')->on('users')->onDelete('set null');

            // Tag information
            $table->date('issue_date')->nullable();
            $table->date('expiry_date')->nullable();
            $table->text('notes')->nullable();

            // Last scan information
            $table->unsignedBigInteger('last_scanner_id')->nullable();
            $table->foreign('last_scanner_id')->references('id')->on('rfid_scanners')->onDelete('set null');
            $table->timestamp('last_scanned_at')->nullable();
            $table->json('metadata')->nullable()->comment('Additional configurable metadata');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rfid_tags');
    }
};
