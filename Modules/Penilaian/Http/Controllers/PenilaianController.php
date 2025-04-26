<?php

namespace Modules\Penilaian\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Penilaian\Entities\RencanaKerja;
use Illuminate\Support\Facades\Redirect;
use Modules\Penilaian\Entities\HasilKerja;
use Modules\Penilaian\Entities\TimKerja;
use Illuminate\Support\Str;
use Modules\Pengaturan\Entities\Anggota;
use Modules\Pengaturan\Entities\Pegawai;
use Modules\Pengaturan\Entities\Pejabat;

class PenilaianController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('penilaian::index');
    }

    public function evaluasi() {
        return view('penilaian::evaluasi');
    }

    public function evaluasiDetail($id) {
        return view('penilaian::evaluasi-detail', [
            'id' => $id
        ]);
    }

    public function realisasi(){
        $authUser = Auth::user();
        $userId = $authUser->id;
        $pegawai = $authUser->pegawai;
        $anggota = Pegawai::with([
            'timKerjaAnggota.ketua.jabatan',
            'timKerjaAnggota.unit',
        ])->where('id', '=', $pegawai->id)->first();
        // return response()->json($anggota);
        $rencana = RencanaKerja::all();
        return view('penilaian::realisasi', compact('rencana', 'pegawai', 'anggota'));
    }

    public function updateRealisasi(Request $request, $id) {
        try {
            $hasilKerja = HasilKerja::find($id);
            $hasilKerja->update([
                'realisasi' => $request['realisasi']
            ]);
            return redirect()->back()->with('success', 'Realisasi berhasil diperbarui.');
        } catch (\Throwable $th) {
            return redirect()->back()->with('failed', $th->getMessage());
        }

    }

    public function rencana(){
        $rencana = RencanaKerja::all();
        return view('penilaian::rencana', compact('rencana'));
    }

    public function kinerjaOrganisasi(){
        return view('penilaian::kinerjaOrganisasi');
    }

    // public function timKerja(){
    //     $timKerja = TimKerja::all();
    //     return view('penilaian::tim-kerja', compact('timKerja'));
    // }

    // public function storeTimKerja(Request $request){
    //     try {
    //         TimKerja::create([
    //             'tim_kerja_id' => (string) Str::uuid(),
    //             'parent_tim_kerja_id' => $request->parent_tim_kerja_id ?? null,
    //             'nama_tim_kerja' => $request->nama_tim_kerja
    //         ]);
    //         // dd($timKerja);
    //                     // return response()->json($timKerja);
    //         return redirect()->back()->with('success', 'berhasil menyimpan.');
    //     } catch (\Throwable $th) {
    //         return redirect()->back()->with('failed', $th->getMessage());
    //     }

    // }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('penilaian::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        //
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
