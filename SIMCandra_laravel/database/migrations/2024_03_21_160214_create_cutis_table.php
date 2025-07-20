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
        Schema::create('cutis', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('alasan');
            $table->enum('jenis_cuti', ['Cuti Tahunan', 'Cuti Sakit', 'Izin', 'Cuti Melahirkan', 'Cuti Khusus']);
            $table->string('keterangan')->nullable();
            $table->string('status')->nullable();
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->date('tanggal_verifikasi')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cutis');
    }
};
