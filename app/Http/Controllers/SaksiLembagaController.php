<?php

namespace App\Http\Controllers\Admin_lembaga;

use App\Imports\SaksiTpsImport;
use App\Http\Controllers\Controller;
use Session;
use Maatwebsite\Excel\Facades\Excel;

//use App\Http\Controllers\Admin_lembaga\import_excel;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\User;
use App\Pemilihan;
use App\Lembaga_survey;

class SaksiLembagaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $pemilihan = Pemilihan::with('provinsi','kabupaten')->findOrFail($id);
        $items = User::where('id_pemilihan',$id)->get();
        return view('admin.gabungan.gabungan_index', compact('items','pemilihan','id'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $pemilihan = Pemilihan::findOrFail($id);
        return view('admin.gabungan.create_saksi', compact('id','pemilihan'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, User::rules());
        
        User::create($request->all());

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
        $item = User::findOrFail($id);
        return view('admin.gabungan.edit_saksi', compact('item','id'));  
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
        $this->validate($request, User::rules(true, $id));

        $item = User::findOrFail($id);
        $item->update($request->except('id_pemilihan'));

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
        User::destroy($id);

        return back()->withSuccess(trans('app.success_destroy')); 
    }
    
    public function import_excel(Request $request)
    {
        	// validasi
	    $this->validate($request, [
		    'file' => 'required|mimes:csv,xls,xlsx'
	    ]);
 
	    // menangkap file excel
	    $file = $request->file('file');
 
	    // membuat nama file unik
	    $nama_file = rand().$file->getClientOriginalName();
 
	    // upload ke folder file_siswa di dalam folder public
	    $file->move('file_saksi_tps',$nama_file);
 
	    // import data
	    Excel::import(new SaksiTpsImport, public_path('/file_saksi_tps/'.$nama_file));
 
	    // notifikasi dengan session
	    Session::flash('sukses','Data Saksi Berhasil Diimport!');
 
	    // alihkan halaman kembali
	    return redirect('admin/lembaga/saksi/{id}');
    }  
}

