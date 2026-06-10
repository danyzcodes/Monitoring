<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        
        Schema::table('ebis_manual_inputs', function (Blueprint $table) {
            $table->dropColumn('sto');
        });

        
        Schema::table('ebis_manual_inputs', function (Blueprint $table) {
            $table->enum('sto', [
                'AWN','BON','CBN','CKI','HAR',
                'IMY','JBN','JTB','JWG','KAD',
                'CKC','KRA','KYM','KNG','LGJ',
                'LSR','LOS','MJL','PAB','PTR',
                'PLD','RGA','SDU','SUB','JCG',
                'PMN','PGD','KIA','CAS','PBS'
            ])->nullable()->after('datel');
        });
    }

    public function down(): void
    {
        
        Schema::table('ebis_manual_inputs', function (Blueprint $table) {
            $table->dropColumn('sto');
        });

        Schema::table('ebis_manual_inputs', function (Blueprint $table) {
            $table->enum('sto', [
                'ARJAWINANGUN','BALONGAN','CIREBON','CIKIJING','HAURGEULIS',
                'INDRAMAYU','JAMBLANG','JATIBARANG','JATIWANGI','KADIPATEN',
                'KANCI','KARANGAMPEL','KARYAMULIA','KUNINGAN','CILIMUS',
                'LOSARANG','LOSARI','MAJALENGKA','PABUARAN','PATROL',
                'PLERED','RAJAGALUH','SINDANGLAUT','SUBANG','JALANCAGAK',
                'PAMANUKAN','PAGADEN','KALIJATI','CIASEM'
            ])->nullable()->after('datel');
        });
    }
};
