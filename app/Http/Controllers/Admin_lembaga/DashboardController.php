<?php

namespace App\Http\Controllers\Admin_lembaga;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Pemilihan;
use App\Tps;
use App\Calon;

class DashboardController extends Controller
{
    public function index()
    {   $user_id = Auth::user()->lembaga_id;
        //    dd($user_id);
        $saksi = User::where('lembaga_id',$user_id)->where('role',20)->latest('updated_at')->with('lembaga_survey')->get()->count();
        $roles = config('variables.role');
        $pemilihan = Pemilihan::where('lembaga_id', Auth::user()->lembaga_id)->latest('updated_at')->with('provinsi','kabupaten')->get()->count();
        $tps = Tps::where('lembaga_id', Auth::user()->lembaga_id)->latest('updated_at')->with('provinsi','kabupaten','kecamatan','kelurahan')->get()->count();
        $calon = Calon::where('lembaga_id', Auth::user()->lembaga_id)->latest('updated_at')->get()->count();
        return view('admin_lembaga.dashboard.index', compact('saksi','roles', 'pemilihan', 'tps','calon'));
    }
}
