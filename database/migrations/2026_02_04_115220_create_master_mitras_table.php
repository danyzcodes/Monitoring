<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up()
{
    Schema::create('master_mitras', function (Blueprint $table) {
        $table->id();
        $table->string('nama_mitra')->unique();
        $table->timestamps();
    });
}

public function down()
{
    Schema::dropIfExists('master_mitras');
}

};
