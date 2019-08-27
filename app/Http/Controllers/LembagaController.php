<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Lembaga_survey;
use App\Provinsi;
use App\Kabupaten;
use App\Kecamatan;

class LembagaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = Lembaga_survey::with('provinsi','kabupaten','kecamatan')->get();
        return view('admin.lembaga.index', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //$lembaga_survey=Lembaga_survey::where('status','aktif')->get();
        $provinsi=Provinsi::all();
        $kabupaten=Kabupaten::all();
        $kecamatan=Kecamatan::all();
        $provinsi_untuk_select2 = array();
        $kabupaten_untuk_select2 = array();
        $kecamatan_untuk_select2 = array();
        foreach($provinsi as $item){
            $provinsi_untuk_select2[$item->id_prov] = $item->nama;
        }
        foreach($kabupaten as $item){
            $kabupaten_untuk_select2[$item->id_kab] = $item->nama;
        }
        foreach($kecamatan as $item){
            $kecamatan_untuk_select2[$item->id_kec] = $item->nama;
        }
        return view('admin.lembaga.create', compact('provinsi_untuk_select2','kabupaten_untuk_select2','kecamatan_untuk_select2'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request->all());
        $this->validate($request, Lembaga_survey::rules());
        
        Lembaga_survey::create($request->all());

        return back()->withSuccess(trans('app.success_store'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $item = Lembaga_survey::findOrFail($id);
        $lembaga_survey=Lembaga_survey::where('status','aktif')->get();
        $lembaga_survey_untuk_select2 = array();
        $provinsi=Provinsi::all()->toArray();
        $kabupaten=Kabupaten::all()->toArray();
        $kecamatan=Kecamatan::all()->toArray();
        $provinsi_untuk_select2 = array();
        $kabupaten_untuk_select2 = array();
        $kecamatan_untuk_select2 = array();
        foreach($lembaga_survey as $itemx){
            $lembaga_survey_untuk_select2[$itemx->id] = $itemx->nama;
        }
        foreach($provinsi as $itemz){
            $provinsi_untuk_select2[$itemz['id_prov']] = $itemz['nama'];
        }
        foreach($kabupaten as $itemc){
            $kabupaten_untuk_select2[$itemc['id_kab']] = $itemc['nama'];
        }
        foreach($kecamatan as $itemd){
            $kecamatan_untuk_select2[$itemd['id_kec']] = $itemd['nama'];
        }
        return view('admin.lembaga.edit', compact('item','lembaga_survey_untuk_select2','provinsi_untuk_select2','kabupaten_untuk_select2','kecamatan_untuk_select2'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, Lembaga_survey::rules(true, $id));

        $item = Lembaga_survey::findOrFail($id);

        $item->update($request->all());

        return redirect()->route(ADMIN . '.lembaga.index')->withSuccess(trans('app.success_update'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Lembaga_survey::destroy($id);

        return back()->withSuccess(trans('app.success_destroy')); 
    }
}

