<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User;
use App\Models\insertD;

class insertData extends Model
{

    public static function insert($request)
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

        $patient = new User();

        $patient->setTable('patients')->upsert([

            'nombre' => $namePatient,
            'imc' => $response,
            'volemia' => $volemia,
            'apto' => $apto
        ],
        1
    );

        return view('response-table', compact('namePatient', 'response', 'categoria', 'volemia', 'apto'));
    }
}
