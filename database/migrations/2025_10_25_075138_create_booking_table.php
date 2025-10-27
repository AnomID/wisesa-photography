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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('nama');
            $table->string('telephone');
            $table->string('area');
            $table->string('instagram')->nullable();
            $table->text('address');
            $table->foreignId('layanan_id')->constrained('layanans')->onDelete('cascade');
            $table->foreignId('sub_layanan_id')->nullable()->constrained('sub_layanans')->onDelete('set null');
            $table->date('booking_date');
            $table->time('booking_time');
            $table->string('universitas');
            $table->string('lokasi_photo');
            $table->string('fotografer')->nullable();
            $table->string('biaya')->nullable();
            $table->enum('status', ['Pending', 'Ditolak', 'Diterima', 'Diproses', 'Selesai'])->default('Pending');
            $table->text('catatan')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
