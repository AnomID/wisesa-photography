<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Menggunakan raw SQL karena renameColumn tidak didukung di semua versi MariaDB
        DB::statement('ALTER TABLE profils CHANGE twitter_perusahaan tiktok_perusahaan VARCHAR(255) NULL');
        DB::statement('ALTER TABLE profils CHANGE linkedin_perusahaan whatsapp_perusahaan VARCHAR(255) NULL');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Rollback: Rename back to original names
        DB::statement('ALTER TABLE profils CHANGE tiktok_perusahaan twitter_perusahaan VARCHAR(255) NULL');
        DB::statement('ALTER TABLE profils CHANGE whatsapp_perusahaan linkedin_perusahaan VARCHAR(255) NULL');
    }
};
