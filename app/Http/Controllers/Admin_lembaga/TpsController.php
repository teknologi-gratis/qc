<?php

namespace App\Http\Controllers\Admin_lembaga;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Imports\TpsImport;
use Maatwebsite\Excel\Facades\Excel;
use Session;

use App\User;
use App\Tps;
use App\Provinsi;
use App\Kabupaten;
use App\Kecamatan;
use App\Kelurahan;
use Auth;

class TpsController extends Controller
{
    public function tps_import(request $request) 
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
		$file->move('file_tps',$nama_file);
 
		// import data
        Excel::import(new TpsImport, public_path('/file_tps/'.$nama_file));
        
		// notifikasi dengan session
		Session::flash('sukses','Data Tps Berhasil Diimport!');
 
		// alihkan halaman kembali
		return redirect('/admin_lembaga/tps');
	}
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = Tps::where('lembaga_id', Auth::user()->lembaga_id)->latest('updated_at')->with('provinsi','kabupaten','kecamatan','kelurahan')->get();
        // $img= Tps::where('images')->get();
        // $img_view = DB::select("select* from tps where images='".$images."'");
        // dd($img_view);
        // $img = Tps::all();
        $roles = config('variables.role');
        return view('admin_lembaga.tps.index', compact('items','roles',));
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
        $saksis=User::where('role', 20)->where('lembaga_id', Auth::user()->lembaga_id)->get();
        $provinsi_untuk_select2 = $kabupaten_untuk_select2 = $kecamatan_untuk_select2 = $saksi_untuk_select2 = array();

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

        return view('admin_lembaga.tps.create', compact('provinsi_untuk_select2','kabupaten_untuk_select2','kecamatan_untuk_select2','saksi_untuk_select2'));
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
        
        $item = Tps::findOrFail($id);
        $provinsi=Provinsi::all()->toArray();
        $kabupaten=Kabupaten::where('id_prov',$item->prov_id)->get()->toArray();
        $kecamatan=Kecamatan::where('id_kab',$item->kab_id)->get()->toArray();
        $kelurahan=Kelurahan::where('id_kec',$item->kec_id)->get()->toArray();
        $saksis=User::where('role', 20)->where('lembaga_id', Auth::user()->lembaga_id)->get();
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
        return view('admin_lembaga.tps.edit', compact('item','provinsi_untuk_select2','kabupaten_untuk_select2','kecamatan_untuk_select2','kelurahan_untuk_select2','saksi_untuk_select2'));
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

        return redirect()->route('admin_lembaga' . '.tps.index')->withSuccess(trans('app.success_update'));
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

    public function downloadImage($id){
        $id1=Tps::where('id',$id)->first();
        $download = Tps::where('id', $id1->id)->first();
        $path = public_path(). '/c1/'. $download->images;
        return response()->download($path, $download->filename);
    }

    public function generateSample(Request $request){
        $lembaga_id = Auth::user()->lembaga_id;

        // // buat generate data TPS
        // for($i=0; $i<1500;$i++){
        //     $no_tps = $i+1;
        //     $data = array(
        //         'prov_id' => '32',
        //         'kab_id' => '3212',
        //         'kec_id' => '321215',
        //         'kel_id' => '3212152014',
        //         'total_suara' => rand(1, 1000),
        //         'suara_tidak_sah' => rand(0,100),
        //         'no_tps' => $no_tps,
        //         'is_sample' => 0,
        //         'created_at' => '2019-06-27 12:27:03',
        //         'updated_at' => '2019-06-27 12:27:03',
        //         'lembaga_id' => Auth::user()->lembaga_id,
        //     );            
        //     Tps::create($data);
        // }
        // exit();

        $all_tps_lembaga = Tps::where('lembaga_id', $lembaga_id)->get();
        $seluruh_tps_yang_diinput_admin_lembaga = Tps::where('lembaga_id', $lembaga_id)->orderBy('no_tps','asc')->get();
        $populasi = (int) $seluruh_tps_yang_diinput_admin_lembaga->count();
        $threshold = $request->threshold * $request->threshold;
        $jumlah_sampel = floor($populasi / (1 + $populasi * $threshold));
        $interval = $populasi / $jumlah_sampel;
        $decimal = floor($interval); 
        $fraksi = $interval - $decimal;
        if($fraksi < 0.5){
            $pembulatan = floor($interval);
        } else {
            $pembulatan = ceil($interval);
        }
        for($x = 0; $x < $populasi; $x++){
            $this_tps = $all_tps_lembaga[$x];
            if($x % $pembulatan == 0){
                // sampel
                $data = array(
                    'is_sample' => 1
                );
                $this_tps->update($data);
            } else {
                // bukan sampel
                $data = array(
                    'is_sample' => 0
                );
                $this_tps->update($data);
            };
            
        }  

        return redirect()->route('admin_lembaga' . '.tps.index')->withSuccess('Berhasil generate sampel');
    }

    
}

