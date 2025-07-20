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
        Schema::table('promosis', function (Blueprint $table) {
            // Add foreign keys
            $table->foreignId('jabatan_baru_id')->nullable()->constrained('jabatans')->onDelete('set null');
            $table->foreignId('jabatan_lama_id')->nullable()->constrained('jabatans')->onDelete('set null');
            $table->foreignId('pegawai_id')->nullable()->constrained('pegawais')->onDelete('set null');
            // Assuming verifikasi_oleh references the users table
            $table->foreignId('verifikasi_oleh')->nullable()->constrained('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('promosis', function (Blueprint $table) {
            // Drop foreign keys and columns in the reverse order of addition
            $table->dropForeign(['verifikasi_oleh']);
            $table->dropColumn('verifikasi_oleh');
            $table->dropForeign(['pegawai_id']);
            $table->dropColumn('pegawai_id');
            $table->dropForeign(['jabatan_lama_id']);
            $table->dropColumn('jabatan_lama_id');
            $table->dropForeign(['jabatan_baru_id']);
            $table->dropColumn('jabatan_baru_id');
        });
    }
};
