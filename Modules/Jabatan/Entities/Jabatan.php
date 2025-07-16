<?php

namespace Modules\Jabatan\Entities;

use Modules\Jabatan\Entities\Unit;
use Illuminate\Database\Eloquent\Model;
use Modules\Jabatan\Entities\Pejabat;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Jabatan extends Model
{
    use HasFactory;

    protected $table = 'jabatans';

    protected $guarded = ['id'];

    public function pejabat(){
        return $this->hasMany(Pegawai::class);
    }
    
    
}
