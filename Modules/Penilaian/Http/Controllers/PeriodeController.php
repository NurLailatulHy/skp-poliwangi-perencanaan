<?php

namespace Modules\Penilaian\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Penilaian\Entities\Periode;
use Illuminate\Support\Facades\Auth;
use Modules\Pengaturan\Entities\Pegawai;

class PeriodeController extends Controller
{
    public function index(){
        $periodes = Periode::all();
        return view('penilaian::periode.index', compact('periodes'));
    }

    public function store(Request $request){
        try {
            Periode::create([
                'start_date' => $request->periode_awal,
                'end_date' => $request->periode_akhir,
                'tahun' => $request->tahun,
                'jenis_periode' => $request->jenis_periode
            ]);

            return redirect()->back()->with('success', 'tambah periode berhasil');
        } catch (\Throwable $th) {
            return response()->json($th->getMessage());
        }
    }

    public function setPeriode(Request $request){
        $request->validate([
            'periodetahun' => 'required|exists:periodes,id',
        ]);
        // dd($request->periodetahun);
        session(['selected_periode_id' => $request->periodetahun]);
        return redirect()->to('/penilaian/rencana/');
    }

    public function previewEvaluasi(){
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
        return view('penilaian::cetak-evaluasi-page', compact('pegawai'));
    }
}
