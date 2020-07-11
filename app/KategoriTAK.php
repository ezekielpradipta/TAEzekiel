<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KategoriTAK extends Model
{
	protected $table ='kategoritaks';
    protected $primaryKey = 'id';
    protected $fillable = ['nama'];
    public function pilartak(){
        return $this->hasMany(PilarTAK::class);
    }
}
