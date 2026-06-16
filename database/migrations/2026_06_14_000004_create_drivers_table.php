<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('drivers', function (Blueprint $table) {
            $table->id();
            $table->string('driver_code')->unique();
            $table->string('name');
            $table->string('phone', 50);
            $table->string('vehicle_type');
            $table->string('license_class');
            $table->date('license_expiry_date');
            $table->string('assigned_route')->nullable();
            $table->enum('status', ['Tersedia', 'Sedang Bertugas', 'Tidak Aktif'])->default('Tersedia');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('drivers');
    }
};
