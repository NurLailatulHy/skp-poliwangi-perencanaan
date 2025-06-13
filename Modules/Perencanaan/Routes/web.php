<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::prefix('perencanaan')->group(function () {
    Route::prefix('rencana-skp')->group(function () {
        Route::get('/', 'PerencanaanController@rencanaSkp');
        Route::get('/', 'PerencanaanController@index');
        Route::post('/store', 'PerencanaanController@store');
        Route::post('/store-hasil-kerja-utama/{id}', 'PerencanaanController@storeHasilKerjaUtama')->name('hasil-kerja.store');
        Route::post('/store-hasil-kerja-tambahan/{id}', 'PerencanaanController@storeHasilKerjaTambahan');
    });
    Route::prefix('verifikasi-skp')->group(function () {
        Route::get('/', 'VerifikasiController@verifikasiSkp');
    });
    Route::prefix('persetujuan-skp')->group(function () {
        Route::get('/', 'PersetujuanController@persetujuanSkp');
    });
    Route::prefix('unggah-skp')->group(function () {
        Route::get('/', 'UnggahController@unggahSkp');
        // Route::get('/create', 'UnggahController@create');
        // Route::post('/store', 'UnggahController@store');
    });
    Route::prefix('matriks-peran-hasil')->group(function() {
        Route::get('/', 'MatriksPeranHasilController@matriksperanhasil');
        Route::post('/store/{id}', 'MatriksPeranHasilController@storeCascading');
        Route::get('/anggota', 'MatriksPeranHasilController@getAnggota');
    });
});
