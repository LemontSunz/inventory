<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('kendaraan', function (Blueprint $table) {
            $table->id();
            $table->string('kode_kendaraan')->unique();
            $table->string('nama_kendaraan');
            $table->string('jenis_kendaraan');
            $table->string('plat_nomor', 50)->unique();
            $table->unsignedInteger('kapasitas_muatan');
            $table->unsignedInteger('kilometer')->default(0);
            $table->unsignedSmallInteger('tahun_pembuatan');
            $table->string('warna', 50);
            $table->enum('status', ['Siap', 'Perawatan', 'Dalam Perjalanan'])->default('Siap');
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('kendaraan');
    }
};
