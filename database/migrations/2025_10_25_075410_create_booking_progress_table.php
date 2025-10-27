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
        Schema::create('booking_progress', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->unique()->constrained('bookings')->onDelete('cascade');

            $table->boolean('jadwal_foto')->default(false);
            $table->timestamp('jadwal_foto_at')->nullable();

            $table->boolean('file_jpg_upload')->default(false);
            $table->text('file_jpg_link')->nullable();
            $table->timestamp('file_jpg_upload_at')->nullable();

            $table->boolean('selected_photos')->default(false);
            $table->text('selected_photos_link')->nullable();
            $table->timestamp('selected_photos_at')->nullable();

            $table->boolean('file_raw_upload')->default(false);
            $table->timestamp('file_raw_upload_at')->nullable();

            $table->boolean('editing_foto')->default(false);
            $table->timestamp('editing_foto_at')->nullable();

            $table->boolean('foto_edited_upload')->default(false);
            $table->timestamp('foto_edited_upload_at')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('booking_progress');
    }
};
