<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\PilarTAK;
use Illuminate\Http\Request;
use App\KategoriTAK;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
class PilarTAKController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      return view('admin.pilarTAK.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $kategoritaks = KategoriTAK::orderBy('nama', 'ASC')->get();
         return view('admin.pilarTAK.create', compact('kategoritaks'));
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
            'nama'=>['required'],
        ]);
        $data= $request->all();
        $pilarTAK =PilarTAK::create($data);
            if ($pilarTAK) {
                return redirect()->route('admin.pilarTAK.index')->with('success', 'Pilar TAK  berhasil ditambahkan');
                } else {
                return redirect()->route('admin.pilarTAK.index')->with('fail', 'Pilar TAK  gagal ditambahkan');
                }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\PilarTAK  $pilarTAK
     * @return \Illuminate\Http\Response
     */
    public function show(PilarTAK $pilarTAK)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\PilarTAK  $pilarTAK
     * @return \Illuminate\Http\Response
     */
    public function edit(PilarTAK $pilarTAK)
    {
        $kategoritaks = KategoriTAK::orderBy('nama', 'ASC')->get();
        return view('admin.pilarTAK.edit', compact('kategoritaks','pilarTAK'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\PilarTAK  $pilarTAK
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PilarTAK $pilarTAK)
    {
        $this->validate($request,[
            'kategoritak_id'=>['required'],
            'nama'=>['required'],
        ]);
        DB::beginTransaction();
        try{
            $data = $request->all();
            $pilarTAK->update($data);
            DB::commit();
        }catch (\Exception $e)
        {
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->with('fail','Data Pilar TAK gagal diubah. <br>'.$e->getMessage());
        }

        return redirect()->route('admin.pilarTAK.index')->with('success', 'Data Pilar TAK berhasil diubah');
    }
    

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\PilarTAK  $pilarTAK
     * @return \Illuminate\Http\Response
     */
    public function destroy(PilarTAK $pilarTAK)
    {
          DB::beginTransaction();
        try{
            $pilarTAK->delete();
            DB::commit();
        }catch(\Exception $e)
        {
            DB::rollback();
            return redirect()->back()
                ->withInput()
                ->with('fail','Data Pilar TAK gagal dihapus. <br>'.$e->getMessage());
        }

        return redirect()->route('admin.pilarTAK.index')->with('success', 'Data Pilar TAK berhasil dihapus');
    }
        public function data()
    {
        
        $pilarTAK = PilarTAK::with('kategoritak')->latest()->get();
        return DataTables::of($pilarTAK)
            ->addIndexColumn()
            ->addColumn('action', function ($pilarTAK) {

                $form_start = '<form method="POST" class="form-delete" action="'.route('admin.pilarTAK.destroy', $pilarTAK->id).'">'.
                    csrf_field().method_field('DELETE');

                $action =  '<a href="'.route('admin.pilarTAK.edit', $pilarTAK->id).'" class="btn btn-success"><span class="fa fa-pencil">
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
