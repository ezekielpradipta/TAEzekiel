<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Takkumulatif extends Model
{
    protected $fillable = ['angkatan_id','prodi_id','poinminimum'];
   	public function angkatan()
    {
        return $this->belongsTo(Angkatan::class);
    }
    public function prodi()
    {
        return $this->belongsTo(Prodi::class);
    }
}
