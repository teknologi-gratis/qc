<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
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
        
        $items = User::where('role',20)->orWhere('role',15)->latest('updated_at')->with('lembaga_survey')->get();
        //dd($items);
        $roles = config('variables.role');
        return view('admin.users.index', compact('items','roles'));
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
        return view('admin.users.create', compact('lembaga_survey_untuk_select2'));
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
        $lembaga_survey=Lembaga_survey::where('status','aktif')->get();
        $lembaga_survey_untuk_select2 = array();
        foreach($lembaga_survey as $itemx){
            $lembaga_survey_untuk_select2[$itemx->id] = $itemx->nama;
        }
        return view('admin.users.edit', compact('item','lembaga_survey_untuk_select2'));
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

        return redirect()->route(ADMIN . '.users.index')->withSuccess(trans('app.success_update'));
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
}

