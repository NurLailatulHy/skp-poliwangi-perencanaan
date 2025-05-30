<?php

namespace Modules\Penilaian\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Pengaturan\Entities\Pegawai;
use Barryvdh\DomPDF\Facade\Pdf;
use Dompdf\Dompdf;

class PrintController extends Controller {
    public function cetakEvaluasi(){
        $authUser = Auth::user();
        $authPegawai = $authUser->pegawai;
        $pegawaiUsername = $authPegawai->username;
        $pegawaiId = $authPegawai->id;

        $pegawai = Pegawai::with([
            'pejabat.jabatan',
            'timKerjaAnggota',
            'rencanaKerja.hasilKerja',
            'timKerjaAnggota.unit',
            'timKerjaAnggota.subUnits.unit',
            'timKerjaAnggota.parentUnit.unit',
        ])->where('username', $pegawaiUsername)->first();

        $data = [
            'title' => 'Laporan Kinerja',
            'pegawai' => $pegawai
        ];

        $pdf = Pdf::loadView('penilaian::cetak-evaluasi-page', $data)
        ->setPaper('a4', 'potrait');

        return $pdf->download('laporan.pdf');
    }

    public function cetakDokEvaluasi(){
        $html = view('penilaian::cetak-dokevaluasi-page')->render();

        $pdf = new Dompdf();
        $pdf->loadHtml($html);
        $pdf->render();

        return response($pdf->output(), 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'inline; filename="laporan.pdf"');
    }
}
