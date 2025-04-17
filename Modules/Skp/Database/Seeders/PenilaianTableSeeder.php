<?php

namespace Modules\Skp\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Models\Core\Menu;

class PenilaianTableSeeder extends Seeder
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
        Menu::where('modul', 'Skp')->delete();
        $menu =  Menu::create([
            'modul' => 'Skp',
            'label' => 'Penilaian',
            'url' => '',
            'can' => serialize(['terdaftar']),
            'icon' => 'fab fa-playstation',
            'urut' => 1,
            'parent_id' => 0,
            'active' => '',
        ]);
        Menu::create([
            'modul' => 'Skp',
            'label' => 'Penilaian Bulanan',
            'url' => 'skp/penilaian/penilaian-bulanan',
            'can' => serialize(['terdaftar']),
            'icon' => 'fas fa-home',
            'urut' => 1,
            'parent_id' => $menu->id,
            'active' => serialize(['skp/penilaian/penilaian-bulanan', 'skp/penilaian/penilaian-bulanan*']),
        ]);
        Menu::create([
            'modul' => 'Skp',
            'label' => 'Evaluasi SKP',
            'url' => 'skp/penilaian/evaluasi',
            'can' => serialize(['terdaftar']),
            'icon' => 'fas fa-home',
            'urut' => 1,
            'parent_id' => $menu->id,
            'active' => serialize(['skp/penilaian/evaluasi', 'skp/penilaian/evaluasi*']),
        ]);
    }
}
