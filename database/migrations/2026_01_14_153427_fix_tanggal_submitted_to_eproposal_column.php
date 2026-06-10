<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ebis_planning_orders', function (Blueprint $table) {

            
            if (Schema::hasColumn('ebis_planning_orders', 'tanggal_submitted_to_eproposal')) {
                $table->dropColumn('tanggal_submitted_to_eproposal');
            }

            
            $table->string('tanggal_submitted_to_eproposal', 100)
                  ->nullable()
                  ->after('tanggal_waiting_caring');
        });
    }

    public function down(): void
    {
        Schema::table('ebis_planning_orders', function (Blueprint $table) {
            $table->date('tanggal_submitted_to_eproposal')->nullable();
        });
    }
};
