<?php

namespace Modules\Perencanaan\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Penilaian\Entities\RencanaKerja;
use Modules\Penilaian\Entities\HasilKerja;
use Modules\Penilaian\Entities\Indikator;
use Modules\Penilaian\Entities\Cascading;
use Modules\Penilaian\Entities\Periode;

class HasilKerjaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        $periode = Periode::first();

        // $this->call("OthersTableSeeder");
        $pegawaiId = 45; // Ubah sesuai data di database kamu
        $timKerjaId = 3;
        $periodeId = 1;

        $rencana = RencanaKerja::create([
            'pegawai_id' => $pegawaiId,
            'tim_kerja_id' => $timKerjaId,
            'periode_id' => $periodeId,
            'status_persetujuan' => 'Belum Ajukan SKP',
            'status_realisasi' => 'Belum Ajukan Realisasi',
        ]);

        $hasilKerja = HasilKerja::create([
            'rencana_id' => $rencana->id,
            'deskripsi' => 'Membuat laporan bulanan',
            'jenis' => 'utama',
        ]);

        $indikator = Indikator::create([
            'hasil_kerja_id' => $hasilKerja->id,
            'deskripsi' => 'Laporan selesai tepat waktu',
        ]);
        
        Cascading::create([
            'pegawai_id' => $pegawaiId,
            'indikator_id' => $indikator->id,
        ]);
        
    }
}
