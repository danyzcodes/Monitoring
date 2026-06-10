<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('ebis_manual_inputs', function (Blueprint $table) {
            $table->string('nama_mitra')
                  ->after('nama_customer'); 
        });
    }

    public function down(): void
    {
        Schema::table('ebis_manual_inputs', function (Blueprint $table) {
            $table->dropColumn('nama_mitra');
        });
    }
};
