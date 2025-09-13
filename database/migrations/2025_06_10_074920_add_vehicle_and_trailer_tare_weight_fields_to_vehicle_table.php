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
        Schema::table('vehicles', function (Blueprint $table) {
            $table->float('vehicle_tare_weight')->nullable()->after('gross_vehicle_weight'); // Tare weight of the vehicle
            $table->float('trailer_tare_weight')->nullable()->after('gross_trailer_weight'); // Tare weight of the trailer 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vehicles', function (Blueprint $table) {
            $table->dropColumn(['vehicle_tare_weight', 'trailer_tare_weight']);
        });
    }
};
