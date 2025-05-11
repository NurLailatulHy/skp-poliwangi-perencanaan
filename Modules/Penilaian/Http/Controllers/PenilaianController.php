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
        $pegawai = $authUser->pegawai;
        $pegawaiUsername = $pegawai->username;
        $pegawaiId = $pegawai->id;

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

        $rencana = RencanaKerja::with('hasilKerja')->where('pegawai_id', '=', $pegawaiId)->first();
        $indikatorIntervensi = Cascading::with('indikator.hasilKerja.rencanakerja')->where('pegawai_id', $pegawaiId)->get();

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
}
