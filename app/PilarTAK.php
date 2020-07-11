<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PilarTAK extends Model
{
    protected $table ='pilartaks';
    protected $primaryKey = 'id';
    protected $fillable = ['kategoritak_id', 'nama'];
    public function kategoritak(){
    	return $this->belongsTo(KategoriTAK::class);
    }
    public function kegiatantak(){
        return $this->hasMany(KegiatanTAK::class);
    }
}
