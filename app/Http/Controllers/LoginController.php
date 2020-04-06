<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Session;
class LoginController extends Controller
{
      public function login(){
        return view('auth.login');
    }
       public function ceklogin(Request $request){
    	$this->validate($request,[
    	'username' => ['required', 'string'],
    	'password' => ['required','string', 'min:6'],
    	]);
    	//bisa login via email/ username
    	$loginType = filter_var($request->username, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

    	$login =[
    		$loginType => $request->username,
    		'password' => $request->password
    	];
    	
    	if (Auth::attempt($login)){
    		return redirect()->route('home');
    	}
    	return redirect()->route('login')->with(['error'=>'Email atau password yang dimasukan salah']);
	}
	    public function logout(){
        Auth::logout();
        Session::flush();
        return redirect('/');
    }
}