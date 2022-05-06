<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User;
use App\Models\insertD;

class insertCompare extends Model{

    public static function insert($request){

        $user = new User();

        $user->setTable('compare_value');

        $user->bajoPeso = $request->bajoPeso;

        $user->normalBajo = $request->normalBajo;

        $user->normalAlto = $request->normalAlto;

        $user->sobrepeso = $request->sobrepeso;

        $user->save();

        return redirect()->route('parametros');
    }
}
