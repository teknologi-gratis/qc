<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Lembaga_survey;
use App\Provinsi;
use App\Kabupaten;
use App\Kecamatan;
use App\Kelurahan;
use App\Pemilihan;
use App\Calon;
use App\Suara;
use App\Tps;
use DB;
use Auth;

class RekapitulasiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $item=Tps::all();
        $pemilihan=Pemilihan::where('lembaga_id', Auth::user()->lembaga_id)->latest('updated_at')->with('provinsi','kabupaten')->get();
        $provinsi=Provinsi::all();
        $kabupaten=Kabupaten::all();
        $kecamatan=Kecamatan::all();
        $provinsi_untuk_select2 = array();
        $kabupaten_untuk_select2 = array();
        $kecamatan_untuk_select2 = array();
        foreach($provinsi as $item){
            $provinsi_untuk_select2[$item->null] = 'Pilih Provinsi';
            $provinsi_untuk_select2[$item->id_prov] = $item->nama;
        }
        foreach($kabupaten as $item){
            $kabupaten_untuk_select2[$item->null] = 'Pilih Kabupaten';
            $kabupaten_untuk_select2[$item->id_kab] = $item->nama;
        }
        foreach($kecamatan as $item){
            $kecamatan_untuk_select2[$item->null] = 'Pilih Kecamatan';
            $kecamatan_untuk_select2[$item->id_kec] = $item->nama;
        }
        return view('admin_lembaga.rekapitulasi.index', compact('pemilihan', 'provinsi_untuk_select2','kabupaten_untuk_select2','kecamatan_untuk_select2'));
    }
        

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(request $request)
    {
        $this->validate($request, Tps::rules());
        $tps = Tps::create($request->all());
        return redirect('/rekapitulasi_suara'.$tps->id)->withSuccess(trans('app.success_store'));
    } 


    public function rekapitulasi(Request $request){
        if($request->has('filterByKecamatan')){
            $pemilihan = Pemilihan::where('prov_id', $request->provinsi)->where('kab_id', $request->kabupaten)->where('tahun', $request->tahun)->first();
            $calon = Calon::where('pemilihan_id', $pemilihan->id)->get();
            $tps = Tps::where('tps.prov_id', $request->provinsi)
                        ->where('tps.kab_id', $request->kabupaten)
                        ->where('tps.kec_id', $request->kecamatan)
                        ->where('tps.id_pemilihan', $pemilihan->id)
                        ->get();    
            
            $array = [];
            $total_suara = [];
            foreach($tps as $key => $t){
                $calons= [];
                foreach($calon as $cln){
                    $suara = Suara::where('calon_id', $cln->id)->where('tps_id', $t->id)->first();
                    if($suara !== null){
                        // dd($suara->total_suara);
                            $cln->suara = $suara->total_suara;
                    } else {
                        $cln->suara = 0;
                    }
                    array_push($calons, [
                            'suara' => $cln->suara,
                            'nama_utama_calon' => $cln->calon_utama_nama,
                            'nama_wakil_calon' => $cln->calon_wakil_nama]);
                    }
                        if($key !== 0){
                            if($t->kel_id == $tps[$key-1]->kel_id){
                                    $total_suara = [];
                            }
                        } else {
                            array_push($total_suara, ['calon' => $calons, 'tps' => $t]);
                    }       
                }
            
            $hasil = [];
            foreach($total_suara as $key => $ts){
                $keluarahan = Kelurahan::find($ts['tps']->id);
                if($key == 0){
                    $ts->kelurahan = $keluarahan->nama;
                    $calon = [];
                    foreach($ts['calon'] as $kc => $cln){
                        array_push($calon, ['calon' . $kc => $cln]);
                    }
                    $ts->calon = $calon;
                    array_push($hasil, $ts);
                } else {    
                    if($total_suara[$key-1]['tps']->kel->id == $ts['tps']->kel_id){
                        
                    }
                }
            }

            return response()->json(['data' => $hasil]);            
 
            
        }
        $pemilihan = Pemilihan::where('prov_id', $request->provinsi)->where('kab_id', $request->kabupaten)->where('tahun', $request->tahun)->first();
        $calon = Calon::where('pemilihan_id', $pemilihan->id)->get();
        $tps = Tps::where('prov_id', $request->provinsi)
                    ->where('kab_id', $request->kabupaten)
                    ->where('kec_id', $request->kecamatan)
                    ->where('kel_id', $request->kelurahan)
                    ->where('id_pemilihan', $pemilihan->id) 
                    ->get();

        $array = [];
        $total_suara = [];
        foreach($tps as $t){
            $calons= [];
            foreach($calon as $cln){
                $suara = Suara::where('calon_id', $cln->id)->where('tps_id', $t->id)->first();
                if($suara !== null){
                    // dd($suara->total_suara);
                    $cln->suara = $suara->total_suara;
                } else {
                    $cln->suara = 0;
                }
                array_push($calons, [
                    'suara' => $cln->suara,
                    'nama_utama_calon' => $cln->calon_utama_nama,
                    'nama_wakil_calon' => $cln->calon_wakil_nama]);
            }
            // $result = [ 
            //     'tps' => $t,
            //     'calon' => $calons
            // ];
            array_push($total_suara, ['calon' => $calons, 'tps' => $t]);      
            // if($t->id == 7){
            //     return response()->json($array);        
            // }  
        }
        return response()->json($total_suara);        
        
    }
}

