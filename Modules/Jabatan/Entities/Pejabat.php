<?php

namespace Modules\Jabatan\Entities;

use Modules\Jabatan\Entities\Unit;
use Illuminate\Database\Eloquent\Model;
use Modules\Kepegawaian\Entities\Pegawai;
use Modules\Jabatan\Entities\Jabatan;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Cuti\Entities\TimKerja;

class Pejabat extends Model
{
    use HasFactory;

    protected $table = 'pejabats';

    protected $guarded = ['id'];

    public function pegawai(){
        return $this->belongsTo(Pegawai::class);
    }
    
    public function unit(){
        return $this->belongsTo(Unit::class);
    }
	
	public function jabatan(){
        return $this->belongsTo(Jabatan::class);
    }
	
	public static function cekMasaAktifJabatan(){
		$Pejabats = self::all();
		foreach($Pejabats as $pejabat){
			if($pejabat->selesai=="" || BCL_isExpired($pejabat->selesai)){
				$pejabat->status='Non Aktif';
				$pejabat->save();
			}
		}
	}

    public function timKerja()
    {
        return $this->hasMany(TimKerja::class, 'ketua_id', 'id');
    }

    
}
