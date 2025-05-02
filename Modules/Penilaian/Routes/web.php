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

Route::group(['middleware' => ['auth', 'permission']], function() {
    Route::prefix('penilaian')->group(function() {
        Route::get('/', 'PenilaianController@index');
        Route::get('/evaluasi', 'EvaluasiController@evaluasi');
        Route::get('/evaluasi/{pegawaiId}/detail', 'EvaluasiController@evaluasiDetail');
        Route::get('/data-pegawai', 'EvaluasiController@index');
        Route::get('/predikat-kinerja', 'EvaluasiController@predikatKinerja');
        Route::prefix('realisasi')->group(function() {
            Route::get('/', 'PenilaianController@realisasi');
            Route::post('/update-realisasi/{id}', 'PenilaianController@updateRealisasi');
        });
        Route::prefix('rencana')->group(function() {
            Route::get('/', 'RencanaController@index');
            Route::post('/store', 'RencanaController@store');
            Route::post('/store-hasil-kerja/{id}', 'RencanaController@storeHasilKerja');
        });
        Route::get('/kinerja-organisasi', 'PenilaianController@kinerjaOrganisasi');
        Route::prefix('periode')->group(function() {
            Route::get('/', 'PeriodeController@index');
            Route::post('/store', 'PeriodeController@store');
        });
    });
});
