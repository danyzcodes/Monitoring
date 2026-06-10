<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
   public function up()
{
    Schema::table('ebis_planning_orders', function (Blueprint $table) {
        $table->renameColumn(
            'nama_pengguna_alokasi_alpro',
            'nama_pengguna_melakukan_alokasi_alpro'
        );
    });
}

public function down()
{
    Schema::table('ebis_planning_orders', function (Blueprint $table) {
        $table->renameColumn(
            'nama_pengguna_melakukan_alokasi_alpro',
            'nama_pengguna_alokasi_alpro'
        );
    });
}

};
