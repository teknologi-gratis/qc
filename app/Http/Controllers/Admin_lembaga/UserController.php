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

use App\Lembaga_survey;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $user_id = Auth::user()->lembaga_id;
    //    dd($user_id);
        $items = User::where('lembaga_id',$user_id)->where('role',20)->latest('updated_at')->with('lembaga_survey')->get();
        //dd($items);
        $roles = config('variables.role');
        return view('admin_lembaga.users.index', compact('items','roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $lembaga_survey=Lembaga_survey::where('status','aktif')->get();
        $lembaga_survey_untuk_select2 = array();
        foreach($lembaga_survey as $item){
            $lembaga_survey_untuk_select2[$item->id] = $item->nama;
        }
        return view('admin_lembaga.users.create', compact('lembaga_survey_untuk_select2'));
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

        return view('admin_lembaga.users.edit', compact('item'));
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

        $item->update($request->all());

        return redirect()->route('admin_lembaga' . '.users.index')->withSuccess(trans('app.success_update'));
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
	    return redirect('/admin_lembaga/users');
    }
}
