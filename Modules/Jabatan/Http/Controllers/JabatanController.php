<?php

namespace Modules\Jabatan\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Jabatan\Entities\Pejabat;
use Modules\Jabatan\Entities\Unit;
use Modules\Jabatan\Entities\Jabatan;
use Modules\MasterKepegawaian\Entities\Pegawai;

class JabatanController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $jabatan = Pejabat::with('pegawai')->get();
        return view('jabatan::pejabat.index', compact('jabatan'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $pegawai = Pegawai::all();
        $unit = Unit::all();
		$jabatan = Jabatan::all();
        return view('jabatan::pejabat.create', compact('pegawai', 'unit','jabatan'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $data = [
            'pegawai_id' => $request->pegawai_id,
            'jabatan_id' => $request->jabatan_id,
            'mulai' => $request->mulai,
            'selesai' => $request->selesai,
            'unit_id' => $request->unit_id,
            'status' => $request->status,
        ];
        if ($request->hasFile('SK')) {
            $file = $request->file('SK');
            $extension = $file->getClientOriginalExtension();
            $file_name = \Str::random(20) . '.' . $extension;
            $file->storeAs('/assets/img/SK', $file_name, 'public');
            $data['SK'] = $file_name;
        }		
        Pejabat::create($data);
        return redirect('/jabatan/data-jabatan')->with('success_message', 'Jabatan added!');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('jabatan::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $pegawai = Pegawai::all();
        $unit = Unit::all();
        $pejabat = Pejabat::findOrFail($id);
		$jabatan = Jabatan::all();
        return view('jabatan::pejabat.edit', compact('pegawai', 'unit', 'pejabat', 'jabatan'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        $jabatanEdit = Pejabat::findOrFail($id);
        $data = [
            'pegawai_id' => $request->pegawai_id,
            'jabatan_id' => $request->jabatan_id,
            'mulai' => $request->mulai,
            'selesai' => $request->selesai,
            'unit_id' => $request->unit_id,
            'status' => $request->status,
        ];
        if (!empty($request->hasFile('SK'))) {
            $destination = '/storage/app/public/assets/img/SK/' . $jabatanEdit->SK;
            if (\File::exists($destination)) {
                \File::delete($destination);
            }
            $file = $request->file('SK');
            $extension = $file->getClientOriginalExtension();
            $file_name = \Str::random(20) . '.' . $extension;
            $file->storeAs('/assets/img/SK', $file_name, 'public');
            $data['SK'] = $file_name;
        }
        $jabatanEdit->update($data);
        return redirect('/jabatan/data-jabatan')->with('success_message', 'Jabatan Updated!');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        $hapus = Pejabat::findOrFail($id);
        $hapus->delete();
        return back();
    }
}
