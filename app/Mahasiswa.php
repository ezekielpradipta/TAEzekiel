<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
class Mahasiswa extends Model
{
    protected $fillable=['user_id','dosen_id','prodi_id','angkatan_id','nim','kelas','gender','image','slugImage'];
	const USER_PHOTO_URL = '/img';
	const USER_PHOTO_DEFAULT ='user.png';
    public function dosen(){
    	return $this->belongsTo(Dosen::class);
    }
    public function user(){
    	return $this->belongsTo(User::class);
    }
    public function prodi(){
    	return $this->belongsTo(Prodi::class);
    }
    public function angkatan(){
    	return $this->belongsTo(Angkatan::class);
    }
   public function getimageURLAttribute()
    {
        return asset($this::USER_PHOTO_URL).'/'.$this->image;
    }
    public function setSlugAttribute($value)
    {
        $this->attributes['slugImage'] = Str::slug($value); 
    }
    public function deleteImage()
    {
        if($this->image!=$this::USER_PHOTO_DEFAULT)
        {
            return Storage::disk('images')->delete($this->image);
        }
        return TRUE;
    }
}
