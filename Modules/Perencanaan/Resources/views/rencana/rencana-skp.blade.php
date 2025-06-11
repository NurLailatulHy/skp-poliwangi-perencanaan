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
      <div class="card-body">
        <!-- Example single danger button -->
        <!-- <form> -->
        <div class="form-row d-flex justify-content-end">
          <div class="form-group ">
            <select id="inputState" class="form-control">
              <option selected>Tahun</option>
              <option>2023</option>
              <option>2024</option>
              <option>2025</option>
              <option>2026</option>
            </select>
          </div>
          <div class="form-group">
            <select id="inputState" class="form-control">
              <option selected>Periode</option>
              <option>01 Januari 2023 - 31 Desember 2023</option>
              <option>01 Januari 2024 - 31 Desember 2024</option>
              <option>01 Januari 2025 - 31 Desember 2025</option>
              <option>01 Januari 2026 - 31 Desember 2026</option>
            </select>
          </div>
          <div class="form-group col-md-2">
            <input type="text" class="form-control" id="inputAddress" placeholder="Unit Kerja">
          </div>
          <div class="form-group col-md-2">
            <input type="text" class="form-control" id="inputAddress" placeholder="Jabatan">
          </div>
          <div>
            <a href="#" class="btn btn-primary">SET</a>
          </div>
        </div>
        <!-- </form> -->
      </div>
    </div>
    <div class="card">
      <div class="card-body">
        <!-- <div class="d-flex justify-content-end p-2 border-bottom">
          <a href="#" class="btn btn-primary">Buat SKP</a>
        </div> -->
        <div class="d-flex justify-content-end p-2 border-bottom align-items-center gap-2" id="skp-container">
          <button id="skp-button" class="btn btn-primary">Buat SKP</button>
        </div>
        <table class="table table-bordered">
          <thead>
            <tr class="table-primary">
              <th scope="col">No</th>
              <th scope="col" colspan="2">Pegawai yang Dinilai</th>
              <th scope="col">No</th>
              <th scope="col" colspan="2">Pejabat Penilai Kinerja</th>
            </tr>
          </thead>
          <tbody>

            <tr>
              <td scope="row" class="col-sm-1">1</td>
              <td class="col-sm-2">Nama</td>
              <td class="col-sm-3"></td>
              <td scope="row" class="col-sm-1">1</td>
              <td class="col-sm-2">Nama</td>
              <td class="col-sm-3"></td>
            </tr>
            <tr>
              <td scope="row">2</td>
              <td>NIP</td>
              <td></td>
              <td scope="row">2</td>
              <td>NIP</td>
              <td></td>
            </tr>
            <tr>
              <td scope="row">3</td>
              <td>Pangkat/Gol</td>
              <td></td>
              <td scope="row">3</td>
              <td>Pangkat/Gol</td>
              <td></td>
            </tr>
            <tr>
              <td scope="row">4</td>
              <td>Jabatan</td>
              <td></td>
              <td scope="row">4</td>
              <td>Jabatan</td>
              <td></td>
            </tr>
            <tr>
              <td scope="row">5</td>
              <td>Unit Kerja</td>
              <td></td>
              <td scope="row">5</td>
              <td>Unit Kerja</td>
              <td></td>
            </tr>

          </tbody>
        </table>
        <div class="mt-3">
          <table class="table table-bordered">
            <thead>
              <tr class="table-primary">
                <th scope="row" class="col-sm-8" colspan="2">Hasil Kerja</th>
                <td class="col-sm-3"></td>
              </tr>
            </thead>
            <tbody>
              <tr>
                <th scope="row" colspan="2">A. Utama</th>
                <td class="col-sm-3">
                  <button type="button" class="btn btn-primary btn-sm">
                    <i class="fas fa-home"></i>
                  </button>
                  <button type="button" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus "></i>
                  </button>

                </td>
              </tr>
              <tr>
                <td scope="row" class="col-sm-1"></td>
                <td class="col-sm-8"></td>
                <td class="col-sm-3">
                  <button type="button" class="btn btn-success btn-sm">
                    <i class="fas fa-pen"></i>
                  </button>
                  <button type="button" class="btn btn-success btn-sm">
                    <i class="fas fa-star"></i>
                  </button>
                  <button type="button" class="btn btn-danger btn-sm">
                    <i class="fas fa-ban"></i>
                  </button>
                  <button type="button" class="btn btn-danger btn-sm">
                    <i class="fas fa-trash"></i>
                  </button>
              </tr>
              <tr>
                <td scope="row" class="col-sm-1"></td>
                <td class="col-sm-8"></td>
                <td class="col-sm-3"></td>
              </tr>
              <tr>
                <th scope="row" colspan="2">B. Tambahan</th>
                <td class="col-sm-3">
                  <button type="button" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus "></i>
                  </button>
                  <button type="button" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus "></i>
                  </button>
                  <button type="button" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus "></i>
                  </button>
                </td>
              </tr>
              <tr>
                <td scope="row" class="col-sm-1"></td>
                <td class="col-sm-8"></td>
                <td class="col-sm-3"></td>
              </tr>
              <tr>
                <td scope="row" class="col-sm-1"></td>
                <td class="col-sm-8"></td>
                <td class="col-sm-3"></td>
              </tr>
              <tr>
                <th scope="row" colspan="2">C. Lampiran</th>
                <td class="col-sm-3"></td>
              </tr>
              <tr>
                <th scope="row" colspan="2" class="col-sm-9">Dukugan Sumber Daya</th>
                <td class="col-sm-3">
                  <button type="button" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus "></i>
                  </button>
                </td>
              </tr>
              <tr>
                <td scope="row" class="col-sm-1"></td>
                <td class="col-sm-8"></td>
                <td class="col-sm-3"></td>
              </tr>
              <tr>
                <th scope="row" colspan="2" class="col-sm-9">Skema Pertanggung Jawaban</th>
                <td class="col-sm-3">
                  <button type="button" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus "></i>
                  </button>
                </td>
              </tr>
              <tr>
                <td scope="row" class="col-sm-1"></td>
                <td class="col-sm-8"></td>
                <td class="col-sm-3"></td>
              </tr>
              <tr>
                <th scope="row" colspan="2" class="col-sm-9">Konsekuensi</th>
                <td class="col-sm-3">
                  <button type="button" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus "></i>
                  </button>
                </td>
              </tr>
              <tr>
                <td scope="row" class="col-sm-1"></td>
                <td class="col-sm-8"></td>
                <td class="col-sm-3"></td>
              </tr>
            </tbody>

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