<?php

namespace Modules\Penilaian\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Pengaturan\Entities\Pegawai;
use Modules\Pengaturan\Entities\Anggota;
use Illuminate\Support\Facades\DB;
use Modules\Pengaturan\Entities\Pejabat;
use Modules\Penilaian\Entities\HasilKerja;
use Modules\Penilaian\Entities\RencanaKerja;
use Modules\Penilaian\Entities\RencanaPerilaku;

class EvaluasiController extends Controller {

    protected $penilaianController;
    protected $periodeController;

    public function __construct(PenilaianController $penilaianController, PeriodeController $periodeController) {
        $this->penilaianController = $penilaianController;
        $this->periodeController = $periodeController;
    }

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
        $periodeId = $this->periodeController->periode_aktif();
        $pegawai = Pegawai::with(['timKerjaAnggota','rencanaKerja.hasilKerja',
            'timKerjaAnggota.unit', 'timKerjaAnggota.subUnits.unit','timKerjaAnggota.parentUnit.unit',
        ])->where('username', '=', $username)->first();

        $rencana = RencanaKerja::with(['hasilKerja', 'perilakuKerja', 'perilakuKerja.rencanaPerilaku'])
        ->where('periode_id', $periodeId)->where('pegawai_id', '=', $pegawai->id)->first();

        $hasiKerjaRecommendation = $this->hasilKerjaRecommendation($rencana);
        $perilakuRecommendation = $this->perilakuRecommendation($rencana);

        if($params == 'json') return response()->json([
            'hasil_kerja_rekomendasi' => $hasiKerjaRecommendation,
            'perilaku_rekomendasi' => $perilakuRecommendation
        ]);
        else return view('penilaian::evaluasi-detail', compact('pegawai', 'rencana', 'hasiKerjaRecommendation', 'perilakuRecommendation'));
    }

    public function index(Request $request){
        try {
            $pegawai = $this->penilaianController->getPegawaiWhoLogin();
            $periodeId = $this->periodeController->periode_aktif();
            $ketua = Pejabat::where('pegawai_id', '=', $pegawai->id)->first();
            $timKerjaId = $pegawai->timKerjaAnggota[0]->id;
            $username = $pegawai->username;

            if($ketua != null) {
                $bawahan = Anggota::with(['timKerja', 'pegawai.rencanakerja' => function ($query) use ($periodeId) {
                    $query->where('periode_id', $periodeId);
                }])->where(function ($query) use ($timKerjaId) {
                    $query->where(function ($q) use ($timKerjaId) {
                        $q->whereHas('timKerja', function ($sub) use ($timKerjaId) {
                            $sub->where('parent_id', $timKerjaId);
                        })->where('peran', 'Ketua');
                    })->orWhere(function ($q) use ($timKerjaId) {
                        $q->whereHas('timKerja', function ($sub) use ($timKerjaId) {
                            $sub->where('id', $timKerjaId);
                        })->where('peran', 'Anggota');
                    });
                })->whereHas('pegawai', function ($q) use ($username) {
                    $q->where('username', '!=', $username);
                })->paginate(10);

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
        $periodeId = $this->periodeController->periode_aktif();
        DB::beginTransaction();
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

            foreach ($request->feedback_perilaku_kerja as $item) {
                RencanaPerilaku::where('perilaku_kerja_id', $item['perilaku_kerja_id'])
                    ->whereHas('rencanakerja', function ($query) use ($username, $periodeId) {
                        $query->where('periode_id', $periodeId)
                            ->whereHas('pegawai', function ($q) use ($username) {
                                $q->where('username', $username);
                            });
                    })
                    ->update([
                        'umpan_balik_predikat' => $item['perilaku_umpan_balik_predikat'],
                        'umpan_balik_deskripsi' => $item['perilaku_umpan_balik_deskripsi'] ?? null,
                    ]);
            }
            DB::commit();
            return redirect()->back()->with('success', 'proses umpan balik berhasil');
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json($th->getMessage());
        }
    }

    public function simpanHasilEvaluasi(Request $request, $id) {
        $periodeId = $this->periodeController->periode_aktif();
        $requestEvaluasi = [
            'status_realisasi' => 'Sudah Dievaluasi',
            'rating_hasil_kerja' => $request->rating_hasil_kerja,
            'deskripsi_rating_hasil_kerja' => $request->deskripsi_rating_hasil_kerja,
            'rating_perilaku' => $request->rating_perilaku,
            'deskripsi_rating_perilaku' => $request->deskripsi_rating_perilaku,
            'predikat_akhir' => $this->predikatKinerja($request->rating_hasil_kerja, $request->rating_perilaku)
        ];

        try {
            RencanaKerja::where('pegawai_id', $id)->where('periode_id', $periodeId)->update($requestEvaluasi);
            return redirect()->back()->with('success', 'berhasil ditambahkan');
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage()
            ]);
        }
    }

    private function hasilKerjaRecommendation($rencana){
        $arr = $rencana->hasilKerja->map(function ($item) {
            return $this->predikatValue($item->umpan_balik_predikat);
        });
        $value = $arr->sum();
        $average = $value / count($arr);
        return $this->predikatValue($average);
    }

    private function perilakuRecommendation($rencana = null){
        $arr = $rencana->perilakuKerja->map(function ($item) {
            return $this->predikatValue($item->rencanaPerilaku->umpan_balik_predikat);
        });
        $value = $arr->sum();
        $average = $value / count($arr);
        return $this->predikatValue($average);
    }

    private function predikatValue($input){
        $map = [
            'Dibawah Ekspektasi' => 1,
            'Sesuai Ekspektasi' => 2,
            'Diatas Ekspektasi' => 3,
        ];

        if (is_string($input)) {
            return $map[$input] ?? 'Status tidak diketahui.';
        }

        if (is_numeric($input)) {
            $intValue = round($input);
            $result = array_search(intval($intValue), $map, true);
            return $result ?: 'Status tidak diketahui.';
        }

        return 'Status tidak diketahui.';
    }
}
