<?php

namespace Modules\Perencanaan\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Lampiran extends Model
{
    use HasFactory;

    protected $fillable = [];
    protected $table = 'skp_rencana_kerja';
    protected $guarded = ['id'];
    
    protected static function newFactory()
    {
        // return \Modules\Perencanaan\Database\factories\LampiranFactory::new();
    }
}
