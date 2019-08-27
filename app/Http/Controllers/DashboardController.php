<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Lembaga_survey;
use App\Pemilihan;
use App\Tps;

class DashboardController extends Controller
{
    public function index()
    {
        $user = User::get()->count();
        $lembaga = Lembaga_survey::get()->count();
        $pemilihan = Pemilihan::get()->count();
        $tps = Tps::get()->count();
        return view('admin.dashboard.index', compact('user', 'lembaga', 'pemilihan','tps'));
    }
}
