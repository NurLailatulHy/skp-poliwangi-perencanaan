<?php

namespace Modules\Penilaian\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RencanaKerja extends Model
{
    use HasFactory;
    protected $table = 'skp_rencana_kerja';
    protected $guarded = ['id'];

    public function hasilkerja() {
        return $this->hasMany(HasilKerja::class, 'rencana_id');
    }
}
