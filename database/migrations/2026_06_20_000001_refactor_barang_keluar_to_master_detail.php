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
            if (! Schema::hasColumn('barang_keluar', 'nomor_pengiriman')) {
                $table->string('nomor_pengiriman')->nullable()->after('id')->unique();
            }
        });

        Schema::create('barang_keluar_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('barang_keluar_id')->constrained('barang_keluar')->cascadeOnDelete();
            $table->foreignId('barang_id')->constrained('barang')->cascadeOnDelete();
            $table->integer('jumlah_keluar');
            $table->timestamps();

            $table->index(['barang_keluar_id', 'barang_id']);
        });

        $rows = DB::table('barang_keluar')->get();
        foreach ($rows as $row) {
            DB::table('barang_keluar_details')->insert([
                'barang_keluar_id' => $row->id,
                'barang_id' => $row->barang_id,
                'jumlah_keluar' => $row->jumlah_keluar,
                'created_at' => $row->created_at,
                'updated_at' => $row->updated_at,
            ]);
        }

        DB::statement("UPDATE barang_keluar SET nomor_pengiriman = CONCAT('BK-', LPAD(id, 6, '0')) WHERE nomor_pengiriman IS NULL");
    }

    public function down(): void
    {
        Schema::dropIfExists('barang_keluar_details');

        Schema::table('barang_keluar', function (Blueprint $table) {
            if (Schema::hasColumn('barang_keluar', 'nomor_pengiriman')) {
                $table->dropUnique(['nomor_pengiriman']);
                $table->dropColumn('nomor_pengiriman');
            }
        });
    }
};
