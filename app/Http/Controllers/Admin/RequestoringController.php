<?php

namespace App\Http\Controllers\Admin;
use App\Rule\uppercase;
use App\Http\Controllers\Controller;
use App\Models\estado;
use Illuminate\Http\Request;
use App\Models\Requestoring;
use App\Rules\UpperCase as RulesUpperCase;
use App\Models\municipio;

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
       
        return view('admin.requestorings.index', compact('requestorings'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Requestoring $requestorings)
    {
         /* $estados = estado::all()->sortBy('DES_STATE'); */
        $estados=estado::pluck('DES_STATE','ID_STATE');
        $municipios= municipio::pluck('nombre','codigo');
       
        return view('admin.requestorings.create', compact('estados', 'municipios'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,)
    {
        $request->validate([
            'NIT'=>'required|unique:requestoring',
            'correo'=>'required|email|unique:requestoring',
            'DES_REQUESTORIG'=>'required',
            'persona_encargada'=>'required',
            'CITIZENSHIP_CARD'=>'required',
            'LANDLINE'=>'required',
            'MOBILE'=>'required',
            'ID_STATE'=>'required',
            'DES_AREA'=>'required'
            
        ]); 

        $Requestoring = Requestoring::create($request->all());
        return redirect()->route('admin.requestorings.edit', compact('requestoring'));
        
    }

    

    public function messages()
{
    return [
       
    ];
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
