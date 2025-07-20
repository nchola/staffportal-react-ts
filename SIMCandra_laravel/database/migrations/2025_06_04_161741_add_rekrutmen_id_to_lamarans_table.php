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
        Schema::table('lamarans', function (Blueprint $table) {
            // Add foreign key for rekrutmen_id referencing the rekrutmens table
            $table->foreignId('rekrutmen_id')->nullable()->constrained('rekrutmens')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lamarans', function (Blueprint $table) {
            // Drop foreign key and column
            $table->dropForeign(['rekrutmen_id']);
            $table->dropColumn('rekrutmen_id');
        });
    }
};
