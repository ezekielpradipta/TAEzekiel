<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\KegiatanTAK;
use Illuminate\Http\Request;
use App\PilarTAK;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
class KegiatanTAKController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.kegiatanTAK.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        $pilartaks = PilarTAK::orderBy('nama', 'ASC')->get();
        return view('admin.kegiatanTAK.create', compact('pilartaks'));
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
            
            'pilartak_id'=>['required'],
            'nama'=>['required'],
        ]);
        $data= $request->all();
        $kegiatanTAK =KegiatanTAK::create($data);
            if ($kegiatanTAK) {
                return redirect()->route('admin.kegiatanTAK.index')->with('success', 'Kegiatan TAK  berhasil ditambahkan');
                } else {
                return redirect()->route('admin.kegiatanTAK.index')->with('fail', 'Kegiatan TAK  gagal ditambahkan');
                }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\KegiatanTAK  $kegiatanTAK
     * @return \Illuminate\Http\Response
     */
    public function show(KegiatanTAK $kegiatanTAK)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\KegiatanTAK  $kegiatanTAK
     * @return \Illuminate\Http\Response
     */
    public function edit(KegiatanTAK $kegiatanTAK)
    {
         $pilartaks = PilarTAK::orderBy('nama', 'ASC')->get();
        return view('admin.kegiatanTAK.edit', compact('pilartaks','kegiatanTAK'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\KegiatanTAK  $kegiatanTAK
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, KegiatanTAK $kegiatanTAK)
    {
         $this->validate($request,[
            'pilartak_id'=>['required'],
            'nama'=>['required'],
        ]);
        DB::beginTransaction();
        try{
            $data = $request->all();
            $kegiatanTAK->update($data);
            DB::commit();
        }catch (\Exception $e)
        {
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->with('fail','Data Kegiatan TAK gagal diubah. <br>'.$e->getMessage());
        }

        return redirect()->route('admin.kegiatanTAK.index')->with('success', 'Data Kegiatan TAK berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\KegiatanTAK  $kegiatanTAK
     * @return \Illuminate\Http\Response
     */
    public function destroy(KegiatanTAK $kegiatanTAK)
    {
        DB::beginTransaction();
        try{
            $kegiatanTAK->delete();
            DB::commit();
        }catch(\Exception $e)
        {
            DB::rollback();
            return redirect()->back()
                ->withInput()
                ->with('fail','Data Kegiatan TAK gagal dihapus. <br>'.$e->getMessage());
        }

        return redirect()->route('admin.kegiatanTAK.index')->with('success', 'Data Kegiatan TAK berhasil dihapus');
    }
     public function data()
    {
        
        $kegiatanTAK = KegiatanTAK::with('pilartak')->latest()->get();
        return DataTables::of($kegiatanTAK)
            ->addIndexColumn()
            ->addColumn('action', function ($kegiatanTAK) {

                $form_start = '<form method="POST" class="form-delete" action="'.route('admin.kegiatanTAK.destroy', $kegiatanTAK->id).'">'.
                    csrf_field().method_field('DELETE');

                $action =  '<a href="'.route('admin.kegiatanTAK.edit', $kegiatanTAK->id).'" class="btn btn-success"><span class="fa fa-pencil">
                </span></a>
                                    <button type="submit" onclick="return confirm(\'Apakah anda yakin untuk menghapus data ini ?\');" 
                                    class="btn btn-danger"><span class="fa fa-trash"></span></button>';
                $form_end = '</form>';

                return $form_start.$action.$form_end;
            })
            ->editColumn('pilartak',function($kegiatanTAK){
            return   $kegiatanTAK->pilarTAK->kategoriTAK->nama .' - '.$kegiatanTAK->pilarTAK->nama ;
        })
            ->rawColumns(['action','pilartak'])
            ->make(true);
    }
}
