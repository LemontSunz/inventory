<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('incoming_goods', function (Blueprint $table) {
            $table->dropForeign(['supplier_id']);
        });

        DB::statement('ALTER TABLE incoming_goods MODIFY supplier_id BIGINT UNSIGNED NULL');

        Schema::table('incoming_goods', function (Blueprint $table) {
            $table->foreign('supplier_id')->references('id')->on('suppliers')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('incoming_goods', function (Blueprint $table) {
            $table->dropForeign(['supplier_id']);
        });

        DB::statement('ALTER TABLE incoming_goods MODIFY supplier_id BIGINT UNSIGNED NOT NULL');

        Schema::table('incoming_goods', function (Blueprint $table) {
            $table->foreign('supplier_id')->references('id')->on('suppliers')->cascadeOnDelete();
        });
    }
};
