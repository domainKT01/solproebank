<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class calcular_IMC extends Model
{
    public function calculo($talla, $peso)
    {

        $IMC = $peso / $talla**2;

        return $IMC;
        
    }

    public function categorizar($IMC)
    {

        $data = User::select('*')->from('compare_value')->orderBy('id', 'desc')->first();

        if ( $IMC <= $data->bajoPeso ) {

            return "bajo peso";

        }

        elseif ( $IMC <= $data->normalBajo ) {

            return "normal bajo";
        }

        elseif ( $IMC <= $data->normalAlto ) {

            return "normal alto";
        }

        elseif ( $IMC <= $data->sobrepeso ) {

            return "sobrepeso";
        }

        else {

            return "obesidad";
        }

    }

    public function volemia($talla, $peso, $sexo)
    {

        $volemiaM = 0.3669 * ($talla ** 3) + (0.03219 * $peso) + 0.6041;

        $volemiaF = 0.3561 * ($talla ** 3) + (0.03308 * $peso) + 0.1833;

        if ($sexo == 'Hombre' ){

            return $volemiaM;
        }

        else {

            return $volemiaF;
        }
    }
}
