<?php

namespace Modules\Penilaian\Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Core\Menu;
use Illuminate\Database\Eloquent\Model;

class MenuPenilaianTableSeeder extends Seeder
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
        Menu::where('modul', 'Penilaian')->delete();
        $menu =  Menu::create([
            'modul' => 'Penilaian',
            'label' => 'Penilaian SKP',
            'url' => '',
            // 'can' => serialize(['pimpinan', 'pejabat', 'sekretaris', 'kepegawaian', 'dosen']),
            'can' => serialize(['*']),
            'icon' => 'fab fa-playstation',
            'urut' => 1,
            'parent_id' => 0,
            'active' => '',
        ]);
        Menu::create([
            'modul' => 'Penilaian',
            'label' => 'Evaluasi',
            'url' => 'penilaian/evaluasi',
            // 'can' => serialize(['pimpinan', 'pejabat', 'sekretaris', 'kepegawaian', 'dosen']),
            'can' => serialize(['*']),
            'icon' => 'fas fa-home',
            'urut' => 1,
            'parent_id' => $menu->id,
            'active' => serialize(['penilaian/evaluasi', 'penilaian/evaluasi*']),
        ]);
    }
}
