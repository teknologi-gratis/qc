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
        $provinsi = Provinsi::select('nama', 'id_prov')->get();
        return view('auth.register_lembaga', compact('provinsi'));
    }

    public function getKabupaten(Request $request)
    {
        return response()->json(Kabupaten::whereIdProv($request->id)->get());
    }

    public function getKecamatan(Request $request)
    {
        return response()->json(Kecamatan::whereIdKab($request->id)->get());
    }

    public function getKelurahan(Request $request)
    {
        return response()->json(Kelurahan::whereIdKec($request->id)->get());
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
