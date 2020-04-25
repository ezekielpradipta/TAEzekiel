<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use App\Mahasiswa;
use Illuminate\Support\Facades\DB;
class TestController extends Controller
{
    public function index(){
    	$dosens =User::where('role','dosen')->get();
    	return view('test',compact('dosens'));
    }
    public function confirm(Request $request){

    $this->validate($request,[
    	'nim'=>['required','numeric','unique:mahasiswas,nim'],
    	'dosen_id'=>['required'],
    	'gender'=>['required'],
    	'user_id'=>['required','unique:mahasiswas,user_id'],
    	'image'=>['nullable','image','max:2048'],
    ]);
    	DB::beginTransaction();
    	try {
    		$data= $request->only(['nim','user_id','dosen_id','gender','image']);
    		$data['user_id'] = Auth::user()->id;
    		if($request->image)
            {
                $data['image'] = $request->image->store('users', 'images');
            }else
            {
                $data['image'] = Mahasiswa::USER_PHOTO_DEFAULT;
            }
            $mahasiswa = Mahasiswa::create($data);    		
            DB::commit();
    	} catch (Exception $e) {
    		DB::rollback();
    		 return redirect()->route('isiDataMahasiswa')->with('fail','Akun Dosen gagal ditambahkan.<br>'.$e->getMessage());
    	}
    	return redirect()->route('home')->with('success', 'Akun berhasil disimpan');

    }
}
