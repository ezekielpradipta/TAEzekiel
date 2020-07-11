<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\KategoriTAK;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
class KategoriTAKController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.kategoriTAK.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.kategoriTAK.create');
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
            'nama' => ['required', 'string', 'max:255','unique:kategoritaks,nama']
        ]);
        $data= $request->all();
        $kategoriTAK =KategoriTAK::create($data);
            if ($kategoriTAK) {
                return redirect()->route('admin.kategoriTAK.index')->with('success', 'Data Kategori TAK berhasil ditambahkan');
                } else {
                return redirect()->route('admin.kategoriTAK.index')->with('fail', 'Data Kategori TAK gagal ditambahkan');
                }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\KategoriTAK  $kategoriTAK
     * @return \Illuminate\Http\Response
     */
    public function show(KategoriTAK $kategoriTAK)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\KategoriTAK  $kategoriTAK
     * @return \Illuminate\Http\Response
     */
    public function edit(KategoriTAK $kategoriTAK)
    {
        return view('admin.kategoriTAK.edit', compact('kategoriTAK'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\KategoriTAK  $kategoriTAK
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, KategoriTAK $kategoriTAK)
    {
        $this->validate($request,[
            'nama' => ['required', 'string', 'max:255','unique:kategoritaks,nama']
        ]);
        DB::beginTransaction();
        try{
            $data = $request->all();
            $kategoriTAK->update($data);
            DB::commit();
        }catch (\Exception $e)
        {
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->with('fail','Data Kategori TAK gagal diubah. <br>'.$e->getMessage());
        }

        return redirect()->route('admin.kategoriTAK.index')->with('success', 'Data Kategori TAK berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\KategoriTAK  $kategoriTAK
     * @return \Illuminate\Http\Response
     */
    public function destroy(KategoriTAK $kategoriTAK)
    {
         DB::beginTransaction();
        try{
            $kategoriTAK->delete();
            DB::commit();
        }catch(\Exception $e)
        {
            DB::rollback();
            return redirect()->back()
                ->withInput()
                ->with('fail','Data Kategori TAK gagal dihapus. <br>'.$e->getMessage());
        }

        return redirect()->route('admin.kategoriTAK.index')->with('success', 'Data Kategori TAK berhasil dihapus');
    }
        public function data()
    {
        $kategoriTAK = KategoriTAK::latest()->get();

        return DataTables::of($kategoriTAK)
            ->addIndexColumn()
            ->addColumn('action', function ($kategoriTAK) {

                $form_start = '<form method="POST" class="form-delete" action="'.route('admin.kategoriTAK.destroy', $kategoriTAK->id).'">'.
                    csrf_field().method_field('DELETE');

                $action =  '<a href="'.route('admin.kategoriTAK.edit', $kategoriTAK->id).'" class="btn btn-success"><span class="fa fa-pencil">
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
