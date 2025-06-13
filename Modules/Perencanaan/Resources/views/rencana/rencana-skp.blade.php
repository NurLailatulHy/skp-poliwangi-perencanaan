@extends('adminlte::page')

@section('title', 'SKP Poliwangi')

@section('content_header')
<h1 class="m-0 text-dark">Sasaran Kinerja</h1>
@stop
@php

@endphp
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            @include('penilaian::components.set-periode')
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card">
            @php
            switch (true) {
            case 'Belum Dievaluasi':
            $badgeClass = 'badge-secondary';
            break;
            case 'Belum Ajukan Realisasi':
            $badgeClass = 'badge-danger';
            break;
            case 'Sudah Dievaluasi':
            $badgeClass = 'badge-success';
            break;
            default:
            $badgeClass = 'badge-secondary';
            break;
            }

            $hasilKerjaUtama = collect();
            $hasilKerjaTambahan = collect();

            if (!is_null($rencana) && !is_null($rencana->hasilKerja)) {
            $hasilKerjaUtama = $rencana->hasilKerja->filter(function($item) {
            return $item->jenis === 'utama';
            })->values();

            $hasilKerjaTambahan = $rencana->hasilKerja->filter(function($item) {
            return $item->jenis === 'tambahan';
            })->values();
            }
            @endphp
            <div class="card-body">
                <!-- <div class="d-flex justify-content-end p-2 border-bottom">
          <a href="#" class="btn btn-primary">Buat SKP</a>
        </div> -->

                <div class="d-flex justify-content-end p-2 border-bottom align-items-center gap-2" id="skp-container">
                    <button id="skp-button" class="btn btn-primary">Buat SKP</button>
                </div>

                @include('penilaian::components.atasan-bawahan-section', ['pegawai' => $pegawai])

                <div class="mt-3">

                    <table class="table mb-0" style="width: 100%;">
                        <thead>
                            <tr>
                                <th colspan="5">Hasil Kerja</th>
                            </tr>
                            <tr>
                                <th colspan="2" style="width: 90%">A. Utama</th>
                                <th colspan="1" style="width: 10%">
                                    <!-- @if (!is_null($rencana)) -->
                                    @include('perencanaan::rencana.modal-create-rencana')
                                    <!-- @endif -->
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($hasilKerjaUtama->count())
                            @foreach ($hasilKerjaUtama as $index => $item)
                            <tr>
                                <th style="width: 0%;" scope="row">{{ $index + 1 }}</th>
                                <td>
                                    <p>{{ $item['deskripsi'] }}</p>
                                    <span>Ukuran keberhasilan / Indikator Kinerja Individu, dan Target :</span>
                                    <ul>
                                        @foreach ($item->indikator as $indikator)
                                        <li>{{ $indikator['deskripsi'] }}</li>
                                        @endforeach
                                    </ul>
                                </td>
                                <td style="width: 10%;">
                                </td>
                            </tr>
                            @endforeach
                            @else
                            <tr>
                                <td colspan="5">-</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                    <table class="table mb-0" style="width: 100%;">
                        <thead>
                            <tr>
                                <th colspan="2" style="width: 90%">B. Tambahan</th>
                                <th colspan="1" style="width: 10%">
                                    <!-- @if (!is_null($rencana)) -->
                                    @include('penilaian::components.modal-create-hasil-kerja-tambahan')
                                    <!-- @endif -->
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                        <tbody>
                            @if ($hasilKerjaTambahan->count())
                            @foreach ($hasilKerjaTambahan as $indexTambahan => $item)
                            <tr>
                                <th style="width: 0%;" scope="row">{{ $indexTambahan + 1 }}</th>
                                <td>
                                    <p>{{ $item['deskripsi'] }}</p>
                                    <span>Ukuran keberhasilan / Indikator Kinerja Individu, dan Target :</span>
                                    <ul>
                                        @foreach ($item->indikator as $indikator)
                                        <li>{{ $indikator['deskripsi'] }}</li>
                                        @endforeach
                                    </ul>
                                </td>
                                <td style="width: 10%;">
                                </td>
                            </tr>
                            @endforeach

                            @else
                            <tr>
                                <td colspan="5">-</td>
                            </tr>
                            @endif
                        </tbody>
                        </tbody>
                    </table>
                    <table class="table mb-0" style="width: 100%;">
                        <thead>
                            <tr>
                                <th colspan="2" style="width: 90%;">C. Lampiran</th>
                                <th colspan="1" style="width: 10%">
                                    
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th colspan="2" style="width: 90%;" scope="row">Dukungan Sumber Daya</th>
                                <th colspan="1" style="width: 10%">
                                    <!-- @if (!is_null($rencana)) -->
                                    @include('perencanaan::rencana.modal-create-dukungan-sumber-daya')
                                    <!-- @endif -->
                                </th>
                            </tr>
                            <tr>
                                <td colspan="5">-</td>
                            </tr>
                            <tr>
                                <th colspan="2" style="width: 90%;" scope="row">Skema Pertanggung Jawaban</th>
                                <th colspan="1" style="width: 10%">
                                    <!-- @if (!is_null($rencana)) -->
                                    @include('perencanaan::rencana.modal-create-skema-pertanggung-jawaban')
                                    <!-- @endif -->
                                </th>
                            </tr>
                            <tr>
                                <td colspan="5">-</td>
                            </tr>
                            <tr>
                                <th colspan="2" style="width: 90%;" scope="row">Konsekuensi</th>
                                <th colspan="1" style="width: 10%">
                                    <!-- @if (!is_null($rencana)) -->
                                    @include('perencanaan::rencana.modal-create-konsekuensi')
                                    <!-- @endif -->
                                </th>
                            </tr>
                            <tr>
                                <td colspan="5">-</td>
                            </tr>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</div>
@stop

@section('css')
<link rel="stylesheet" href="/assets/css/admin_custom.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
@stop

@push('js')
<script>
    $(document).ready(function() {
        $('#example').DataTable({
            responsive: true,
            autoWidth: false
        });
    });

    // const tdStatus = document.querySelector('#td-status')
    // console.log(tdStatus.innerText)
</script>
@endpush