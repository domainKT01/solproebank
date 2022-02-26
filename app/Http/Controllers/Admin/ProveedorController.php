<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Proveedor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use app\Models\estado;

class ProveedorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $providers = Proveedor::all();
        return view('admin.providers.index', compact('providers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $estados = DB::table('state')->orderBy('DES_STATE','asc');

        return view('admin.providers.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)

    {
        $estados = estado::all()->orderBy('DES_STATE','asc');
    
        $request -> validate([
            'tax_identification' => 'required|unique:providers', 
            'name'=> 'required',
            'cod_city'=> 'required',
            'od_state'=> 'required',
            'address'=> 'required',
            'phones'=> 'required',
            'email'=> 'required',
        ]);

        $providers = Proveedor::create($request->all());
       
        return redirect()->route('admin.providers.edit', compact('providers'))->with('info','Provider created successfully');
    }
    

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(proveedor $providers)
    {
        return view('admin.providers.show', compact('providers'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)

    {
        
        return view('admin.providers.edit', compact('providers'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $providers)
    {
        $request -> validate([
            'tax_identification' => 'required|unique:providers', 
            'name'=> 'required',
            'cod_city'=> 'required',
            'od_state'=> 'required',
            'address'=> 'required',
            'phones'=> 'required',
            'email'=> 'required',
        ]);
        $providers->update($request->all());
        return redirect()-> route('admin.providers.edit',$providers)->with('info','Provider upgraded successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Proveedor $providers)
    {
        $providers->delete();
        return  redirect()->route('admin.providers.index')->with('info','Provider removed successfully');

    }
}
