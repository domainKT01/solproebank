<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Nette\Utils\Strings;
use App\Http\Controllers\inData;
use App\Models\calcular_IMC;
use App\Models\insertCompare;
use App\Models\insertPatient;

class formController extends Controller
{
    public function store(Request $request)
    {

        $response3 = insertCompare::insert($request);

        return $response3;
    }
}
