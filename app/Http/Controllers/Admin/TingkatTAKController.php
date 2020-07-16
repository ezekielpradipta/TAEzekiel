<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\TingkatTAK;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use App\KegiatanTAK;
class TingkatTAKController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
 public function index(Request $request)
    {
     if(request()->ajax())
     {
       if($request->kegiatantaks)
      {
       $tingkatTAK = DB::table('tingkattaks')
        ->join('kegiatantaks', 'kegiatantaks.id', '=', 'tingkattaks.kegiatantak_id')
         ->select('tingkattaks.id','tingkattaks.keterangan','kegiatantaks.nama')
         ->where('tingkattaks.kegiatantak_id', $request->kegiatantaks);
       // $pilartak_id = $request->pilartaks;
       // $kegiatanTAK = KegiatanTAK::with('pilartaks')->where('pilartak_id',$pilartak_id)->first();
      }
      
      else
      {
        $tingkatTAK = DB::table('tingkattaks')
        ->join('kegiatantaks', 'kegiatantaks.id', '=', 'tingkattaks.kegiatantak_id')
         ->select('tingkattaks.id','tingkattaks.keterangan','kegiatantaks.nama');
       // $kegiatanTAK = KegiatanTAK::with('pilartaks')->latest()->get();
      }
      return datatables()->of($tingkatTAK)
            ->addIndexColumn()
            ->addColumn('action', function ($tingkatTAK) {

                $form_start = '<form method="POST" class="form-delete" action="'.route('admin.tingkatTAK.destroy', $tingkatTAK->id).'">'.
                    csrf_field().method_field('DELETE');

                $action =  '<a href="'.route('admin.tingkatTAK.edit', $tingkatTAK->id).'" class="btn btn-success"><span class="fa fa-pencil">
                </span></a>
                                    <button type="submit" onclick="return confirm(\'Apakah anda yakin untuk menghapus data ini ?\');" 
                                    class="btn btn-danger"><span class="fa fa-trash"></span></button>';
                $form_end = '</form>';

                return $form_start.$action.$form_end;
            })
            ->rawColumns(['action'])
            ->make(true);

     }
       $kegiatantaks = KegiatanTAK::orderBy('nama', 'ASC')->get();
     return view('admin.tingkatTAK.index', compact('kegiatantaks'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       $kegiatantaks = KegiatanTAK::orderBy('nama', 'ASC')->get();
     return view('admin.tingkatTAK.create', compact('kegiatantaks'));
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
            
            'kegiatantak_id'=>['required'],
            'keterangan'=>['required'],
        ]);
        $data= $request->all();
        $tingkatTAK =TingkatTAK::create($data);
            if ($tingkatTAK) {
                return redirect()->route('admin.tingkatTAK.index')->with('success', 'Tingkat TAK  berhasil ditambahkan');
                } else {
                return redirect()->route('admin.tingkatTAK.index')->with('fail', 'Tingkat TAK  gagal ditambahkan');
                }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\TingkatTAK  $tingkatTAK
     * @return \Illuminate\Http\Response
     */
    public function show(TingkatTAK $tingkatTAK)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\TingkatTAK  $tingkatTAK
     * @return \Illuminate\Http\Response
     */
    public function edit(TingkatTAK $tingkatTAK)
    {
        $kegiatantaks = KegiatanTAK::orderBy('nama', 'ASC')->get();
        return view('admin.tingkatTAK.edit', compact('kegiatantaks','tingkatTAK'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\TingkatTAK  $tingkatTAK
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TingkatTAK $tingkatTAK)
    {
        $this->validate($request,[
            'kegiatantak_id'=>['required'],
            'keterangan'=>['required'],
        ]);
        DB::beginTransaction();
        try{
            $data = $request->all();
            $tingkatTAK->update($data);
            DB::commit();
        }catch (\Exception $e)
        {
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->with('fail','Data Tingkat TAK gagal diubah. <br>'.$e->getMessage());
        }

        return redirect()->route('admin.tingkatTAK.index')->with('success', 'Data Tingkat TAK berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\TingkatTAK  $tingkatTAK
     * @return \Illuminate\Http\Response
     */
    public function destroy(TingkatTAK $tingkatTAK)
    {
       DB::beginTransaction();
        try{
            $tingkatTAK->delete();
            DB::commit();
        }catch(\Exception $e)
        {
            DB::rollback();
            return redirect()->back()
                ->withInput()
                ->with('fail','Data Tingkat TAK gagal dihapus. <br>'.$e->getMessage());
        }

        return redirect()->route('admin.tingkatTAK.index')->with('success', 'Data Tingkat TAK berhasil dihapus');
    }
}
