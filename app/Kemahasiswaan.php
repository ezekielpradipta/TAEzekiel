<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
class Kemahasiswaan extends Model
{
    const USER_PHOTO_URL = '/img';
	const USER_PHOTO_DEFAULT ='user.png';
	protected $primaryKey = 'id';
	protected $fillable =['nidn','user_id','image','nama','slugImage'];


	public function getimageURLAttribute()
    {
        return asset($this::USER_PHOTO_URL).'/'.$this->image;
    }
    public function setSlugAttribute($value)
    {
        $this->attributes['slugImage'] = Str::slug($value); 
    }
    public function user(){
    	return $this->belongsTo(User::class);
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
