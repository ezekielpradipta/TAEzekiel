<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TAK extends Model
{
    protected $table ='taks';
    protected $fillable = ['kegiatantak_id', 'score','kategoritak_id','pilartak_id','tingkattak_id'];
        public function tingkattak()
    {
        return $this->belongsTo(TingkatTAK::class);
    }
        public function kegiatantak()
    {
        return $this->belongsTo(KegiatanTAK::class);
    }
    public function takdosen(){
        return $this->hasMany(Takdosen::class);
    }
}
