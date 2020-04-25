<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
class Mahasiswa extends Model
{
    protected $fillable=['user_id','dosen_id','nim','totaltak','gender','image'];
	const USER_PHOTO_URL = '/img';
	const USER_PHOTO_DEFAULT ='user.png';
    public function dosen(){
    	return $this->belongsTo(User::class);
    }

   public function getimageURLAttribute()
    {
        return asset($this::USER_PHOTO_URL).'/'.$this->image;
    }

    public function deleteimage()
    {
        if($this->image!=$this::USER_PHOTO_DEFAULT)
        {
            return Storage::disk('images')->delete($this->image);
        }
        return TRUE;
    }
}
