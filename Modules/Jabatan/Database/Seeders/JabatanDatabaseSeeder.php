<?php

namespace Modules\Jabatan\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Jabatan\Database\Seeders\MenuModulJabatanTableSeeder;

class JabatanDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call(MenuModulJabatanTableSeeder::class);
    }
}
