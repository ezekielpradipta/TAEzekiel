<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KegiatanTAK extends Model
{
    protected $table ='kegiatantaks';
    protected $primaryKey = 'id';
    protected $fillable = ['pilartak_id', 'nama'];
    public function pilartak(){
    	return $this->belongsTo(PilarTAK::class);
    }
    public function tak(){
        return $this->hasMany(TAK::class);
    }
}
