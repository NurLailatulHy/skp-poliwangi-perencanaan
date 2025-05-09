<?php

namespace Modules\Penilaian\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Pengaturan\Entities\Anggota;
use Modules\Penilaian\Entities\RencanaKerja;
use Modules\Penilaian\Entities\HasilKerja;
use Modules\Pengaturan\Entities\Pegawai;
use Modules\Penilaian\Entities\Cascading;

class PenilaianController extends Controller
{
    public function index(){
        return view('penilaian::index');
    }

    public function realisasi(){
        $authUser = Auth::user();
        $pegawaiUsername = $authUser->pegawai->username;
        $pegawai = Pegawai::with([
            'timKerjaAnggota',
            'rencanaKerja.hasilKerja',
            'timKerjaAnggota.unit',
            'timKerjaAnggota.subUnits.unit',
            'timKerjaAnggota.parentUnit.unit',
        ])->where('username', $pegawaiUsername)->first();

        if($pegawai->timKerjaAnggota[0]->parentUnit != null){
            $atasan = $pegawai->timKerjaAnggota[0]->parentUnit->ketua->pegawai;
        }

        $timKerjaId = $pegawai->timKerjaAnggota[0]->id;
        $bawahan = Anggota::with(['timKerja', 'pegawai'])
        ->where(function ($query) use ($timKerjaId) {
            $query->where(function ($q) use ($timKerjaId) {
                    $q->whereHas('timKerja', function ($sub) use ($timKerjaId) {
                        $sub->where('parent_id', $timKerjaId);
                    })->where('peran', 'Ketua');
                })
                ->orWhere(function ($q) use ($timKerjaId) {
                    $q->whereHas('timKerja', function ($sub) use ($timKerjaId) {
                        $sub->where('id', $timKerjaId);
                    })->where('peran', 'Anggota');
                });
        })
        ->whereHas('pegawai', function ($q) use ($pegawaiUsername) {
            $q->where('username', '!=', $pegawaiUsername);
        })
        ->get();

        $rencana = RencanaKerja::with('hasilKerja')->where('pegawai_username', '=', $pegawaiUsername)->first();
        $indikatorIntervensi = Cascading::with('indikator.hasilKerja.rencanakerja')->where('pegawai_username', $pegawaiUsername)->get();

        return view('penilaian::realisasi', compact('rencana', 'pegawai', 'indikatorIntervensi'));
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

    public function kinerjaOrganisasi() {
        return view('penilaian::kinerjaOrganisasi');
    }

    public function matriksperanhasil(Request $request){
        $authuser = Auth::user();
        $pegawai = $authuser->pegawai;
        $rencana = Rencanakerja::with('hasilKerja.indikator')->where('pegawai_username', $pegawai->username)->first();

        if($request->query('params') == 'json') return response()->json($rencana);
        else return view('penilaian::matriksperanhasil', compact('rencana'));
    }

    public function ajukanRealisasi($id){
        try {
            $rencana = RencanaKerja::find($id);
            $rencana->update([
                'status_realisasi' => 'Sudah Diajukan'
            ]);
            return redirect()->back()->with('success', 'Berhasil ditambahkan');
        } catch (\Throwable $th) {
            return redirect()->back()->with('failed', $th->getMessage());
        }
    }

    public function prosesUmpanBalik(Request $request, $username){
        try {
            foreach ($request->feedback as $item) {
                HasilKerja::where('id', $item['hasil_kerja_id'])
                ->whereHas('rencanakerja.pegawai', function ($query) use ($username) {
                    $query->where('username', $username);
                })->update([
                    'umpan_balik_predikat' => $item['umpan_balik_predikat'],
                    'umpan_balik_deskripsi' => $item['umpan_balik_deskripsi'] ?? null,
                ]);
            }
            return redirect()->back()->with('success', 'proses umpan balik berhasil');
        } catch (\Throwable $th) {
            return response()->json($th->getMessage);
        }
    }

    public function simpanHasilEvaluasi(Request $request, $username) {
        $evaluasiController = new EvaluasiController();

        $requestEvaluasi = [
            'rating_hasil_kerja' => $request->rating_hasil_kerja,
            'deskripsi_rating_hasil_kerja' => $request->deskripsi_rating_hasil_kerja,
            'rating_perilaku' => $request->rating_perilaku,
            'deskripsi_rating_perilaku' => $request->deskripsi_rating_perilaku,
            'predikat_akhir' => $evaluasiController->predikatKinerja($request->rating_hasil_kerja, $request->rating_perilaku)
        ];

        try {
            RencanaKerja::where('pegawai_username', $username)->update($requestEvaluasi);
            return redirect()->back()->with('success', 'berhasil ditambahkan');
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage()
            ]);
        }
    }
}
