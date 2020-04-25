<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Dosen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use App\User;
use Illuminate\Support\Facades\Hash;

class DosenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.dosen.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.dosen.create');
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
            'name' => ['required', 'string', 'max:255','unique:users,name'],
            'email' => ['required', 'string', 'regex:/st3telkom\.ac\.id|ittelkom-pwt\.ac\.id]/', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8','same:password_confirmation'],
            'image'=>['nullable','image','max:2048'],
            'nidn'=>['required','unique:dosens,nidn'],
        ]);
      
            $data =$request->all();
            $data['role']= User::USER_ROLE_DOSEN;
            $data['status']= User::USER_IS_ACTIVE;
            $data['password'] = bcrypt($request->password);
            $data['password_text'] = $request->password;
            $data['username']= $request->name;
            $data['nidn']=$request->nidn;
            if ($request->image) {
                $data['image']= $request->image->store('dosen','images');
            } else {
                $data['image']= Dosen::USER_PHOTO_DEFAULT;
            }
            
            $user = User::create($data);
  if ($user) {
        $user->dosen()->create($data);
        $user->dosen->save();
        return redirect()->route('admin.dosen.index')->with('success', 'Dosen berhasil ditambahkan');
    } else {
        return redirect()->route('admin.dosen.index')->with('fail', 'Dosen gagal ditambahkan');
    }
      
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Dosen  $dosen
     * @return \Illuminate\Http\Response
     */
    public function show(Dosen $dosen)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Dosen  $dosen
     * @return \Illuminate\Http\Response
     */
    public function edit(Dosen $dosen)
    {
        return view('admin.dosen.edit',compact('dosen'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Dosen  $dosen
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Dosen $dosen)
    {
        $this->validate($request,[
            'name' => ['required', 'string', 'max:255','exists:users,name'],
            'password' => ['required', 'string', 'min:8','same:password_confirmation'],
            'image' => 'nullable|image|max:2048',
            'email' => 'required|exists:users,email',

        ]);

        $data= $request->except(['password','image','_token','_method','nidn','password_confirmation']);
        $data['role']= User::USER_ROLE_DOSEN;
        $data['username']=$request->name;
        if($request->password)
        {
            $data['password'] = bcrypt($request->password);
            $data['password_text'] = $request->password;
        }
        if($request->image)
        {
            $data['image'] = $request->photo->store('dosen', 'images');
            $dosen->deletePhoto();
        }
        if($dosen->user()->update($data))
        {
            $dosen->update($data);
            $dosen->nidn = $request->nidn;
                
          

            $dosen->save();

            return redirect()->route('admin.dosen.index')->with('success', 'Dosen berhasil diubah');
        }else{
            return redirect()->route('admin.dosen.index')->with('fail', 'Dosen gagal diubah');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Dosen  $dosen
     * @return \Illuminate\Http\Response
     */
    public function destroy(Dosen $dosen)
    {
        DB::beginTransaction();
        try{
            $dosen->deleteimage();
            $dosen->user()->delete();
            DB::commit();
        }catch(\Exception $e){
            DB::rollback();
            return redirect()->route('admin.dosen.index')->withInput()->with('fail','Gagal dihapus.<br>'.$e->getMessage());
        }
                return redirect()->route('admin.dosen.index')->with('success', 'Data Dosen berhasil dihapus');
    }

    public function data(){
        $dosen =Dosen::with('user')->latest()->get();
        return Datatables::of($dosen)->addIndexColumn()
        ->addColumn('action',function($dosen){
            $mulai = '<form method="POST" action="'.route('admin.dosen.destroy',$dosen->id).' ">'.csrf_field().method_field('DELETE');
            $action = '<a href= "'.route('admin.dosen.edit', $dosen->id).'" class="btn btn-success">
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
        ->rawColumns(['action'])
        ->make(true);

    }
}
