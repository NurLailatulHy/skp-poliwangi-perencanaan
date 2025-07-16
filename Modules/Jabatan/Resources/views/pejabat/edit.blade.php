@extends('adminlte::page')
@section('title', 'Edit Jabatan')
@section('content_header')
    <h1 class="m-0 text-dark"></h1>
@stop
@section('content')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">Edit Jabatan</div>
                <div class="card-body">
                    <a href="{{ url(Request::server('HTTP_REFERER') == null ? '/jabatan/data-jabatan' : Request::server('HTTP_REFERER')) }}" title="Kembali"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Kembali</button></a>
                    <br>
                    <form action="{{ url('jabatan/data-jabatan/'.$pejabat->id) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')
                        <div class="row mb-2">
                            <div class="col-md-6">
                                <label for="example-text-input" class="col-form-label">Nama Pegawai <span class="text-danger fw-bold">*</span></label>
                                <select name="pegawai_id" class="form-control" id="" required>
                                    <option value="" selected disabled>--Pilih--</option>
                                    @foreach ($pegawai as $item)
                                        <option value="{{ $item->id }}" {{$item->id == $pejabat->pegawai_id ? 'selected' : '' }}>{{ $item->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="example-text-input" class="col-form-label">Jabatan<span class="text-danger fw-bold">*</span></label>
								<select name="jabatan_id" class="form-control" id="" required>
                                    <option value="" selected disabled>--Pilih--</option>
                                    @foreach ($jabatan as $item)
                                        <option value="{{ $item->id }}" {{$item->id == $pejabat->jabatan_id ? 'selected' : '' }}>{{ $item->jabatan }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-6">
                                <label for="example-text-input" class="col-form-label">Mulai <span class="text-danger fw-bold">*</span></label>
                                <input class="form-control" type="date" name="mulai" value="{{$pejabat->mulai}}" required>
                            </div>
                            <div class="col-md-6">
                                <label for="example-text-input" class="col-form-label">Selesai <span class="text-danger fw-bold">*</span></label>
                                <input class="form-control" type="date" name="selesai" value="{{$pejabat->selesai}}"  required>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-12">
                                <label for="example-text-input" class="col-form-label">Unit</label>
                                <select name="unit_id" class="form-control" id="">
                                    <option value="" selected disabled>--Pilih--</option>
                                    @foreach ($unit as $item)
                                        <option value="{{ $item->id }}" {{$item->id == $pejabat->unit_id ? 'selected' : '' }}>{{ $item->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-6">
                                <label for="example-text-input" class="col-form-label">SK</label>
                                <input class="form-control" type="file" name="SK" value="{{$pejabat->SK}}" >
                            </div>
                            <div class="col-md-6">
                                <label for="example-text-input" class="col-form-label">Status</label>
                                <select name="status" class="form-control" id="">
                                    <option value="" selected disabled>--Pilih--</option>
                                    <option value="Aktif" {{$pejabat->status == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                                    <option value="Non Aktif" {{$pejabat->status == 'Non Aktif' ? 'selected' : '' }}>Non Aktif</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-2 mt-3">
                            <div class="col-md-8 d-flex">
                                <div class="col-md-2">
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
