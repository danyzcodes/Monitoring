<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ebis_planning_orders', function (Blueprint $table) {

            
            if (Schema::hasColumn('ebis_planning_orders', 'odp_go_live')) {
                $table->dropColumn('odp_go_live');
            }

            
            $table->string('odp_go_live', 100)
                  ->nullable()
                  ->after('status_proyek');
        });
    }

    public function down(): void
    {
        Schema::table('ebis_planning_orders', function (Blueprint $table) {

            $table->date('odp_go_live')->nullable();
        });
    }
};

