<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ebis_planning_orders', function (Blueprint $table) {

            
            $table->string('username_nik_melakukan_alokasi_alpro', 100)
                  ->nullable()
                  ->after('username_nik_pembuat');

            
            if (Schema::hasColumn('ebis_planning_orders', 'username_nik_alokasi_alpro')) {
                $table->dropColumn('username_nik_alokasi_alpro');
            }
        });
    }

    public function down(): void
    {
        Schema::table('ebis_planning_orders', function (Blueprint $table) {

            
            $table->string('username_nik_alokasi_alpro', 100)
                  ->nullable();

            
            $table->dropColumn('username_nik_melakukan_alokasi_alpro');
        });
    }
};
