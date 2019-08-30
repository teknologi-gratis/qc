<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Lembaga_survey;
use App\Provinsi;
use App\Kabupaten;
use App\Kecamatan;
use App\User;

class RegisterAkunController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $lembaga = Lembaga_survey::findOrFail($id);
        $lembaga_id = $id;
        $role = 15;
        return view('auth.register_akun', compact('lembaga','lembaga_id', 'role'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(request $request)
    {
        $this->validate($request, User::rules());
        $user = User::create($request->all());
        return redirect('/login/')->withSuccess(trans('app.success_store'));

    }

    // protected function validator(array $data)
    // {
    //     return Validator::make($data, [
    //         'name' => ['required', 'string', 'max:255'],
    //         'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
    //         'password' => ['required', 'string', 'min:8', 'confirmed'],
    //         'avatar' => ['required', 'string', 'min:8', 'confirmed'],
    //         'nik' => ['required', 'string', 'max:20', 'confirmed'],
    //         'biodata' => ['required'],
    //     ]);
    // }

    // /**
    //  * Create a new user instance after a valid registration.
    //  *
    //  * @param  array  $data
    //  * @return \App\User
    //  */
    // protected function create(array $data)
    // {
    //     return User::create([
    //         'name' => $data['name'],
    //         'email' => $data['email'],
    //         'password' => $data['password'],
    //         'avatar' =>$data['avatar'],
    //         'nik' => $data['nik'],
    //         'biodata' => $data['biodata'],
    //         'role' => 15,
    //     ]);
    // }



}
