<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('barang_keluar', function (Blueprint $table) {
            if (! Schema::hasColumn('barang_keluar', 'status')) {
                $table->enum('status', ['Dalam Perjalanan', 'Terkirim'])->default('Dalam Perjalanan')->after('keterangan');
            }
        });

        DB::table('barang_keluar')->update(['status' => 'Dalam Perjalanan']);
    }

    public function down(): void
    {
        Schema::table('barang_keluar', function (Blueprint $table) {
            if (Schema::hasColumn('barang_keluar', 'status')) {
                $table->dropColumn('status');
            }
        });
    }
};
