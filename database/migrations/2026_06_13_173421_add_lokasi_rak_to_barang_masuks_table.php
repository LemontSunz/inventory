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
        Schema::table('barang_masuks', function (Blueprint $table) {
            if (!Schema::hasColumn('barang_masuks', 'lokasi_rak')) {
                $table->string('lokasi_rak')->nullable()->after('supplier');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('barang_masuks', function (Blueprint $table) {
            if (Schema::hasColumn('barang_masuks', 'lokasi_rak')) {
                $table->dropColumn('lokasi_rak');
            }
        });
    }
};
