<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Proveedor;
use App\Models\State;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Town;

class ProveedorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public $SelectedEstado = null, $selectedMunicipio= null;
    public $municipios = null;

    public function index()

    {
        $states = State::all();
        $providers = Proveedor::all();
        return view('admin.providers.index', compact('states'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     * 
     * 
     */
    public function listarmunicipios($ID_STATE)

    {
        $this->municipios = Town::where('ID_STATE', $ID_STATE)->get();

    }

    public function create(Request $request)
    {
    
        $states = State::lists('DES_STATE', 'ID_STATE');
        return view('admin.providers.create', compact('states'));

           
    }

    public function gettowns(Request $request, $id){
        @dd($id);

        if($request->ajax()){
            $towns = Town::towns($id);
            return response()->json($towns);
        }
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

            'tax_identification' => 'required|unique:providers',
            'check_digital' => 'required',
            'name' => 'required',
            'cod_city' => 'required',
            'cod_state' => 'required',
            'id_country' => 'required',
            'address' => 'required',
            'phones' => 'required',
            'email' => 'required|email|unique:providers',
            'id_regime' => 'required',
            'website' => 'required',

        ]);

        $providers = Proveedor::create($request->all());
        return redirect()->route('admin.providers.edit', compact('proveedor', 'estado'));
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
        $request->validate([
            'tax_identification' => 'required|unique:providers',
            'name' => 'required',
            'cod_city' => 'required',
            'od_state' => 'required',
            'address' => 'required',
            'phones' => 'required',
            'email' => 'required',
        ]);
        $providers->update($request->all());
        return redirect()->route('admin.providers.edit', $providers)->with('info', 'Provider upgraded successfully');
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
        return  redirect()->route('admin.providers.index')->with('info', 'Provider removed successfully');
    }
}
