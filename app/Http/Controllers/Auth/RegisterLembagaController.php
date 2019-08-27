<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Lembaga_survey;
use App\Provinsi;
use App\Kabupaten;
use App\Kecamatan;

class RegisterLembagaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
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
        return view('auth.register_lembaga', compact('provinsi_untuk_select2','kabupaten_untuk_select2','kecamatan_untuk_select2'));
    }
        

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(request $request)
    {
        $this->validate($request, Lembaga_survey::rules());
        $lembaga = Lembaga_survey::create($request->all());
        return redirect('/registrasi_akun/'.$lembaga->id)->withSuccess(trans('app.success_store'));
    } 
}

