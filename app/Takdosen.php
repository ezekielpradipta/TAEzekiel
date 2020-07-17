<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Takdosen extends Model
{
    protected $table ='takdosens';
    protected $fillable = ['dosen_id','tak_id','poinminimum'];
    public function dosen(){
    	return $this->belongsTo(Dosen::class);
    }
    public function tak(){
    	return $this->belongsTo(TAK::class);
    }
}
