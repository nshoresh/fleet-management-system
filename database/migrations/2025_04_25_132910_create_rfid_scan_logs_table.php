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
        Schema::create('rfid_scan_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rfid_tags_id')->constrained('rfid_tags')->onDelete('cascade');
            $table->foreignId('rfid_scanners_id')->constrained('rfid_scanners')->onDelete('cascade');
            $table->timestamp('detected_at');
            $table->decimal('signal_strength', 5, 2)
                ->nullable()
                ->comment('dBm measurement');
            $table->string('direction', 10)
                ->nullable()
                ->comment('Entry/Exit/Checkpoint');
            $table->string('scanner_location')
                ->nullable()->comment('GPS coordinates at scan time');
            $table->json('metadata')->nullable()->comment('Additional scan data');
            $table->index(['rfid_tags_id', 'detected_at']);
            $table->index(['rfid_scanners_id', 'detected_at']);
            $table->index('direction');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rfid_scan_logs');
    }
};
