<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TingkatTAK extends Model
{
    protected $table ='tingkattaks';
    protected $primaryKey = 'id';
    protected $fillable = ['kegiatantak_id', 'keterangan'];
    public function kegiatantak(){
    	return $this->belongsTo(KegiatanTAK::class);
    }
    public function tak(){
        return $this->hasMany(TAK::class);
    }
}
