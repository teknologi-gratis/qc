<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\support\Facades\DB;
use Illuminate\Http\Request;
use App\Pemilihan;
use App\Provinsi;
use App\Kabupaten;
use App\Calon;
use App\User;
use App\Tps;
use App\Lembaga_survey;

class GabunganController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $lembaga = Lembaga_survey::with('provinsi','kabupaten')->findOrFail($id);
        //dd($pemilihan);
        $items = Pemilihan::where('lembaga_id',$id)->get();
        $calon = Calon::where('lembaga_id',$id)->get();
        $saksi = User::where('lembaga_id', $id)->where('role',20)->latest('updated_at')->with('lembaga_survey')->get();
        $tps = Tps::where('lembaga_id', $id)->get();
        return view('admin.gabungan.gabungan_index',compact('lembaga','items','calon','saksi','tps','id'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function create($id)
    // {   
    //     $pemilihan = Pemilihan::findOrFail($id);
    //     return view('admin.calon.create', compact('id','pemilihan'));
    // }

    // /**
    //  * Store a newly created resource in storage.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @return \Illuminate\Http\Response
    //  */
    // public function store(Request $request)
    // {
    //     // dd($request->all());
    //     $this->validate($request, Calon::rules());
        
    //     Calon::create($request->all());

    //     return back()->withSuccess(trans('app.success_store'));
    // }

    // /**
    //  * Display the specified resource.
    //  *
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function show($id)
    // {
    //     //
    // }

    // /**
    //  * Show the form for editing the specified resource.
    //  *
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function edit($id)
    // {
    //     $item = Calon::findOrFail($id);
    //     return view('admin.calon.edit', compact('item','id'));        
    // }

    // /**
    //  * Update the specified resource in storage.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function update(Request $request, $id)
    // {
    //     $this->validate($request, Calon::rules(true, $id));

    //     $item = Calon::findOrFail($id);
    //     $item->update($request->except('pemilihan_id'));

    //     return redirect()->back()->withSuccess(trans('app.success_update'));
    // }

    // /**
    //  * Remove the specified resource from storage.
    //  *
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function destroy($id)
    // {
    //     Calon::destroy($id);
    //     return back()->withSuccess(trans('app.success_destroy')); 
    // }
}

