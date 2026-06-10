<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up()
{
    Schema::table('ebis_planning_orders', function (Blueprint $table) {
        $table->string('progres')->nullable()->after('status_order');
        $table->timestamp('tanggal_update_progres')->nullable()->after('progres');
    });
}

public function down()
{
    Schema::table('ebis_planning_orders', function (Blueprint $table) {
        $table->dropColumn(['progres', 'tanggal_update_progres']);
    });
}

};