<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
class Dosen extends Model
{
    const USER_PHOTO_URL = '/img';
	const USER_PHOTO_DEFAULT ='user.png';
	protected $primaryKey = 'id';
	protected $fillable =['nidn','user_id','image'];

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
    public function user(){
    	return $this->belongsTo(User::class);
    }
}
