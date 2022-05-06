<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\calcular_IMC;

class insertPatient extends Model
{

    public static function data($request)
    {

        $data = insertData::insert($request);

        return redirect()->route('pacientes');
    }
}
