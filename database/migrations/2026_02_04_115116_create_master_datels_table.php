<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up()
{
    Schema::create('master_datels', function (Blueprint $table) {
        $table->id();
        $table->string('nama_datel')->unique();
        $table->timestamps();
    });
}

public function down()
{
    Schema::dropIfExists('master_datels');
}

};
