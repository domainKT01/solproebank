<?php

namespace App\Http\Controllers;

use App\Models\insertData;
use App\Models\insertPatient;
use Illuminate\Http\Request;

class patientController extends Controller
{
    public function store (Request $request) {

        $data = insertData::insert($request);

        return $data;
    }
}
