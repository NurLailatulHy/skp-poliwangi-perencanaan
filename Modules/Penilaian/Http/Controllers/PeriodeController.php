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
            'unit_id' => 'required',
        ]);
        session([
            'selected_periode_id' => $request->periodetahun,
            'unit_id' => $request->unit_id
        ]);
        // dd(session()->all());
        return redirect()->to('/penilaian/rencana/');
    }
}
