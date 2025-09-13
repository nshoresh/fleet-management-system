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
        Schema::create('rfid_scanners', function (Blueprint $table) {
            $table->id();
            $table->string('serial_number')->unique();
            $table->string('model');
            $table->string('manufacturer');
            $table->string('location')->nullable();
            $table->string('ip_address')->nullable();
            $table->string('mac_address')->nullable();
            $table->string('firmware_version')->nullable();
            $table->boolean('is_active')->default(true);
            $table->json('settings')->nullable();
            $table->timestamp('last_online_at')->nullable();
            $table->timestamp('last_maintenance_at')->nullable();
            $table->text('notes')->nullable();
            // $table->unsignedBigInteger('location_id')->nullable();
            // $table->foreign('location_id')->references('id')->on('locations')->onDelete('set null');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rfid_scanners');
    }
};
