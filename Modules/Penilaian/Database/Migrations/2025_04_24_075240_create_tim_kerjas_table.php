<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTimKerjasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('skp_tim_kerja', function (Blueprint $table) {
            $table->id();
            // $table->uuid('tim_kerja_id')->primary();
            // $table->uuid('parent_tim_kerja_id')->nullable();
            // $table->foreign('atasan_id')->nullable()->references('id')->on('users')->onDelete('cascade');
            // $table->string('nama_tim_kerja');
            // $table->timestamps();

            // $table->foreign('parent_tim_kerja_id')->references('tim_kerja_id')->on('skp_tim_kerja')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tim_kerjas');
    }
}
