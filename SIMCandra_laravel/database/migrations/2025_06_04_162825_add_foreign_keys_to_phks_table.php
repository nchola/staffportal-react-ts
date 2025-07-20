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
        Schema::table('phks', function (Blueprint $table) {
            // Add foreign key for pegawai_id referencing the pegawais table
            $table->foreignId('pegawai_id')->nullable()->constrained('pegawais')->onDelete('set null');

            // Add foreign key for verifikasi_oleh referencing the users table (assuming standard Laravel users table)
            $table->foreign('verifikasi_oleh')->references('id')->on('users')->onDelete('set null');        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('phks', function (Blueprint $table) {
            // Drop foreign keys and columns in the reverse order of addition
            $table->dropForeign(['verifikasi_oleh']);
            $table->dropColumn('verifikasi_oleh');
            $table->dropForeign(['pegawai_id']);
            $table->dropColumn('pegawai_id');
        });
    }
};
