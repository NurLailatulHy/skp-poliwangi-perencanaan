<?php

namespace Modules\Penilaian\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Modules\Pengaturan\Entities\Pegawai;
use Modules\Penilaian\Entities\Periode;
use Illuminate\Support\Facades\Auth;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    public function boot(){
        view::composer('penilaian::components.set-periode', function($view){
            $authUser = Auth::user();
            $pegawaiId = $authUser->pegawai->id;
            $pegawai = Pegawai::with([
                'timKerjaAnggota',
                'timKerjaAnggota.unit',
                'timKerjaAnggota.subUnits.unit',
                'timKerjaAnggota.parentUnit.unit',
            ])->where('id', '=', $pegawaiId)->first();

            $timKerja = $pegawai->timKerjaAnggota;
            $view->with([
                'periode' => Periode::all(),
                'pegawai' => $pegawai,
                'timKerja' => $timKerja
            ]);
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }
}
