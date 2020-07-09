<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Kemahasiswaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class KemahasiswaanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.kemahasiswaan.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.kemahasiswaan.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         $this->validate($request,[
            'nama' => ['required', 'string', 'max:255','unique:kemahasiswaans,nama'],
            'email' => ['required', 'string', 'regex:/st3telkom\.ac\.id|ittelkom-pwt\.ac\.id]/', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8','same:password_confirmation'],
            'image'=>['nullable','image','max:2048'],
            'nidn'=>['required','unique:kemahasiswaans,nidn'],
        ]);
      
            $data =$request->all();

            $data['role']= User::USER_ROLE_KMS;
            $data['status']= User::USER_IS_ACTIVE;
            $data['password'] = bcrypt($request->password);
            $data['password_text'] = $request->password;
            $data['username']= $request->username;
            $data['nama']= $request->nama;
            $data['nidn']=$request->nidn;
            $data['slugImage']=$request->nama;

            if ($request->image) {
                $file = $request->file('image');
                $filename = Str::slug($request->nama) . '.' . $file->getClientOriginalExtension();
                $data['image']= $request->image->storeAs('kemahasiswaan',$filename,'images');
            } else {
                $data['image']= Kemahasiswaan::USER_PHOTO_DEFAULT;
            }
            
            
            $user = User::create($data);
              if ($user) {
                    $user->kemahasiswaan()->create($data);
                    $user->kemahasiswaan->save();
                    return redirect()->route('admin.kemahasiswaan.index')->with('success', 'Kemahasiswaan berhasil ditambahkan');
                } else {
                    return redirect()->route('admin.kemahasiswaan.index')->with('fail', 'Kemahasiswaan gagal ditambahkan');
                }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Kemahasiswaan  $kemahasiswaan
     * @return \Illuminate\Http\Response
     */
    public function show(Kemahasiswaan $kemahasiswaan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Kemahasiswaan  $kemahasiswaan
     * @return \Illuminate\Http\Response
     */
    public function edit(Kemahasiswaan $kemahasiswaan)
    {
        return view('admin.kemahasiswaan.edit',compact('kemahasiswaan'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Kemahasiswaan  $kemahasiswaan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Kemahasiswaan $kemahasiswaan)
    {
            $this->validate($request,[
            'nama' => ['required', 'string', 'max:255','exists:kemahasiswaans,nama'],
            'password' => ['required', 'string', 'min:8','same:password_confirmation'],
            'image' => 'nullable|image|max:2048',
            'email' => 'required|exists:users,email',
        ]);

        $data= $request->except(['password','nama', 'image','_token','_method','nidn','password_confirmation']);
        $data['role']= User::USER_ROLE_KMS;
        $data['username']=$request->username;
        if($request->password)
        {
            $data['password'] = bcrypt($request->password);
            $data['password_text'] = $request->password;
        }
        if($request->image)
        {
            $file = $request->file('image');
            $filename = Str::slug($request->nama) . '.' . $file->getClientOriginalExtension();
            $data['image']= $request->image->storeAs('kemahasiswaan',$filename,'images');
            $kemahasiswaan->deletePhoto();
        }
        if($kemahasiswaan->user()->update($data))
        {
            $kemahasiswaan->update($data);
            $kemahasiswaan->nidn = $request->nidn;
            $kemahasiswaan ->nama = $request->nama;
            $kemahasiswaan->save();

            return redirect()->route('admin.kemahasiswaan.index')->with('success', 'Kemahasiswaan berhasil diubah');
        }else{
            return redirect()->route('admin.kemahasiswaan.index')->with('fail', 'Kemahasiswaan gagal diubah');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Kemahasiswaan  $kemahasiswaan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Kemahasiswaan $kemahasiswaan)
    {
        DB::beginTransaction();
        try{
            $kemahasiswaan->deleteimage();
            $kemahasiswaan->user()->delete();
            DB::commit();
        }catch(\Exception $e){
            DB::rollback();
            return redirect()->route('admin.kemahasiswaan.index')->withInput()->with('fail','Data Kemahasiswaan Gagal dihapus.<br>'.$e->getMessage());
        }
                return redirect()->route('admin.kemahasiswaan.index')->with('success', 'Data Kemahasiswaan berhasil dihapus');
    }
    public function data(){
        $kms =Kemahasiswaan::with('user')->latest()->get();
        return Datatables::of($kms)->addIndexColumn()
        ->addColumn('action',function($kms){
            $mulai = '<form method="POST" action="'.route('admin.kemahasiswaan.destroy',$kms->id).' ">'.csrf_field().method_field('DELETE');
            $action = '<a href= "'.route('admin.kemahasiswaan.edit', $kms->id).'" class="btn btn-success">
                    <span class="fa fa-pencil"></span>
                    </a> 
                    <button type="submit" onclick="return confirm(\'Apakah anda yakin untuk menghapus data ini ?\');" class="btn btn-danger" >
                    <span class="fa fa-trash">
                    </span>
                    </button>
                    ';

            $selesai ='</form>';
            return $mulai.$action.$selesai;
        })
        ->editColumn('nama',function($kms){
            return '<img style="height: 50px; width: 80px; margin-right: 10px;" src="'.$kms->image_url.'" />'
                    .$kms->nama;
        })
        ->rawColumns(['action','nama'])
        ->make(true);

    }
}
