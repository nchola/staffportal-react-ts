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
        Schema::create('mutasis', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('alasan');
            $table->string('keterangan')->nullable();
            $table->string('status_verifikasi')->nullable(); // Menunggu, Disetujui, Ditolak
            $table->string('status_ketetapan')->nullable(); // Tetap, Sementara, Uji Coba
            $table->date('tanggal_efektif');
            $table->date('tanggal_verifikasi')->nullable();
            $table->string('dokumen')->nullable();
            $table->enum('jenis', ['promosi', 'demosi'])->default('promosi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mutasis');
    }
};
