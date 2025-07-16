<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePejabatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pejabats', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->char('jabatan', 100);
            $table->date('mulai')->nullable();
            $table->date('selesai')->nullable();
            $table->char('SK', 150)->nullable();
            $table->unsignedBigInteger('pegawai_id')->nullable();
            $table->unsignedBigInteger('unit_id')->nullable();
            $table->enum('status', ['Aktif', 'Non Aktif'])->default('Aktif');

            $table->timestamps();
        });
        DB::table('pejabats')->insert([
            ['id' => 1, 'jabatan' => 'Direktur'],
            ['id' => 2, 'jabatan' => 'Wakil Direktur Bidang Akademik'],
            ['id' => 3, 'jabatan' => 'Wakil Direktur Bidang Umum dan Keuangan'],
            ['id' => 4, 'jabatan' => 'Wakil Direktur Bidang Kemahasiswaan dan Alumni'],
            ['id' => 5, 'jabatan' => 'Ketua Jurusan Bisnis dan Informatika'],
            ['id' => 6, 'jabatan' => 'Ketua Jurusan Teknik Mesin'],
            ['id' => 7, 'jabatan' => 'Ketua Jurusan Teknik Sipil'],
            ['id' => 8, 'jabatan' => 'Ketua Jurusan Pariwisata'],
            ['id' => 9, 'jabatan' => 'Ketua Jurusan Pertanian'],
            ['id' => 10, 'jabatan' => 'Sekretaris Jurusan Bisnis dan Informatika'],
            ['id' => 11, 'jabatan' => 'Sekretaris Jurusan Teknik Mesin'],
            ['id' => 12, 'jabatan' => 'Sekretaris Jurusan Teknik Sipil'],
            ['id' => 13, 'jabatan' => 'Sekretaris Jurusan Pariwisata'],
            ['id' => 14, 'jabatan' => 'Sekretaris Jurusan Pertanian'],
            ['id' => 15, 'jabatan' => 'Kepala Pusat Penelitian dan Pengabdian Kepada Masyarakat'],
            ['id' => 16, 'jabatan' => 'Kepala Pusat Penjaminan Mutu'],
            ['id' => 17, 'jabatan' => 'Kepala UPT Kewirausahaan dan Inkubistek'],
            ['id' => 18, 'jabatan' => 'Kepala UPT Bahasa dan Budaya'],
            ['id' => 19, 'jabatan' => 'Kepala UPT Teknologi Informasi dan Komunikasi'],
            ['id' => 20, 'jabatan' => 'Kepala UPT Perpustakaan'],
            ['id' => 21, 'jabatan' => 'Ketua Unit Job Placement Center'],
            ['id' => 22, 'jabatan' => 'Ketua Unit Kerjasama dan Urusan Internasional'],
            ['id' => 23, 'jabatan' => 'Ketua Unit Kesehatan Kampus'],
            ['id' => 24, 'jabatan' => 'Ketua Unit Hubungan Masyarakat'],
            ['id' => 25, 'jabatan' => 'Ketua Unit Pengadaan'],
            ['id' => 26, 'jabatan' => 'Ketua Program Studi Teknologi Rekayasa Perangkat Lunak'],
            ['id' => 27, 'jabatan' => 'Ketua Program Studi Teknologi Rekayasa Komputer'],
            ['id' => 28, 'jabatan' => 'Ketua Program Studi Bisnis Digital'],
            ['id' => 29, 'jabatan' => 'Ketua Program Studi Teknologi Rekayasa Manufaktur'],
            ['id' => 30, 'jabatan' => 'Ketua Program Studi Teknik Manufaktur Kapal'],
            ['id' => 31, 'jabatan' => 'Ketua Program Studi Teknik Sipil'],
            ['id' => 32, 'jabatan' => 'Ketua Program Studi Teknologi Rekayasa Konstruksi Jalan dan Jembatan'],
            ['id' => 33, 'jabatan' => 'Ketua Program Studi Manajemen Bisnis Pariwisata'],
            ['id' => 34, 'jabatan' => 'Ketua Program Studi Destinasi Pariwisata'],
            ['id' => 35, 'jabatan' => 'Ketua Program Studi Pengelolaan Perhotelan'],
            ['id' => 36, 'jabatan' => 'Ketua Program Studi Teknologi Pengolahan Hasil Ternak'],
            ['id' => 37, 'jabatan' => 'Ketua Program Studi Agribisnis'],
            ['id' => 38, 'jabatan' => 'Ketua Program Studi Teknologi Produksi Ternak'],
            ['id' => 39, 'jabatan' => 'Ketua Program Studi Pengembangan Produk Agroindustri'],
            ['id' => 40, 'jabatan' => 'Ketua Program Studi Teknologi Produksi Tanaman Pangan'],
            ['id' => 41, 'jabatan' => 'Ketua Program Studi Teknologi Budi Daya Perikanan'],
            ['id' => 42, 'jabatan' => 'Ketua Laboratorium Jurusan Bisnis dan Informatika'],
            ['id' => 43, 'jabatan' => 'Ketua Laboratorium Jurusan Teknik Sipil'],
            ['id' => 44, 'jabatan' => 'Ketua Laboratorium Jurusan Teknik Mesin'],
            ['id' => 45, 'jabatan' => 'Ketua Laboratorium Program Studi Teknologi Pengolahan Hasil Ternak'],
            ['id' => 46, 'jabatan' => 'Ketua Laboratorium Jurusan Pariwisata'],
            ['id' => 47, 'jabatan' => 'Ketua Laboratorium Program Studi Agribisnis'],
            ['id' => 48, 'jabatan' => 'Koordinator Akademik dan Kemahasiswaan'],
            ['id' => 49, 'jabatan' => 'Koordinator Perencanaan dan Sistem Informasi'],
            ['id' => 50, 'jabatan' => 'Koordinator Umum dan Kepegawaian'],
            ['id' => 51, 'jabatan' => 'Koordinator Keuangan'],
            ['id' => 52, 'jabatan' => 'Ketua Senat'],
            ['id' => 53, 'jabatan' => 'Ketua Satuan Pengawasan Internal'],
            ['id' => 54, 'jabatan' => 'Ketua Lembaga Sertifikasi Profesi'],
            ['id' => 55, 'jabatan' => 'Ketua Penerbit Poliwangi Press']
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pejabats');
    }
}
