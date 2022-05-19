<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\patientRequest;
use App\Http\Requests\RequestsPatientRequest;
use App\Models\calcular_IMC;
use Illuminate\Http\Request;
use App\Http\Livewire\Admin\InsertPatient;
use App\Models\insertPatient as ModelsInsertPatient;

class patientsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $response = new InsertPatient();

        return $response->render();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $imc = new calcular_IMC();

        $response = $imc->calculo(floatval($request->talla), floatval($request->peso));

        $categoria = $imc->categorizar($response);

        $volemia = $imc->volemia(floatval($request->talla), floatval($request->peso), $request->sexo);

        $namePatient = $request->patientName;

        $apto = 'apto';

        if ($volemia >= 3.5) {

            $apto = 'Apto';
        } else {

            $apto = 'No Apto';
        }

        $patient = new ModelsInsertPatient();

        $patient->setTable('patients')->upsert(
            [

                'nombre' => $namePatient,
                'imc' => $response,
                'volemia' => $volemia,
                'apto' => $apto
            ],
            1
        );

        //insertPatient::create($request->all());

        return view('livewire.admin.response-table', compact('namePatient', 'response', 'categoria', 'volemia', 'apto'));
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
