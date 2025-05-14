<?php

namespace Modules\Penilaian\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Penilaian\Entities\Periode;

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
            'tim_kerja_id' => 'required',
        ], [
            'periodetahun.required' => 'Periode tahun belum di-set.',
            'periodetahun.exists' => 'Periode tahun tidak ditemukan dalam data.',
            'unit_id.required' => 'Unit harus diisi.',
        ]);

        // dd(session()->all());
        try {
            session([
                'selected_periode_id' => $request->periodetahun,
                'tim_kerja_id' => $request->tim_kerja_id
            ]);
            return redirect()->to('/penilaian/rencana/');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $th->getMessage());
        }
    }
}
