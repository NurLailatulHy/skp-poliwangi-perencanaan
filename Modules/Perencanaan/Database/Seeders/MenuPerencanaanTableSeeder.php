<?php

namespace Modules\Perencanaan\Database\Seeders;

use App\Models\Core\Menu;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class MenuPerencanaanTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        // $this->call("OthersTableSeeder");
        Menu::where('modul', 'Perencanaan')->delete();
        $menu =  Menu::create([
            'modul' => 'Perencanaan',
            'label' => 'Perencanaan SKP',
            'url' => '',
            // 'can' => serialize(['pimpinan', 'pejabat', 'sekretaris', 'kepegawaian', 'dosen']),
            'can' => serialize(['terdaftar', 'operator', 'admin']),
            'icon' => 'fas fa-clipboard',
            'urut' => 1,
            'parent_id' => 0,
            'active' => '',
        ]);
        Menu::create([
            'modul' => 'Perencanaan',
            'label' => 'Rencana SKP',
            'url' => 'perencanaan/rencana-skp',
            // 'can' => serialize(['pimpinan', 'pejabat', 'sekretaris', 'kepegawaian', 'dosen']),
            'can' => serialize(['terdaftar', 'pegawai']),
            'icon' => 'far fa-circle',
            'urut' => 1,
            'parent_id' => $menu->id,
            'active' => serialize(['perencanaan/rencana-skp', 'perencanaan/rencana-skp*']),
        ]);
        Menu::create([
            'modul' => 'Perencanaan',
            'label' => 'Unggah SKP',
            'url' => 'perencanaan/unggah-skp',
            // 'can' => serialize(['pimpinan', 'pejabat', 'sekretaris', 'kepegawaian', 'dosen']),
            'can' => serialize(['terdaftar']),
            'icon' => 'far fa-circle',
            'urut' => 1,
            'parent_id' => $menu->id,
            'active' => serialize(['perencanaan/unggah-skp', 'perencanaan/unggah-skp*']),
        ]);
        Menu::create([
            'modul' => 'Perencanaan',
            'label' => 'Verifikasi SKP',
            'url' => 'perencanaan/verifikasi-skp',
            // 'can' => serialize(['pimpinan', 'pejabat', 'sekretaris', 'kepegawaian', 'dosen']),
            'can' => serialize(['admin']),
            'icon' => 'far fa-circle',
            'urut' => 1,
            'parent_id' => $menu->id,
            'active' => serialize(['perencanaan/verifikasi-skp', 'perencanaan/verifikasi-skp*']),
        ]);
        Menu::create([
            'modul' => 'Perencanaan',
            'label' => 'Persetujuan SKP',
            'url' => 'perencanaan/persetujuan-skp',
            // 'can' => serialize(['pimpinan', 'pejabat', 'sekretaris', 'kepegawaian', 'dosen']),
            'can' => serialize(['operator']),
            'icon' => 'far fa-circle',
            'urut' => 1,
            'parent_id' => $menu->id,
            'active' => serialize(['perencanaan/persetujuan-skp', 'perencanaan/persetujuan-skp*']),
        ]);
        Menu::create([
            'modul' => 'Perencanaan',
            'label' => 'Matriks Peran Hasil',
            'url' => 'perencanaan/matriks-peran-hasil',
            // 'can' => serialize(['pimpinan', 'pejabat', 'sekretaris', 'kepegawaian', 'dosen']),
            'can' => serialize(['operator']),
            'icon' => 'far fa-circle',
            'urut' => 1,
            'parent_id' => $menu->id,
            'active' => serialize(['perencanaan/matriks-peran-hasil', 'perencanaan/matriks-peran-hasil*']),
        ]);
    }
}
