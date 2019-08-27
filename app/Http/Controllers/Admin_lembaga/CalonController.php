<?php

namespace App\Http\Controllers\Admin_lembaga;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Pemilihan;
use App\Provinsi;
use App\Kabupaten;
use App\Calon;

class CalonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $pemilihan = Pemilihan::with('provinsi','kabupaten')->findOrFail($id);
        $items = Calon::where('pemilihan_id',$id)->orderBy('calon_nomor_urut', 'asc')->get();
        return view('admin_lembaga.calon.index', compact('items','pemilihan','id'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {   
        $pemilihan = Pemilihan::findOrFail($id);
        return view('admin_lembaga.calon.create', compact('id','pemilihan'));
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
        $this->validate($request, Calon::rules());
        
        Calon::create($request->all());

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
        $item = Calon::findOrFail($id);
        return view('admin_lembaga.calon.edit', compact('item','id'));        
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
        $this->validate($request, Calon::rules(true, $id));

        $item = Calon::findOrFail($id);
        $item->update($request->except('pemilihan_id'));

        return redirect()->back()->withSuccess(trans('app.success_update'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Calon::destroy($id);
        return back()->withSuccess(trans('app.success_destroy')); 
    }
}

