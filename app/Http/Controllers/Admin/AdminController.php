<?php

namespace App\Http\Controllers\Admin;

use App\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $admin = Auth::user()->admin;
        return view('admin.profile.edit', compact('admin'));
    }

    public function update(Request $request) 
    {
        $admin = Admin::first();
      $this->validate($request,[
            'nama' => ['required', 'string', 'max:255','exists:admins,nama'],
            'password' => ['required', 'string', 'min:8','same:password_confirmation'],
            'image' => 'nullable|image|max:2048',
            'email' => 'required|exists:users,email',
        ]);

        $data= $request->except(['password','nama', 'image','_token','_method','nidn','password_confirmation']);
        $data['role']= User::USER_ROLE_ADMIN;
        $data['username']=$request->username;
        if($request->password)
        {
            $data['password'] = bcrypt($request->password);
            $data['password_text'] = $request->password;
        }

        if($admin->user()->update($data))
        {
            $admin->update($data);
            $admin->nidn = $request->nidn;
            $admin ->nama = $request->nama;
                if($request->image)
                    {
                        $admin->deleteImage();
                        $file = $request->file('image');
                        $filename = Str::slug($request->nama) . '.' . $file->getClientOriginalExtension();
                        $data['image']= $request->image->storeAs('admin',$filename,'images');
                        $admin->image = $data['image']; 
                    }
            $admin->save();

            return redirect()->route('admin.profile.index')->with('success', 'Admin berhasil diubah');
        }else{
            return redirect()->route('admin.profile.index')->with('fail', 'Admin gagal diubah');
        }

    }
}
