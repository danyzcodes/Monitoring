<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('ebis_planning_progress_logs', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('ebis_planning_order_id');
            $table->string('progres', 50);
            $table->text('keterangan')->nullable();
            $table->json('data')->nullable();

            $table->timestamps(); 

            $table->foreign('ebis_planning_order_id')
                  ->references('id')
                  ->on('ebis_planning_orders')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ebis_planning_progress_logs');
    }
};
