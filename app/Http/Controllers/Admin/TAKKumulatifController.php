<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Takkumulatif;
use Illuminate\Http\Request;
use App\Angkatan;
use App\Prodi;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
class TAKKumulatifController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       return view('admin.takkumulatif.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $prodis = Prodi::orderBy('nama', 'ASC')->get();
        $angkatans = Angkatan::orderBy('tahun', 'ASC')->get();
        return view('admin.takkumulatif.create', compact('prodis','angkatans'));
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
            'poinminimum' => ['required', 'integer'],
            'angkatan_id'=>['required'],
            'prodi_id'=>['required'],
        ]);
        $data= $request->all();
        $takkumulatif =Takkumulatif::create($data);
            if ($takkumulatif) {
                return redirect()->route('admin.takkumulatif.index')->with('success', 'TAK Kumulatif berhasil ditambahkan');
                } else {
                return redirect()->route('admin.takkumulatif.index')->with('fail', 'TAK Kumulatif gagal ditambahkan');
                }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\takkumulatif  $takkumulatif
     * @return \Illuminate\Http\Response
     */
    public function show(takkumulatif $takkumulatif)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\takkumulatif  $takkumulatif
     * @return \Illuminate\Http\Response
     */
    public function edit(takkumulatif $takkumulatif)
    {
                $prodis = Prodi::orderBy('nama', 'ASC')->get();
        $angkatans = Angkatan::orderBy('tahun', 'ASC')->get();
        return view('admin.takkumulatif.edit', compact('prodis','angkatans','takkumulatif'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\takkumulatif  $takkumulatif
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, takkumulatif $takkumulatif)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\takkumulatif  $takkumulatif
     * @return \Illuminate\Http\Response
     */
    public function destroy(takkumulatif $takkumulatif)
    {
        DB::beginTransaction();
        try{
            $takkumulatif->delete();
            DB::commit();
        }catch(\Exception $e)
        {
            DB::rollback();
            return redirect()->back()
                ->withInput()
                ->with('fail','TAK Kumulatif gagal dihapus. <br>'.$e->getMessage());
        }

        return redirect()->route('admin.takkumulatif.index')->with('success', 'TAK Kumulatif berhasil dihapus');
    }
    public function data()
    {
        
        $takkumulatif = Takkumulatif::with('prodi','angkatan')->latest()->get();
        return DataTables::of($takkumulatif)
            ->addIndexColumn()
            ->addColumn('action', function ($takkumulatif) {

                $form_start = '<form method="POST" class="form-delete" action="'.route('admin.takkumulatif.destroy', $takkumulatif->id).'">'.
                    csrf_field().method_field('DELETE');

                $action =  '<a href="'.route('admin.takkumulatif.edit', $takkumulatif->id).'" class="btn btn-success"><span class="fa fa-pencil">
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
