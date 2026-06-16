<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('incoming_goods_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('incoming_goods_id')->constrained('incoming_goods')->cascadeOnDelete();
            $table->foreignId('item_id')->constrained('barang')->cascadeOnDelete();
            $table->integer('quantity_received');
            $table->foreignId('rack_location_id')->constrained('rack_locations')->cascadeOnDelete();
            $table->timestamps();

            $table->index(['incoming_goods_id', 'item_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('incoming_goods_details');
    }
};
