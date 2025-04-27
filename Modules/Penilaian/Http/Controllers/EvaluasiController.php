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

class EvaluasiController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function evaluasi() {
        return view('penilaian::evaluasi');
    }

    public function evaluasiDetail($id) {
        return view('penilaian::evaluasi-detail', [
            'id' => $id
        ]);
    }

    public function index(Request $request)
    {
        try {
            $authUser = Auth::user();
            $pegawai = $authUser->pegawai;
            $ketua = Pejabat::where('pegawai', '=', $pegawai->nama)->first();
            if($ketua != null) {
                $bawahan = Pegawai::with(['timKerjaAnggota'])
                ->whereHas('timKerjaAnggota', function ($query) use ($ketua) {
                    $query->where('unit_id', $ketua->unit_id);
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

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
