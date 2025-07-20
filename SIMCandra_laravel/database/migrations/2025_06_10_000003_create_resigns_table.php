<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('resigns', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pegawai_id');
            $table->date('tanggal_pengajuan');
            $table->date('tanggal_resign');
            $table->text('alasan');
            $table->string('status')->default('Menunggu');
            $table->text('keterangan_verifikasi')->nullable();
            $table->date('tanggal_verifikasi')->nullable();
            $table->unsignedBigInteger('verifikasi_oleh')->nullable();
            $table->string('surat_resign')->nullable();
            $table->timestamps();
            $table->foreign('pegawai_id')->references('id')->on('pegawais')->onDelete('cascade');
        });
    }
    public function down()
    {
        Schema::dropIfExists('resigns');
    }
}; 