<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSkpRencanaKerjaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('skp_rencana_kerja');
        Schema::create('skp_rencana_kerja', function (Blueprint $table) {
            $table->id();
            $table->enum('status_persetujuan', ['Belum Buat SKP', 'Belum Ajukan SKP', 'Belum Disetujui', 'Sudah Disetujui'])->default('Belum Buat SKP');
            $table->enum('status_realisasi', ['Belum Diajukan', 'Sudah Diajukan', 'Belum Dievaluasi', 'Sudah Dievaluasi'])->default('Belum Diajukan');
            $table->string('rating_hasil_kerja')->nullable();
            $table->text('deskripsi_rating_hasil_kerja')->nullable();
            $table->string('rating_perilaku')->nullable();
            $table->text('deskripsi_rating_perilaku')->nullable();
            $table->enum('predikat_akhir', ['Istimewa', 'Baik', 'Cukup', 'Kurang', 'Sangat Kurang', 'Butuh Perbaikan'])->nullable();
            $table->foreignId('periode_id')->nullable();
            $table->unsignedBigInteger('pegawai_id')->nullable();
            $table->foreign('pegawai_id')->references('id')->on('pegawai')->onDelete('cascade');
            $table->unsignedBigInteger('lampiran_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('skp_rencana_kerja');
    }
}
