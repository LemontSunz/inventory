<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('drivers', function (Blueprint $table) {
            $table->foreignId('kendaraan_id')->nullable()->after('vehicle_type')->constrained('kendaraan')->nullOnDelete();
            $table->foreignId('cabang_id')->nullable()->after('assigned_route')->constrained('cabang')->nullOnDelete();
        });

        // Optional migration helper: preserve existing matching text values when possible.
        DB::statement(
            'UPDATE drivers d
                LEFT JOIN kendaraan k ON d.vehicle_type = k.kode_kendaraan OR d.vehicle_type = k.nama_kendaraan
                SET d.kendaraan_id = k.id
                WHERE d.kendaraan_id IS NULL AND d.vehicle_type IS NOT NULL'
        );

        DB::statement(
            'UPDATE drivers d
                LEFT JOIN cabang c ON d.assigned_route = c.nama_cabang
                SET d.cabang_id = c.id
                WHERE d.cabang_id IS NULL AND d.assigned_route IS NOT NULL'
        );
    }

    public function down(): void
    {
        Schema::table('drivers', function (Blueprint $table) {
            $table->dropForeign(['kendaraan_id']);
            $table->dropForeign(['cabang_id']);
            $table->dropColumn(['kendaraan_id', 'cabang_id']);
        });
    }
};
