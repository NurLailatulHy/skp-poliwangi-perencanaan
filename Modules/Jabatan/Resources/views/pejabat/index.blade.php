@extends('adminlte::page')
@section('title', 'Data Jabatan')
@section('content_header')
    <h1 class="m-0 text-dark">Data Jabatan</h1>
@stop

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">Data Jabatan</div>
            <div class="card-body">
                <a href="{{ url('/jabatan/data-jabatan/create') }}" type="button" class="btn btn-sm btn-primary waves-effect waves-light mb-3">
                    <i class="fa fa-plus me-2"></i> Tambah </a>
                <div class="table-responsive table-striped">
                    <table class="table align-middle table-nowrap mb-0 datatables" id="tabel_jabatan">
                        <thead class="table-light">
                            <tr>
                                <th class="text-center" style="width: 20px;">No</th>
                                <th class="align-middle text-center">Nama</th>
                                <th class="align-middle text-center" style="width: 200px;">Jabatan</th>
                                <th class="align-middle text-center">Mulai</th>
                                <th class="align-middle text-center">Selesai</th>
                                <th class="align-middle text-center">Status</th>
                                <th class="align-middle text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($jabatan as $item)
                                <tr>
                                    <td class="text-center">
                                        {{ $loop->iteration }}
                                    </td>
                                    @if ($item->pegawai_id != null)
                                    <td><a href="javascript: void(0);" class="text-body fw-bold">{{ $item->pegawai->nama }}</a> </td>
                                    
                                    @else
                                    <td><a href="javascript: void(0);" class="text-body fw-bold"></a> </td>
                                        
                                    @endif
									
                                    <td>{{ $item->pejabat }}</td>
                                    <td>
                                        {{ date('d F Y', strtotime($item->mulai)) }}
                                    </td>
                                    <td>
                                        {{ date('d F Y', strtotime($item->selesai)) }}
                                    </td>
                                    <td class="text-center">
                                        {{ $item->status }}
                                    </td>
                                    <td class="text-center">   
                                        <a href="{{ url('jabatan/data-jabatan/' . $item->id . '/edit') }}"><button type="button" class="btn btn-warning btn-sm mt-1"><i class="fas fa-pencil-alt"></i></button></a>
                                        <button type="button" class="btn btn-sm mt-1 btn-danger" data-toggle="modal" data-target="#hapus" onclick="hapus({{$item->id}})"><i class="fas fa-trash"></i></button>
                                      
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="hapus" dtabindex="-1" aria-labelledby="modalIcon" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Hapus Jabatan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
            </div>
            <div class="modal-body">
                Apa Anda Yakin ingin Menghapus Data ini?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-dark" data-dismiss="modal">Tutup</button>
                <form id="hapus_jabatan" method="POST">
                    @csrf
                    @method('delete')
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </form>
            </div>
            </form>
        </div>
    </div>
</div>
@endsection
@push('js')
        <script>
            let table = new DataTable('#tabel_jabatan');
            function hapus(id) {
            $('#hapus_jabatan').attr('action', "{{ url('/jabatan/data-jabatan/') }}" + "/" + id);
        }
        </script>
@endpush