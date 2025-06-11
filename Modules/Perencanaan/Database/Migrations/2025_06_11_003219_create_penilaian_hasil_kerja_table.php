<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePenilaianHasilKerjaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('penilaian_hasil_kerja', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('target_id');
            $table->string('target_type');
            $table->unsignedBigInteger('ketua_tim_id')->nullable();
            $table->string('umpan_balik_predikat')->nullable();
            $table->text('umpan_balik_deskripsi')->nullable();
            $table->timestamps();

            $table->foreign('ketua_tim_id')->references('id')->on('pegawais')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('penilaian_hasil_kerja');
    }
}
