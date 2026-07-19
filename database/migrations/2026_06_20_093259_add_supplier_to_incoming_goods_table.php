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
        Schema::table('incoming_goods', function (Blueprint $table) {
            // Tambahkan kolom supplier untuk input nama supplier (tanpa ketergantungan tabel suppliers)
            $table->string('supplier')->nullable()->after('supplier_id');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('incoming_goods', function (Blueprint $table) {
            $table->dropColumn('supplier');
        });
    }

};
