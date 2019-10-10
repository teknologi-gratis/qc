<?php

namespace App\Http\Controllers\Admin_lembaga;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Pemilihan;
use App\Provinsi;
use App\Kabupaten;
use Auth;


class PemilihanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $items = Pemilihan::where('lembaga_id', Auth::user()->lembaga_id)->latest('updated_at')->with('provinsi','kabupaten')->get();
        $roles = config('variables.role');
        return view('admin_lembaga.pemilihan.index', compact('items'));
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
        $provinsi_untuk_select2 = array();
        $kabupaten_untuk_select2 = array();
        foreach($provinsi as $item){
            $provinsi_untuk_select2[$item->id_prov] = $item->nama;
        }
        foreach($kabupaten as $item){
            $kabupaten_untuk_select2[$item->id_kab] = $item->nama;
        }

        return view('admin_lembaga.pemilihan.create', compact('provinsi_untuk_select2','kabupaten_untuk_select2'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $this->validate($request, Pemilihan::rules());

        Pemilihan::create($request->all());

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
        $item = Pemilihan::findOrFail($id);
        $provinsi=Provinsi::all()->toArray();
        $kabupaten=Kabupaten::all()->toArray();
        $provinsi_untuk_select2 = array();
        $kabupaten_untuk_select2 = array();
        foreach($provinsi as $itemz){
            $provinsi_untuk_select2[$itemz['id_prov']] = $itemz['nama'];
        }
        foreach($kabupaten as $itemc){
            $kabupaten_untuk_select2[$itemc['id_kab']] = $itemc['nama'];
        }
        return view('admin_lembaga.pemilihan.edit', compact('item','provinsi_untuk_select2','kabupaten_untuk_select2'));
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
        $this->validate($request, Pemilihan::rules(true, $id));

        $item = Pemilihan::findOrFail($id);

        $item->update($request->all());

        dd($request);

        // return redirect()->route('admin_lembaga' . '.pemilihan.index')->withSuccess(trans('app.success_update'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Pemilihan::destroy($id);

        return back()->withSuccess(trans('app.success_destroy'));
    }
}
