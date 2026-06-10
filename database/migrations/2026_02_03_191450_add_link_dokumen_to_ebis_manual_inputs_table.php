<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up()
    {
        Schema::table('ebis_manual_inputs', function (Blueprint $table) {
            $table->text('link_dokumen')->nullable()->after('nama_mitra');
        });
    }

    public function down()
    {
        Schema::table('ebis_manual_inputs', function (Blueprint $table) {
            $table->dropColumn('link_dokumen');
        });
    }
};
