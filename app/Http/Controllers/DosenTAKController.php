<?php

namespace App\Http\Controllers;

use App\Takdosen;
use App\TAK;
use App\KategoriTAK;
use App\PilarTAK;
use App\KegiatanTAK;
use App\TingkatTAK;
use Illuminate\Http\Request;
use Response;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;
class DosenTAKController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $kategoritaks =KategoriTAK::pluck('nama','id');
        return view('dosen.tak.contohinput',
            ['kategoritaks' =>$kategoritaks]);
    }
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
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $theTAK = TAK::where("kategoritak_id",$request->kategoritak_id)
        ->where("pilartak_id",$request->pilartak_id)->where("kegiatantak_id",$request->kegiatantak_id)
        ->where("tingkattak_id",$request->tingkattak_id)->first();
      if ($theTAK === null){
          return abort(403,"Error dah");
      }
        
    $tak = new Takdosen;
    $tak->dosen_id  = Auth::user()->id;
    $tak->tak_id = $theTAK->id;
    $tak->deskripsi = $request->deskripsi;
    $tak->save();
    return back();
    //$tak->
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Takdosen  $takdosen
     * @return \Illuminate\Http\Response
     */
    public function show(Takdosen $takdosen)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Takdosen  $takdosen
     * @return \Illuminate\Http\Response
     */
    public function edit(Takdosen $takdosen)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Takdosen  $takdosen
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Takdosen $takdosen)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Takdosen  $takdosen
     * @return \Illuminate\Http\Response
     */
    public function destroy(Takdosen $takdosen)
    {
        //
    }
}
