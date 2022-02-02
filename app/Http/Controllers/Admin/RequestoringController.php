<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Requestoring;


class RequestoringController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    

    public function index()
    {
        $requestorings = requestoring::all();
        $state=requestoring::join('state','state.id_state', '=','requestoring.id_state');

        //dd($state);

        return view('admin.requestorings.index', compact('requestorings'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Requestoring $requestorings)
    {
        return view('admin.requestorings.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'DES_REQUESTORIG '=>'required',
            'DES_ADDRESS' =>'required',
            'ID_STATE' => 'required',
            'NIT'=> 'requered',
            'CORREO' =>'requered'
        ]); 

       
        return $request->all();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Requestoring $requestoring)
    {
        return view('admin.requestorings.show', compact('requestoring'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Requestoring $requestoring)
    {
       return view('admin.requestorings.edit');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $requestorings)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Requestoring $requestorings)
    {
        //
    }
}
