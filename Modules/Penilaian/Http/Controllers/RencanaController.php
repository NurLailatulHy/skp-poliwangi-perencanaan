<?php

namespace Modules\Penilaian\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Penilaian\Entities\RencanaKerja;
use Illuminate\Support\Facades\Auth;
use Modules\Pengaturan\Entities\Jabatan;
use Modules\Pengaturan\Entities\Pegawai;
use Modules\Penilaian\Entities\HasilKerja;

class RencanaController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(){
        $authUser = Auth::user();
        $pegawaiId = $authUser->pegawai->id;
        $pegawai = Pegawai::with(['timKerjaAnggota.ketua.pegawai', 'timKerjaAnggota.unit', 'pejabat.unit', 'pejabat.jabatan',])
                    ->where('id', '=', $pegawaiId)->first();

        // $pejabatPenilai = $pegawai->timKerjaAnggota ?? null;
        // if($pejabatPenilai != null){
        //     $parentHasilKerja = HasilKerja::with(['rencanakerja.pegawai'])
        //     ->whereHas('rencanakerja', function ($query) use ($pejabatPenilai) {
        //         $query->where('pegawai_id', $pejabatPenilai->ketua->pegawai->id);
        //     })
        //     ->get();
        // }
        $rencana = RencanaKerja::with('hasilKerja')->where('pegawai_id', '=', $pegawaiId)->first();
        return response()->json($pegawai);
        // if($pegawai && $pegawai->timKerjaAnggota){
        //     // return response()->json($anggota);
        //     return view('penilaian::rencana', compact('rencana'));
        // }else {
        //     // return response()->json($anggota);
        //     return view('penilaian::rencana', compact('rencana'));
        // }

    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create() {

    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(){
        try {
            $authUser = Auth::user();
            $pegawai = $authUser->pegawai;
            RencanaKerja::create([
                'status_persetujuan' => 'Belum Ajukan SKP',
                'status_realisasi' =>  'Belum Diajukan',
                'pegawai_id' => $pegawai->id
            ]);

            return redirect()->back()->with('success', 'Berhasil Buat SKP');
        } catch (\Throwable $th) {
            return response()->json($th->getMessage());
        }
    }

    public function storeHasilKerja(Request $request, $id) {
        $indikators = $request->indikators;
        try {
            $requestHasilKerja = [
                'rencana_id' => $id,
                'deskripsi' => $request->deskripsi,
                'indikator' => $indikators
            ];
            $hasilKerja = HasilKerja::create($requestHasilKerja);
            return redirect()->back()->with('success', 'Berhasil menambahkan hasil kerja');
        } catch (\Throwable $th) {
            return response()->json($th->getMessage());
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('penilaian::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('penilaian::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }
}
