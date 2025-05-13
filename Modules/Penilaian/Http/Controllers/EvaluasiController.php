<?php

namespace Modules\Penilaian\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Pengaturan\Entities\Pegawai;
use Modules\Pengaturan\Entities\Anggota;
use Modules\Pengaturan\Entities\TimKerja;
use Modules\Pengaturan\Entities\Pejabat;
use Modules\Penilaian\Entities\HasilKerja;
use Modules\Penilaian\Entities\RencanaKerja;

class EvaluasiController extends Controller
{

    public function predikatKinerja($hasilKerja, $perilaku) {
        $hasilKerjaMap = [ 'Dibawah Ekspektasi' => 1, 'Sesuai Ekspektasi' => 2, 'Diatas Ekspektasi' => 3 ];
        $perilakuMap = [ 'Dibawah Ekspektasi' => 1, 'Sesuai Ekspektasi' => 2, 'Diatas Ekspektasi' => 3 ];

        $hasilKerjaValue = $hasilKerjaMap[$hasilKerja] ?? null;
        $perilakuValue = $perilakuMap[$perilaku] ?? null;

        $matrix = [
            1 => [
                1 => 'Sangat Kurang',
                2 => 'Butuh Perbaikan',
                3 => 'Butuh Perbaikan',
            ],
            2 => [
                1 => 'Kurang',
                2 => 'Baik',
                3 => 'Baik',
            ],
            3 => [
                1 => 'Kurang',
                2 => 'Baik',
                3 => 'Sangat Baik',
            ],
        ];

        $result = ($hasilKerjaValue && $perilakuValue) ? ($matrix[$hasilKerjaValue][$perilakuValue] ?? 'Data tidak valid') : 'Data tidak valid';

        return $result;
    }

    public function evaluasi() {
        return view('penilaian::evaluasi');
    }

    public function evaluasiDetail(Request $request, $username) {
        $params = $request->query('params');
        $pegawai = Pegawai::with([
            'timKerjaAnggota',
            'rencanaKerja.hasilKerja',
            'timKerjaAnggota.unit',
            'timKerjaAnggota.subUnits.unit',
            'timKerjaAnggota.parentUnit.unit',
        ])->where('username', '=', $username)->first();

        $rencana = RencanaKerja::with('hasilKerja')->where('pegawai_id', '=', $pegawai->id)->first();
        if($params == 'json') return response()->json($rencana);
        else return view('penilaian::evaluasi-detail', compact('pegawai', 'rencana'));
    }

    public function index(Request $request){
        try {
            $authUser = Auth::user();
            $pegawai = $authUser->pegawai;
            $username = $pegawai->username;
            $timKerjaId = $pegawai->timKerjaAnggota[0]->id;
            $ketua = Pejabat::where('pegawai_id', '=', $pegawai->id)->first();

            if($ketua != null) {
                $bawahan = Anggota::with(['timKerja', 'pegawai.rencanakerja'])
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
                ->whereHas('pegawai', function ($q) use ($username) {
                    $q->where('username', '!=', $username);
                })
                ->paginate(10);

                return response()->json([
                    'status' => 'success',
                    'draw' => $request->draw,
                    'recordsTotal' => $bawahan->total(),
                    'recordsFiltered' => $bawahan->total(),
                    'data' => $bawahan->items()
                ]);
            }else {
                return response()->json([
                    'status' => 'success',
                    'draw' => $request->draw,
                    'recordsTotal' => 0,
                    'recordsFiltered' => 0,
                    'data' => [],
                    'message' => 'No data available'
                ]);
            }
        } catch (\Throwable $th) {
            return response()->json($th->getMessage());
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

    public function simpanHasilEvaluasi(Request $request, $id) {

        $requestEvaluasi = [
            'status_realisasi' => 'Sudah Dievaluasi',
            'rating_hasil_kerja' => $request->rating_hasil_kerja,
            'deskripsi_rating_hasil_kerja' => $request->deskripsi_rating_hasil_kerja,
            'rating_perilaku' => $request->rating_perilaku,
            'deskripsi_rating_perilaku' => $request->deskripsi_rating_perilaku,
            'predikat_akhir' => $this->predikatKinerja($request->rating_hasil_kerja, $request->rating_perilaku)
        ];

        try {
            RencanaKerja::where('pegawai_id', $id)->update($requestEvaluasi);
            return redirect()->back()->with('success', 'berhasil ditambahkan');
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage()
            ]);
        }
    }
}
