<?php

namespace App\Http\Controllers\Admin;

use App\Angkatan;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
class AngkatanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.angkatan.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.angkatan.create');
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
            'tahun' => ['required', 'integer', 'digits:4','unique:angkatans,tahun']
        ]);
        $data= $request->all();
        $angkatan =Angkatan::create($data);
            if ($angkatan) {
                return redirect()->route('admin.angkatan.index')->with('success', 'Data Angkatan berhasil ditambahkan');
                } else {
                return redirect()->route('admin.angkatan.index')->with('fail', 'Data Angkatan gagal ditambahkan');
                }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Angkatan  $angkatan
     * @return \Illuminate\Http\Response
     */
    public function show(Angkatan $angkatan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Angkatan  $angkatan
     * @return \Illuminate\Http\Response
     */
    public function edit(Angkatan $angkatan)
    {
         return view('admin.angkatan.edit', compact('angkatan'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Angkatan  $angkatan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Angkatan $angkatan)
    {
        $this->validate($request,[
            'tahun' => ['required', 'integer', 'digits:4','unique:angkatans,tahun']
        ]);
        DB::beginTransaction();
        try{
            $data = $request->all();
            $angkatan->update($data);
            DB::commit();
        }catch (\Exception $e)
        {
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->with('fail','Data Angkatan gagal diubah. <br>'.$e->getMessage());
        }

        return redirect()->route('admin.angkatan.index')->with('success', 'Data Angkatan berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Angkatan  $angkatan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Angkatan $angkatan)
    {
        DB::beginTransaction();
        try{
            $angkatan->delete();
            DB::commit();
        }catch(\Exception $e)
        {
            DB::rollback();
            return redirect()->back()
                ->withInput()
                ->with('fail','Data Angkatan gagal dihapus. <br>'.$e->getMessage());
        }

        return redirect()->route('admin.angkatan.index')->with('success', 'Data Angkatan berhasil dihapus');
    }
    public function data()
    {
        $angkatan = Angkatan::latest()->get();

        return DataTables::of($angkatan)
            ->addIndexColumn()
            ->addColumn('action', function ($angkatan) {

                $form_start = '<form method="POST" class="form-delete" action="'.route('admin.angkatan.destroy', $angkatan->id).'">'.
                    csrf_field().method_field('DELETE');

                $action =  '<a href="'.route('admin.angkatan.edit', $angkatan->id).'" class="btn btn-success"><span class="fa fa-pencil">
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
