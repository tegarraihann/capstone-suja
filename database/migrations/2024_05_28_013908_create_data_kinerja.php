<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('data_kinerja', function (Blueprint $table) {
            $table->id();

            // Kriteria kebersihan sebagai enum
            $table->enum('kriteria_kebersihan', ['harum', 'wangi', 'bau'])->nullable(false);

            // Tanggal dan waktu
            $table->date('tanggal')->nullable(false);
            $table->time('waktu')->nullable(false);

            // Foto before dan after
            $table->string('foto_before')->nullable(false);
            $table->string('foto_after')->nullable(false);

            // Status, relasi, dan komentar penolakan
            $table->enum('status', ['pending', 'approved_by_ap', 'approved_by_ab', 'rejected'])->default('pending');
            $table->foreignId('upload_by')->constrained('users')->onDelete('cascade');
            $table->foreignId('approve_by')->nullable()->constrained('users')->onDelete('cascade');
            $table->foreignId('reject_by')->nullable()->constrained('users')->onDelete('cascade');
            $table->foreignId('day_id')->nullable(false)->constrained('day')->onDelete('cascade');
            $table->text('reject_comment')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_kinerja');
    }
};
