<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\TAK;
use App\KategoriTAK;
use App\PilarTAK;
use App\KegiatanTAK;
use App\TingkatTAK;
use Illuminate\Http\Request;
use Response;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
class TAKController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.tak.index');
    }
    public function data()
    {
        
        $taks = TAK::with('kegiatantak','tingkattak')->latest()->get();
        return DataTables::of($taks)
            ->addIndexColumn()
            ->addColumn('action', function ($taks) {

                $form_start = '<form method="POST" class="form-delete" action="'.route('admin.tak.destroy', $taks->id).'">'.
                    csrf_field().method_field('DELETE');

                $action =  '<a href="'.route('admin.tak.edit', $taks->id).'" class="btn btn-success"><span class="fa fa-pencil">
                </span></a>
                                    <button type="submit" onclick="return confirm(\'Apakah anda yakin untuk menghapus data ini ?\');" 
                                    class="btn btn-danger"><span class="fa fa-trash"></span></button>';
                $form_end = '</form>';

                return $form_start.$action.$form_end;
            })
            ->rawColumns(['action'])
            ->make(true);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function cekPilar($id){
        $pilartaks = DB::table("pilartaks")->where("kategoritak_id",$id)->pluck("nama","id");
        return json_encode($pilartaks);
    }
    public function cekKegiatan($id){
        $kegiatantaks = DB::table("kegiatantaks")->where("pilartak_id",$id)->pluck("nama","id");
        return json_encode($kegiatantaks);
    }
    public function cekTingkat($id){
        $tingkattaks = DB::table("tingkattaks")->where("kegiatantak_id",$id)->pluck("keterangan","id");
        return json_encode($tingkattaks);
    }

    public function create()
    {
       // $kategoritaks = KategoriTAK::all();
       // return view('admin.tak.create')->with('kategoritaks',$kategoritaks);
        $kategoritaks =KategoriTAK::pluck('nama','id');
        return view('admin.tak.create',
            ['kategoritaks' =>$kategoritaks]);
    }
public function getPilar($param){

      //GET THE ACCOUNT BASED ON TYPE

      $pilartaks = PilarTAK::where('kategoritak_id','=',$param)->get();

      //CREATE AN ARRAY 

      $options = array();      

      foreach ($pilartaks as $arrayForEach) {

                $options += array($arrayForEach->id => $arrayForEach->nama);                

            }
      return Response::json($options);
    }
public function getKegiatan($param){

      //GET THE ACCOUNT BASED ON TYPE

      $kegiatantaks = KegiatanTAK::where('pilartak_id','=',$param)->get();

      //CREATE AN ARRAY 

      $options = array();      

      foreach ($kegiatantaks as $arrayForEach) {

                $options += array($arrayForEach->id => $arrayForEach->nama);                

            }
      return Response::json($options);
    }
public function getTingkat($param){

      //GET THE ACCOUNT BASED ON TYPE

      $tingkattaks = TingkatTAK::where('kegiatantak_id','=',$param)->get();

      //CREATE AN ARRAY 

      $options = array();      

      foreach ($tingkattaks as $arrayForEach) {

                $options += array($arrayForEach->id => $arrayForEach->keterangan);                

            }
      return Response::json($options);
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
            'kategoritak_id'=>['required'],
            'pilartak_id'=>['required'],
            'kegiatantak_id'=>['required'],
            'tingkattak_id'=>['required'],
            'score'=>['required','integer'],
        ]);
        $data= $request->all();
        $taks =TAK::create($data);
            if ($taks) {
                return redirect()->route('admin.tak.index')->with('success', 'Tingkat TAK  berhasil ditambahkan');
                } else {
                return redirect()->route('admin.tak.index')->with('fail', 'Tingkat TAK  gagal ditambahkan');
                }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\TAK  $tAK
     * @return \Illuminate\Http\Response
     */
    public function show(TAK $tAK)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\TAK  $tAK
     * @return \Illuminate\Http\Response
     */
    public function edit(TAK $tak)
    {
          $kategoritaks = KategoriTAK::pluck('nama','id');
            return view('admin.tak.edit',['kategoritaks' =>$kategoritaks], compact('tak')); 
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\TAK  $tAK
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TAK $tAK)
    {
        $this->validate($request,[
            'kategoritak_id'=>['required'],
            'pilartak_id'=>['required'],
            'kegiatantak_id'=>['required'],
            'tingkattak_id'=>['required'],
            'score'=>['required','integer'],
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\TAK  $tAK
     * @return \Illuminate\Http\Response
     */
    public function destroy(TAK $taks)
    {
       DB::beginTransaction();
        try{
            $taks->delete();
            DB::commit();
        }catch(\Exception $e)
        {
            DB::rollback();
            return redirect()->back()
                ->withInput()
                ->with('fail','TAK gagal dihapus. <br>'.$e->getMessage());
        }

        return redirect()->route('admin.tak.index')->with('success', 'TAK berhasil dihapus');
    }
}
