@extends('adminlte::page')

@section('title', 'Dasbor Simlitabmas')

@section('content_header')
    <h1 class="m-0 text-dark">Evaluasi SKP</h1>
@stop
@php
    $pejabatPenilai = $pegawaiYangDinilai->timKerjaAnggota[0] ?? null;
@endphp
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="w-100 d-flex justify-content-between align-items-center p-4">
                    <button id="proses-umpan-balik-button" class="btn btn-primary ml-1">Batalkan Evaluasi</button>
                </div>
                <div class="bg-white d-flex p-4">
                    <table class="table" style="table-layout: fixed; width: 100%;">
                        <thead>
                          <tr>
                            <th scope="col">No</th>
                            <th colspan="2">Pegawai yang dinilai</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <th scope="row">1</th>
                            <td>Nama</td>
                            <td>{{ $pegawaiYangDinilai->nama }}</td>
                          </tr>
                          <tr>
                            <th scope="row">2</th>
                            <td>NIP</td>
                            <td>{{ $pegawaiYangDinilai->nip }}</td>
                          </tr>
                          <tr>
                            <th scope="row">3</th>
                            <td>Pangkat / Gol</td>
                            <td>IV</td>
                          </tr>
                          <tr>
                            <th scope="row">4</th>
                            <td>Jabatan</td>
                            <td>-</td>
                          </tr>
                          <tr>
                            <th scope="row">5</th>
                            <td>Unit Kerja</td>
                            <td>{{ $pegawaiYangDinilai->anggota->timKerja->unit->nama }}</td>
                          </tr>
                        </tbody>
                    </table>
                    <table class="table" style="table-layout: fixed; width: 100%;">
                        <thead>
                          <tr>
                            <th scope="col">No</th>
                            <th colspan="2">Pejabat Penilai Kinerja</th>
                          </tr>
                        </thead>
                        <tbody>
                            <tr>
                              <th scope="row">1</th>
                              <td>Nama</td>
                              <td>{{ $pejabatPenilai->ketua->pegawai->nama }}</td>
                            </tr>
                            <tr>
                              <th scope="row">2</th>
                              <td>NIP</td>
                              <td>{{ $pejabatPenilai->ketua->pegawai->nip }}</td>
                            </tr>
                            <tr>
                              <th scope="row">3</th>
                              <td>Pangkat / Gol</td>
                              <td>-</td>
                            </tr>
                            <tr>
                              <th scope="row">4</th>
                              <td>Jabatan</td>
                              <td>{{ $pejabatPenilai->ketua->jabatan->nama_jabatan }}</td>
                            </tr>
                            <tr>
                              <th scope="row">5</th>
                              <td>Unit Kerja</td>
                              <td>{{ $pejabatPenilai->unit->nama }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="bg-white p-4">
                    <table class="table mb-0" style="table-layout: fixed; width: 100%;">
                        <thead>
                          <tr>
                            <th colspan="4">HASIL KERJA</th>
                          </tr>
                          <tr>
                            <th colspan="4">A. Utama</th>
                          </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="4">No data</td>
                            </tr>
                            {{-- <tr>
                                <th scope="row">1</th>
                                <td>
                                    <p>
                                        Manual book penggunaan aplikasi modul penyusunan SKP yang lengkap dan informatif (Penugasan dari Ketua Tim Perencanaan dan Sistem Informasi)
                                    </p>
                                    <span>Ukuran keberhasilan / Indikator Kinerja Individu, dan Target :</span>
                                    <ul>
                                        <li>Draft manual book penggunaan aplikasi modul penyusunan rencana SKP yang lengkap sesuai dengan ketentuan dan diselesaikan maksimal satu bulan sebelum kegiatan sosialisasi</li>
                                    </ul>
                                </td>
                                <td>
                                    <span>Realisasi :</span>
                                    <p>Draft manual book aplikasi untuk modul penyusunan rencana SKP telah selesai pada bulan April sesuai dengan proses bisnis aplikasi</p>
                                </td>
                                <td>
                                    <span>Umpan Balik :</span>
                                    <div class="input-group">
                                        <select class="custom-select" id="inputGroupSelect04">
                                        <option selected>Choose...</option>
                                        <option value="1">One</option>
                                        <option value="2">Two</option>
                                        <option value="3">Three</option>
                                        </select>
                                        <div class="input-group-append">
                                        <button class="btn btn-outline-secondary" type="button">
                                            <i class="nav-icon fas fa-copy "></i>
                                        </button>
                                        </div>
                                    </div>
                                    <textarea style="height: 150px; width: 100%; padding: 10px; overflow-y: auto; resize: vertical;"></textarea>
                                </td>
                            </tr> --}}
                        </tbody>
                    </table>
                    <table class="table mb-0" style="table-layout: fixed; width: 100%;">
                        <thead>
                          <tr>
                            <th colspan="4">B. Tambahan</th>
                          </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="4">No data</td>
                            </tr>
                            {{-- <tr>
                                <th scope="row">1</th>
                                <td>
                                    <p>
                                        Manual book penggunaan aplikasi modul penyusunan SKP yang lengkap dan informatif (Penugasan dari Ketua Tim Perencanaan dan Sistem Informasi)
                                    </p>
                                    <span>Ukuran keberhasilan / Indikator Kinerja Individu, dan Target :</span>
                                    <ul>
                                        <li>Draft manual book penggunaan aplikasi modul penyusunan rencana SKP yang lengkap sesuai dengan ketentuan dan diselesaikan maksimal satu bulan sebelum kegiatan sosialisasi</li>
                                    </ul>
                                </td>
                                <td>
                                    <span>Realisasi :</span>
                                    <p>Draft manual book aplikasi untuk modul penyusunan rencana SKP telah selesai pada bulan April sesuai dengan proses bisnis aplikasi</p>
                                </td>
                                <td>
                                    <span>Umpan Balik :</span>
                                    <div class="input-group">
                                        <select class="custom-select" id="inputGroupSelect04">
                                        <option selected>Choose...</option>
                                        <option value="1">One</option>
                                        <option value="2">Two</option>
                                        <option value="3">Three</option>
                                        </select>
                                        <div class="input-group-append">
                                        <button class="btn btn-outline-secondary" type="button">
                                            <i class="nav-icon fas fa-copy "></i>
                                        </button>
                                        </div>
                                    </div>
                                    <textarea style="height: 150px; width: 100%; padding: 10px; overflow-y: auto; resize: vertical;"></textarea>
                                </td>
                            </tr> --}}
                        </tbody>
                    </table>
                    <table class="table mb-0" style="table-layout: fixed; width: 100%;">
                        <thead>
                          <tr>
                            <th colspan="4">PERILAKU KERJA</th>
                          </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="4">No data</td>
                            </tr>
                            {{-- <tr>
                                <th scope="row">1</th>
                                <td>
                                    <p>
                                        Manual book penggunaan aplikasi modul penyusunan SKP yang lengkap dan informatif (Penugasan dari Ketua Tim Perencanaan dan Sistem Informasi)
                                    </p>
                                    <span>Ukuran keberhasilan / Indikator Kinerja Individu, dan Target :</span>
                                    <ul>
                                        <li>Draft manual book penggunaan aplikasi modul penyusunan rencana SKP yang lengkap sesuai dengan ketentuan dan diselesaikan maksimal satu bulan sebelum kegiatan sosialisasi</li>
                                    </ul>
                                </td>
                                <td>
                                    <span>Realisasi :</span>
                                    <p>Draft manual book aplikasi untuk modul penyusunan rencana SKP telah selesai pada bulan April sesuai dengan proses bisnis aplikasi</p>
                                </td>
                                <td>
                                    <span>Umpan Balik :</span>
                                    <div class="input-group">
                                        <select class="custom-select" id="inputGroupSelect04">
                                        <option selected>Choose...</option>
                                        <option value="1">One</option>
                                        <option value="2">Two</option>
                                        <option value="3">Three</option>
                                        </select>
                                        <div class="input-group-append">
                                        <button class="btn btn-outline-secondary" type="button">
                                            <i class="nav-icon fas fa-copy "></i>
                                        </button>
                                        </div>
                                    </div>
                                    <textarea style="height: 150px; width: 100%; padding: 10px; overflow-y: auto; resize: vertical;"></textarea>
                                </td>
                            </tr> --}}
                        </tbody>
                    </table>
                    <div class="w-100 mt-4 d-flex justify-content-end">
                        <button onclick="displayProsesUmpanBalik()" id="proses-umpan-balik-button" class="btn btn-primary">Proses Umpan Balik</button>
                    </div>
                    <div id="proses-umpan-balik-box" style="display: none">
                        @include('penilaian::components.proses-umpan-balik')
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
<style>
    textarea {
        border-color: #ced4da;
    }
    textarea:focus {
        outline: none !important;
        box-shadow: none !important;
    }
</style>
@stop

@push('js')
    @include('penilaian::evaluasi.script-evaluasi-detail')
@endpush
