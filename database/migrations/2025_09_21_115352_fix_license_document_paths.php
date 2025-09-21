<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Fix old paths that include 'storage/license_documents/'
        DB::table('license_documents')
            ->where('file_path', 'like', 'storage/license_documents/%')
            ->update([
                'file_path' => DB::raw("REPLACE(file_path, 'storage/license_documents/', 'license_documents/')")
            ]);
    }

    public function down(): void
    {
        // Optional rollback: put 'storage/' back
        DB::table('license_documents')
            ->where('file_path', 'like', 'license_documents/%')
            ->update([
                'file_path' => DB::raw("CONCAT('storage/', file_path)")
            ]);
    }
};

