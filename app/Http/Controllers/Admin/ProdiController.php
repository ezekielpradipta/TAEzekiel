<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Prodi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
class ProdiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.prodi.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.prodi.create');
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
            'nama' => ['required', 'string', 'max:255']
        ]);
        $data= $request->all();
        $prodi =Prodi::create($data);
            if ($prodi) {
                return redirect()->route('admin.prodi.index')->with('success', 'Data Prodi berhasil ditambahkan');
                } else {
                return redirect()->route('admin.prodi.index')->with('fail', 'Data Prodi gagal ditambahkan');
                }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Prodi  $prodi
     * @return \Illuminate\Http\Response
     */
    public function show(Prodi $prodi)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Prodi  $prodi
     * @return \Illuminate\Http\Response
     */
    public function edit(Prodi $prodi)
    {
        return view('admin.prodi.edit', compact('prodi'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Prodi  $prodi
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Prodi $prodi)
    {
        $this->validate($request,[
            'nama' => ['required', 'string', 'max:255']
        ]);
        DB::beginTransaction();
        try{
            $data = $request->all();
            $prodi->update($data);
            DB::commit();
        }catch (\Exception $e)
        {
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->with('fail','Data Prodi gagal diubah. <br>'.$e->getMessage());
        }

        return redirect()->route('admin.prodi.index')->with('success', 'Data Prodi berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Prodi  $prodi
     * @return \Illuminate\Http\Response
     */
    public function destroy(Prodi $prodi)
    {
        DB::beginTransaction();
        try{
            $prodi->delete();
            DB::commit();
        }catch(\Exception $e)
        {
            DB::rollback();
            return redirect()->back()
                ->withInput()
                ->with('fail','Data Prodi gagal dihapus. <br>'.$e->getMessage());
        }

        return redirect()->route('admin.prodi.index')->with('success', 'Data Prodi berhasil dihapus');
    }
    public function data()
    {
        $prodi = Prodi::latest()->get();

        return DataTables::of($prodi)
            ->addIndexColumn()
            ->addColumn('action', function ($prodi) {

                $form_start = '<form method="POST" class="form-delete" action="'.route('admin.prodi.destroy', $prodi->id).'">'.
                    csrf_field().method_field('DELETE');

                $action =  '<a href="'.route('admin.prodi.edit', $prodi->id).'" class="btn btn-success"><span class="fa fa-pencil">
                </span></a>
                                    <button type="submit" onclick="return confirm(\'Apakah anda yakin untuk menghapus data ini ?\');" 
                                    class="btn btn-danger"><span class="fa fa-trash"></span></button>';
                $form_end = '</form>';

                return $form_start.$action.$form_end;
            })
            ->rawColumns(['action'])
            ->make(true);
    }
}
