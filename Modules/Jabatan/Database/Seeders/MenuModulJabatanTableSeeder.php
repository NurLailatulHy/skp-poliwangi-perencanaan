<?php

namespace Modules\Jabatan\Database\Seeders;

use App\Models\Core\Menu;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class MenuModulJabatanTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        Menu::where('modul', 'Jabatan')->delete();
        $menu = Menu::create([
            'modul' => 'Jabatan',
            'label' => 'Jabatan',
            'url' => '',
            'can' => serialize(['admin']),
            'icon' => 'fas fa-briefcase',
            'urut' => 1,
            'parent_id' => 0,
            'active' => serialize(['jabatan']),
        ]);
        if ($menu) {
            Menu::create([
                'modul' => 'Jabatan',
                'label' => 'Data Jabatan',
                'url' => 'jabatan/data-jabatan',
                'can' => serialize(['admin']),
                'icon' => 'far fa-circle',
                'urut' => 1,
                'parent_id' => $menu->id,
                'active' => serialize(['jabatan/data-jabatan', 'data-jabatan*']),
            ]);
            

            // $this->call("OthersTableSeeder");
        }
    }
}
