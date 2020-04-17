<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
class RegisterController extends Controller
{
    public function register(){
    	return view('auth.register');
    }
    public function daftar(Request $request){
    	$this->validate($request,[
            'name' => ['required', 'string', 'max:255','unique:users'],
       		'username' => ['required', 'string', 'max:255', 'unique:users'],
            'email' => ['required', 'string', 'regex:/st3telkom\.ac\.id|ittelkom-pwt\.ac\.id]/', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],

        ]);
        $data = $request->all();
        $data['role']= User::USER_ROLE_MHS;
        $data['status']= USER::USER_IS_NOT_ACTIVE; 
        $user =User::create([
            'name' => $data['name'],
            'username' =>$data['username'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'password_text' => $data['password'],
            'role' => $data['role'],
            'status' => $data['status']

        ]); 
        if($user){
        	return redirect('/')->with('success', 'Akun berhasil disimpan dan akan dilakukan validasi dan konfirmasi');
        } else{
        	return redirect('/')->with('fail', 'Akun gagal divalidasi');
        }

    }
    public function cekEmail(Request $request){
    	if($request->get('email')){
    		$email = $request->get('email');
    		$data =DB::table("users")->where('email',$email)->count();
    			if($data >0){
    				echo "not_unique";
    			} else {
    				echo "unique";
    			}
    	}
    }
    public function cekNama(Request $request){
    	if($request->get('name')){
    		$name = $request->get('name');
    		$data =DB::table("users")->where('name',$name)->count();
    			if($data >0){
    				echo "not_unique";
    			} else {
    				echo "unique";
    			}
    	}
    }
    public function cekUsername(Request $request){
    	if($request->get('username')){
    		$username = $request->get('username');
    		$data =DB::table("users")->where('username',$username)->count();
    			if($data >0){
    				echo "not_unique";
    			} else {
    				echo "unique";
    			}
    	}
    }  


}
