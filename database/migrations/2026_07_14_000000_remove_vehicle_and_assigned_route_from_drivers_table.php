<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('drivers')) {
            Schema::table('drivers', function (Blueprint $table) {
                if (Schema::hasColumn('drivers', 'vehicle_type')) {
                    $table->dropColumn('vehicle_type');
                }

                if (Schema::hasColumn('drivers', 'assigned_route')) {
                    $table->dropColumn('assigned_route');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasTable('drivers')) {
            Schema::table('drivers', function (Blueprint $table) {
                // Recreate columns with original types from the create_drivers migration
                // vehicle_type: string (non-nullable)
                // assigned_route: string, nullable
                if (! Schema::hasColumn('drivers', 'vehicle_type')) {
                    $table->string('vehicle_type');
                }

                if (! Schema::hasColumn('drivers', 'assigned_route')) {
                    $table->string('assigned_route')->nullable();
                }
            });
        }
    }
};
