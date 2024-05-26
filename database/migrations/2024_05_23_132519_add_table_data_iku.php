<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('data_iku', function (Blueprint $table) {
            $table->id();
            $table->integer('perjanjian_kinerja_target_kumulatif')->default(0)->nullable(false);
            $table->integer('perjanjian_kinerja_realisasi_kumulatif')->default(0)->nullable(false);
            $table->float('capaian_kinerja_kumulatif')->default(0.0)->nullable(false);
            $table->float('capaian_kinerja_target_setahun')->default(0.0)->nullable(false);
            $table->string('link_bukti_dukung_capaian')->nullable(false);
            $table->text('upaya_yang_dilakukan')->nullable(false);
            $table->string('link_bukti_dukung_upaya_yang_dilakukan')->nullable(false);
            $table->text('kendala')->nullable(false);
            $table->text('solusi_atas_kendala')->nullable(false);
            $table->text('rencana_tidak_lanjut')->nullable(false);
            $table->string('pic_tidak_lanjut')->nullable(false);
            $table->date('tenggat_tidak_lanjut')->nullable(false);
            $table->timestamps();

            $table->enum('status', ['pending', 'approved_by_ap', 'approved_by_ab', 'rejected'])->default('pending');
            $table->foreignId('upload_by')->constrained('users')->onDelete('cascade');
            $table->foreignId('approve_by')->nullable()->constrained('users')->onDelete('cascade');
            $table->foreignId('reject_by')->nullable()->constrained('users')->onDelete('cascade');
            $table->text('reject_comment')->nullable();
            $table->tinyInteger('triwulan')->nullable(false);

            $table->foreignId('indikator_id')->nullable()->unique()->constrained('md_indikator')->onDelete('cascade');
            $table->foreignId('indikator_penunjang_id')->nullable()->unique()->constrained('md_indikator_penunjang')->onDelete('cascade');
            $table->foreignId('sub_indikator_id')->nullable()->unique()->constrained('md_sub_indikator')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_iku');
    }
};
