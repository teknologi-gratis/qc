<?php

namespace App\Http\Controllers;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Imports\TpsImport;
use Maatwebsite\Excel\Facades\Excel;
use Session;

use App\User;
use App\Tps;
use App\Provinsi;
use App\Kabupaten;
use App\Kecamatan;
use App\Kelurahan;
use App\Pemilihan;
use App\Lembaga_survey;
use Auth;

class TpsController extends Controller
{
    public function tps_import(Request $request)
    {
    		// validasi
    		$this->validate($request, [
    			'file' => ['required', 'mimes:csv,xls,xlsx']
    		]);

    		// menangkap file excel
    		$file = $request->file('file');

    		// membuat nama file unik
    		$nama_file = rand().$file->getClientOriginalName();

    		// upload ke folder file_siswa di dalam folder public
    		$file->move('file_tps',$nama_file);

    		// import data
        Excel::import(new TpsImport, public_path('/file_tps/'.$nama_file));

    		// notifikasi dengan session
    		Session::flash('sukses','Data Tps Berhasil Diimport!');

    		// alihkan halaman kembali
    		return redirect('/admin/tps');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = Tps::latest('updated_at')->with('lembaga_survey','provinsi','kabupaten','kecamatan','kelurahan')->get();
        $roles = config('variables.role');
        return view('admin.tps.index', compact('items','roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $provinsi=Provinsi::all();
        $kabupaten=Kabupaten::all();
        $kecamatan=Kecamatan::all();
        $saksis=User::where('role', 20)->get();
        $lembaga_survey=Lembaga_survey::where('status','aktif')->get();
        $lembaga_survey_untuk_select2 = array();

        $provinsi_untuk_select2 = $kabupaten_untuk_select2 = $kecamatan_untuk_select2 = $saksi_untuk_select2 = $lembaga_survey_untuk_select2 = array();

        foreach($provinsi as $item){
            $provinsi_untuk_select2[$item->id_prov] = $item->nama;
        }
        foreach($kabupaten as $item){
            $kabupaten_untuk_select2[$item->id_kab] = $item->nama;
        }
        foreach($kecamatan as $item){
            $kecamatan_untuk_select2[$item->id_kec] = $item->nama;
        }
        foreach($saksis as $item){
            $saksi_untuk_select2[$item->id] = $item->nama;
        }
        foreach($lembaga_survey as $item){
            $lembaga_survey_untuk_select2[$item->id] = $item->nama;
        }

        return view('admin.tps.create', compact('provinsi_untuk_select2','kabupaten_untuk_select2','kecamatan_untuk_select2','saksi_untuk_select2','lembaga_survey_untuk_select2'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $this->validate($request, Tps::rules());

        Tps::create($request->all());

        return back()->withSuccess(trans('app.success_store'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $item = Tps::findOrFail($id);
        $provinsi=Provinsi::all()->toArray();
        $kabupaten=Kabupaten::where('id_prov',$item->prov_id)->get()->toArray();
        $kecamatan=Kecamatan::where('id_kab',$item->kab_id)->get()->toArray();
        $kelurahan=Kelurahan::where('id_kec',$item->kec_id)->get()->toArray();
        $saksis=User::where('role', 20)->get();
        $lembaga_survey=Lembaga_survey::where('status','aktif')->get();
        $lembaga_survey_untuk_select2 = array();
        $provinsi_untuk_select2 = array();
        $kabupaten_untuk_select2 = array();
        $kecamatan_untuk_select2 = array();
        $kelurahan_untuk_select2 = array();
        $saksi_untuk_select2 = array();
        foreach($provinsi as $itemz){
            $provinsi_untuk_select2[$itemz['id_prov']] = $itemz['nama'];
        }
        foreach($kabupaten as $itemc){
            $kabupaten_untuk_select2[$itemc['id_kab']] = $itemc['nama'];
        }
        foreach($kecamatan as $itemd){
            $kecamatan_untuk_select2[$itemd['id_kec']] = $itemd['nama'];
        }
        foreach($kelurahan as $iteme){
            $kelurahan_untuk_select2[$iteme['id_kel']] = $iteme['nama'];
        }
        foreach($saksis as $itemf){
            $saksi_untuk_select2[$itemf['id']] = $itemf['nama'];
        }
        foreach($lembaga_survey as $itemx){
            $lembaga_survey_untuk_select2[$itemx->id] = $itemx->nama;
        }
        return view('admin.tps.edit', compact('item','provinsi_untuk_select2','kabupaten_untuk_select2','kecamatan_untuk_select2','kelurahan_untuk_select2','saksi_untuk_select2','lembaga_survey_untuk_select2'));
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
        $this->validate($request, Tps::rules(true, $id));

        $item = Tps::findOrFail($id);

        $item->update($request->all());

        return redirect()->route(ADMIN . '.tps.index')->withSuccess(trans('app.success_update'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Tps::destroy($id);

        return back()->withSuccess(trans('app.success_destroy'));
    }
}
