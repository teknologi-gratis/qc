<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Provinsi;
use App\Kabupaten;
use App\Kecamatan;
use App\Kelurahan;

class DaerahController extends Controller
{
    public function getKabupatenByProvinsi(Request $request){
        if($request->ajax()){
            $kabupatens = Kabupaten::where('id_prov', $request->provinsi_id)->pluck('nama','id_kab');
            return response()->json($kabupatens);
        }
    }

    public function getKecamatanByKabupaten(Request $request){
        if($request->ajax()){
            $kecamatans = Kecamatan::where('id_kab', $request->kabupaten_id)->pluck('nama','id_kec');
            return response()->json($kecamatans);
        }
    }

    public function getKelurahanByKecamatan(Request $request){
        if($request->ajax()){
            $kelurahans = Kelurahan::where('id_kec', $request->kecamatan_id)->pluck('nama','id_kel');
            return response()->json($kelurahans);
        }
    }
}

