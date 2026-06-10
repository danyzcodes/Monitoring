<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    
    public function up(): void
    {
        Schema::create('ebis_planning_orders', function (Blueprint $table) {
            $table->id();

            $table->string('star_click_id')->nullable();
            $table->string('track_id')->nullable();
            $table->string('ticket_id')->nullable();
            $table->string('star_click_status')->nullable();
            $table->string('status_alokasi_alpro')->nullable();
            $table->string('id_odp_alokasi_alpro')->nullable();
            $table->string('nama_odp_alokasi_alpro')->nullable();
            $table->string('reservation_id_alokasi_alpro')->nullable();
            $table->string('nama_pengguna_alokasi_alpro')->nullable();
            $table->string('username_nik_alokasi_alpro')->nullable();

            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->string('sales_code')->nullable();
            $table->text('remark')->nullable();
            $table->string('segment')->nullable();
            $table->string('cfu')->nullable();
            $table->string('source_app')->nullable();

            $table->date('disurvey_pada')->nullable();
            $table->date('estimasi_go_live')->nullable();
            $table->date('real_go_live')->nullable();
            $table->date('initial_date')->nullable();
            $table->date('finish_install_date')->nullable();

            $table->string('regional')->nullable();
            $table->string('witel')->nullable();
            $table->string('witel_lama')->nullable();
            $table->string('datel')->nullable();
            $table->string('sto')->nullable();
            $table->string('wok')->nullable();

            $table->string('nama_customer')->nullable();
            $table->string('telkomsel_area')->nullable();
            $table->string('telkomsel_regional')->nullable();
            $table->string('telkomsel_branch')->nullable();
            $table->string('telkomsel_cluster')->nullable();

            $table->string('status_order')->nullable();
            $table->string('validasi_planning')->nullable();
            $table->string('ihld_lop_id')->nullable();
            $table->string('eproposal_lop_id')->nullable();
            $table->string('eproposal_lop_parent_id')->nullable();
            $table->string('kode_program')->nullable();
            $table->string('nama_proyek')->nullable();
            $table->string('tipe_desain')->nullable();

            $table->integer('total_boq')->nullable();
            $table->decimal('capex_per_port', 15, 2)->nullable();
            $table->integer('odp_total')->nullable();
            $table->integer('total_port')->nullable();
            $table->string('jenis_program')->nullable();
            $table->string('batch_program')->nullable();

            $table->string('status_eproposal')->nullable();
            $table->string('status_tomps')->nullable();
            $table->string('status_tomps_last_activity')->nullable();
            $table->string('status_sap')->nullable();
            $table->string('status_proyek')->nullable();

            $table->date('odp_go_live')->nullable();
            $table->date('tanggal_waiting_caring')->nullable();
            $table->date('tanggal_submitted_eproposal')->nullable();
            $table->date('tanggal_inisiasi_tomps')->nullable();
            $table->date('tanggal_validasi_abd_tomps')->nullable();
            $table->date('tanggal_go_live_tomps')->nullable();

            $table->date('dibuat')->nullable();
            $table->date('diperbarui_pada')->nullable();
            $table->date('dihapus_pada')->nullable();
            $table->date('ditambahkan_pada')->nullable();

            $table->string('username_nik_pembuat')->nullable();
            $table->string('kategori_mitra')->nullable();
            $table->string('nama_mitra')->nullable();
            $table->decimal('revenue_plan', 15, 2)->nullable();
            $table->string('nama_cfu')->nullable();
            $table->year('tahun')->nullable();
            $table->string('kategori')->nullable();

            $table->timestamps();
        });
    }

    
    public function down(): void
    {
        Schema::dropIfExists('ebis_planning_orders');
    }
};
