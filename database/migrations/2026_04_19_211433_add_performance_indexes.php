<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        
        Schema::table('ebis_manual_inputs', function (Blueprint $table) {
            $table->index('star_click_id', 'idx_manual_starclick');
            $table->index('nama_mitra', 'idx_manual_mitra');
            $table->index('created_at', 'idx_manual_created');
            $table->index('datel', 'idx_manual_datel');
            $table->index('sto', 'idx_manual_sto');
            $table->index('progres', 'idx_manual_progres');
        });

        
        Schema::table('ebis_planning_orders', function (Blueprint $table) {
            $table->index('star_click_id', 'idx_planning_starclick');
            $table->index('status_order', 'idx_planning_status');
        });

        
        Schema::table('ebis_planning_progress_logs', function (Blueprint $table) {
            $table->index('progres', 'idx_progress_progres');
            $table->index('created_at', 'idx_progress_created');
        });
    }

    
    public function down(): void
    {
        Schema::table('ebis_manual_inputs', function (Blueprint $table) {
            $table->dropIndex('idx_manual_starclick');
            $table->dropIndex('idx_manual_mitra');
            $table->dropIndex('idx_manual_created');
            $table->dropIndex('idx_manual_datel');
            $table->dropIndex('idx_manual_sto');
            $table->dropIndex('idx_manual_progres');
        });

        Schema::table('ebis_planning_orders', function (Blueprint $table) {
            $table->dropIndex('idx_planning_starclick');
            $table->dropIndex('idx_planning_status');
        });

        Schema::table('ebis_planning_progress_logs', function (Blueprint $table) {
            $table->dropIndex('idx_progress_progres');
            $table->dropIndex('idx_progress_created');
        });
    }
};
