<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Angkatan extends Model
{
	protected $primaryKey = 'id';
    protected $fillable = ['tahun'];
}
