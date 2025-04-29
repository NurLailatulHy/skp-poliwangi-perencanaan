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
        Route::get('/rencana', 'PenilaianController@rencana');
        Route::get('/kinerja-organisasi', 'PenilaianController@kinerjaOrganisasi');
        Route::prefix('tim-kerja')->group(function() {
            Route::get('/', 'PenilaianController@timKerja');
            Route::post('/store', 'PenilaianController@storeTimKerja');
        });
    });
});
