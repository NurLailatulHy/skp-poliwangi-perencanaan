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
    public function cetakEvaluasi(Request $request){
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
            'pegawai' => $pegawai,
            'print_date' => $request->print_date,
            'margin_top'    => $request->margin_top,
            'margin_bottom' => $request->margin_bottom,
            'margin_left'   => $request->margin_left,
            'margin_right'  => $request->margin_right,
        ];

        $pdf = Pdf::loadView('penilaian::cetak-evaluasi-page', $data);
        $pdf->setPaper('a4', $request->position);

        // return response()->json([
        //     'a4' => $request->position,
        //     'isHtml5ParserEnabled' => true,
        //     'isRemoteEnabled' => true,
        //     'marginTop'    => $request->margin_atas,    // Top margin
        //     'marginBottom' => $request->margin_bawah,    // Bottom margin
        //     'marginLeft'   => $request->margin_kiri,    // Left margin
        //     'marginRight'  => $request->margin_kanan,    // Right margin
        // ]);
        return $pdf->download('laporan.pdf');
    }

    public function cetakDokEvaluasi(){
        $data = [
            'title' => 'Laporan Kinerja',
        ];
        $pdf = Pdf::loadView('penilaian::cetak-dokevaluasi-page', $data)
        ->setPaper('a4', 'potrait');

        return $pdf->download('laporan.pdf');
    }
}
