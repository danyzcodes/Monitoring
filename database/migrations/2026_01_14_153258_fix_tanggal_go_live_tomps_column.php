<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ebis_planning_orders', function (Blueprint $table) {

            
            if (Schema::hasColumn('ebis_planning_orders', 'tanggal_go_live_tomps')) {
                $table->dropColumn('tanggal_go_live_tomps');
            }

            
            $table->string('tanggal_go_live_tomps', 100)
                  ->nullable()
                  ->after('tanggal_validasi_abd_tomps');
        });
    }

    public function down(): void
    {
        Schema::table('ebis_planning_orders', function (Blueprint $table) {
            $table->date('tanggal_go_live_tomps')->nullable();
        });
    }
};
