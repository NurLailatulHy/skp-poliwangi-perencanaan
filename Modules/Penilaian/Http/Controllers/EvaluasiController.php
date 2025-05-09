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
use Modules\Penilaian\Entities\RencanaKerja;

class EvaluasiController extends Controller
{

    public function predikatKinerja($hasilKerja, $perilaku) {
        // $hasilKerja = (int) $request->input('hasil_kerja');
        // $perilaku   = (int) $request->input('perilaku');
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

        $rencana = RencanaKerja::with('hasilKerja')->where('pegawai_username', '=', $username)->first();
        if($params == 'json') return response()->json($rencana);
        else return view('penilaian::evaluasi-detail', compact('pegawai', 'rencana'));
    }

    public function index(Request $request){
        try {
            $authUser = Auth::user();
            $pegawai = $authUser->pegawai;
            $username = $pegawai->username;
            $ketua = Pejabat::where('pegawai_username', '=', $username)->first();
            $timKerjaId = $pegawai->timKerjaAnggota[0]->id;

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
}
