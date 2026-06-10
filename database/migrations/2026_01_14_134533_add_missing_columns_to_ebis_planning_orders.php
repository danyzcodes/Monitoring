<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('ebis_planning_orders', function (Blueprint $table) {

            
            if (!Schema::hasColumn('ebis_planning_orders', 'id_odp_alokasi')) {
                $table->string('id_odp_alokasi')->nullable()
                      ->after('status_alokasi_alpro');
            }

            if (!Schema::hasColumn('ebis_planning_orders', 'status_tomps_last_update')) {
                $table->string('status_tomps_last_update')->nullable()
                      ->after('status_tomps');
            }

            if (!Schema::hasColumn('ebis_planning_orders', 'tanggal_submitted_to_eproposal')) {
                $table->date('tanggal_submitted_to_eproposal')->nullable()
                      ->after('tanggal_waiting_caring');
            }

            
            if (!Schema::hasColumn('ebis_planning_orders', 'deleted_at')) {
                $table->softDeletes();
            }
        });
    }

    public function down(): void
    {
        Schema::table('ebis_planning_orders', function (Blueprint $table) {

            if (Schema::hasColumn('ebis_planning_orders', 'id_odp_alokasi')) {
                $table->dropColumn('id_odp_alokasi');
            }

            if (Schema::hasColumn('ebis_planning_orders', 'status_tomps_last_update')) {
                $table->dropColumn('status_tomps_last_update');
            }

            if (Schema::hasColumn('ebis_planning_orders', 'tanggal_submitted_to_eproposal')) {
                $table->dropColumn('tanggal_submitted_to_eproposal');
            }

            if (Schema::hasColumn('ebis_planning_orders', 'deleted_at')) {
                $table->dropSoftDeletes();
            }
        });
    }
};
