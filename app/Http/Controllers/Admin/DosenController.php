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
            'name' => ['required', 'string', 'max:255','unique:users'],
            'email' => ['required', 'string', 'regex:/st3telkom\.ac\.id|ittelkom-pwt\.ac\.id]/', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8','same:password_confirmation'],

        ]);
        $data =$request->all();
        $data['role']= User::USER_ROLE_DOSEN;
        $data['status']= User::USER_IS_ACTIVE;
        $user = User::create([
            'name' =>$data['name'],
            'username' =>$data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'password_text' => $data['password'],
            'role' => $data['role'],
            'status' => $data['status']
        ]);
        if($user){
            return redirect()->route('admin.dosen.index')->with('success', 'Akun berhasil disimpan');
        }   else{
            return redirect()->route('admin.dosen.index')->with('fail', 'Akun gagal disimpan');         
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
    public function edit(User $dosen)
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
    public function update(Request $request, User $dosen)
    {
        DB::beginTransaction();
        try{
            $data= $request->all();
            $dosen->update($data);
            DB::commit();
        } catch (\Exception $e){
            DB:rollback();
            return redirect()->route('admin.dosen.index')->withInput()->with('fail','Gagal dirubah.<br>'.$e->getMessage());
        }
        return redirect()->route('admin.dosen.index')->with('success', 'Data Dosen berhasil dirubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Dosen  $dosen
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $dosen)
    {
        DB::beginTransaction();
        try{
            $dosen->delete();
            DB::commit();
        }catch(\Exception $e){
            DB::rollback();
            return redirect()->route('admin.dosen.index')->withInput()->with('fail','Gagal dihapus.<br>'.$e->getMessage());
        }
                return redirect()->route('admin.products.index')->with('success', 'Data Dosen berhasil dihapus');
    }

    public function data(){
        $dosen =User::where('role','dosen')->get();
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
