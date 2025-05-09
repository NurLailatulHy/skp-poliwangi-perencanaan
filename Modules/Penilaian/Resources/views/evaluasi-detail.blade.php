@extends('adminlte::page')

@section('title', 'Dasbor Simlitabmas')

@section('content_header')
    <h1 class="m-0 text-dark">Evaluasi SKP</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="w-100 d-flex justify-content-between align-items-center p-4">
                    @php
                        switch ($rencana->predikat_akhir) {
                            case 'Sangat Baik':
                            case 'Baik':
                                $badgeClass = 'badge-success';
                                break;
                            case 'Butuh Perbaikan':
                                $badgeClass = 'badge-danger';
                                break;
                            default:
                                $badgeClass = 'badge-light';
                                break;
                        }
                    @endphp
                    <span class="badge m-2 {{ $badgeClass }}" style="width: fit-content">{{ $rencana->predikat_akhir }}</span>
                    <button id="proses-umpan-balik-button" class="btn btn-primary ml-1 {{ $rencana->predikat_akhir == null ? 'd-none' : '' }}">Batalkan Evaluasi</button>
                </div>
                <div class="bg-white d-flex p-4">
                    <table class="table">
                        <thead>
                          <tr>
                            <th scope="col">No</th>
                            <th colspan="2" style="width: 50%;">Pegawai yang dinilai</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td>1</td>
                            <td>Nama</td>
                            <td>{{ $pegawai->nama }}</td>
                          </tr>
                          <tr>
                            <th scope="row">2</th>
                            <td>NIP</td>
                            <td>{{ $pegawai->nip }}</td>
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
                            <td style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                {{ $pegawai->anggota->timKerja->unit->nama }}
                            </td>
                          </tr>
                        </tbody>
                    </table>
                    <table class="table">
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
                                <td>{{ optional($pegawai->timKerjaAnggota[0]->parentUnit?->ketua?->pegawai)->nama ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th scope="row">2</th>
                                <td>NIP</td>
                                <td>{{ optional($pegawai->timKerjaAnggota[0]->parentUnit?->ketua?->pegawai)->nip ?? '-' }}</td>
                            </tr>
                            <tr>
                              <th scope="row">3</th>
                              <td>Pangkat / Gol</td>
                              <td>-</td>
                            </tr>
                            <tr>
                              <th scope="row">4</th>
                              <td>Jabatan</td>
                              <td>-</td>
                            </tr>
                            <tr>
                                <th scope="row">5</th>
                                <td>Unit Kerja</td>
                                <td style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                    {{ $pegawai->timKerjaAnggota[0]->parentUnit?->unit?->nama ?? '-' }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="bg-white p-4">
                    <form
                    {{-- id="umpanBalikForm" --}}
                    method="POST"
                    action="{{ url('/penilaian/evaluasi/proses-umpan-balik/' . $pegawai->username) }}"
                    >
                        @csrf
                        {{-- utama --}}
                        <table class="table mb-0" style="table-layout: auto; width: 100%;">
                            <thead>
                              <tr>
                                <th colspan="4">HASIL KERJA</th>
                              </tr>
                              <tr>
                                <th colspan="4">A. Utama</th>
                              </tr>
                            </thead>
                            <tbody>
                                @if ($rencana && $rencana->hasilKerja)
                                    @foreach ($rencana->hasilKerja as $index => $item)
                                        <tr>
                                            <th scope="row">{{ $index + 1 }}</th>
                                            <td>
                                                <p>{{ $item->deskripsi }}</p>
                                                <span>Ukuran keberhasilan / Indikator Kinerja Individu, dan Target :</span>
                                                <ul>
                                                    @foreach ($item->indikator as $indikator)
                                                        <li>{{ $indikator->deskripsi }}</li>
                                                    @endforeach
                                                </ul>
                                            </td>
                                            <td>
                                                <span>Realisasi :</span>
                                                <p>{{ $item['realisasi'] }}</p>
                                            </td>
                                            <td>
                                                <span>Umpan Balik :</span>
                                                <div class="input-group">
                                                    <input type="hidden" name="feedback[{{ $index }}][hasil_kerja_id]" value="{{ $item->id }}">
                                                    <select class="custom-select" id="umpan_bali_id" name="feedback[{{ $index }}][umpan_balik_predikat]">
                                                        @if ($item->umpan_balik_predikat == null)
                                                            @include('penilaian::components.predikat-dropdown', ['jenis' => 'Predikat'])
                                                        @else
                                                            <option value="{{ $item->umpan_balik_predikat }}">{{ $item->umpan_balik_predikat }}</option>
                                                        @endif
                                                    </select>
                                                    <div class="input-group-append">
                                                        <button class="btn btn-outline-secondary" type="button">
                                                            <i class="nav-icon fas fa-copy "></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                <textarea
                                                class="{{ ($item->umpan_balik_predikat !== null && $item->umpan_balik_deskripsi === null) ? 'd-none' : '' }}"
                                                {{ ($item->umpan_balik_predikat !== null && $item->umpan_balik_deskripsi !== null) ? 'disabled' : '' }}
                                                name="feedback[{{ $index }}][umpan_balik_deskripsi]"
                                                placeholder="{{ ($item->umpan_balik_predikat !== null && $item->umpan_balik_deskripsi !== null) ? $item->umpan_balik_deskripsi : '' }}"
                                                style="height: 150px; width: 100%; padding: 10px; overflow-y: auto; resize: vertical;"></textarea>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                        {{-- tambahan --}}
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
                        {{-- perilaku --}}
                        <table class="table mb-0" style="table-layout: auto; width: 100%;">
                            <thead>
                              <tr>
                                <th colspan="4">PERILAKU KERJA</th>
                              </tr>
                            </thead>
                            <tbody>
                                {{-- <tr>
                                    <td colspan="4">No data</td>
                                </tr> --}}
                                <tr>
                                    <th scope="row">1</th>
                                    <td>
                                        <p>
                                            Berorientasi Pelayanan
                                        </p>
                                        <ul>
                                            <li>Memahami dan memenuhi kebutuhan masyarakat</li>
                                            <li>Ramah, cekatan, solutif, dan dapat diandalkan</li>
                                            <li>Melakukan perbaikan tiada henti</li>
                                        </ul>
                                    </td>
                                    <td>
                                        <span>Ekspektasi Khusus Pimpinan:</span>
                                        <p>Memberikan pelayanan penilaian kinerja secara maksimal kepada pegawai</p>
                                    </td>
                                    <td>
                                        <span>Umpan Balik :</span>
                                        <div class="input-group">
                                            <input type="hidden" name="">
                                            <select class="custom-select" id="perilaku_kerja_id" name="perilaku_kerja">
                                                @include('penilaian::components.predikat-dropdown', ['jenis' => 'Predikat'])
                                            </select>
                                            <div class="input-group-append">
                                                <button class="btn btn-outline-secondary" type="button">
                                                    <i class="nav-icon fas fa-copy "></i>
                                                </button>
                                            </div>
                                        </div>
                                        <textarea style="height: 150px; width: 100%; padding: 10px; overflow-y: auto; resize: vertical;"></textarea>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        @php
                            $semuaSudahTerisi = $rencana->hasilKerja->every(function ($hasil) {
                                return !is_null($hasil->umpan_balik_predikat);
                            });
                        @endphp
                        @if (!session('success') && !$semuaSudahTerisi)
                            {{-- tombol proses umpan balik --}}
                            <div class="w-100 mt-4 d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary">Proses Umpan Balik</button>
                            </div>
                        @endif
                    </form>
                    @if(session('success') || $semuaSudahTerisi)
                        <div>@include('penilaian::components.proses-umpan-balik')</div>
                    @endif
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
