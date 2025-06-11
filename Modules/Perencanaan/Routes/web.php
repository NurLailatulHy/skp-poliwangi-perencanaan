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
    Route::get('/', 'PerencanaanController@index');
    Route::get('/rencana-skp', 'PerencanaanController@rencanaSkp');
    
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
});
