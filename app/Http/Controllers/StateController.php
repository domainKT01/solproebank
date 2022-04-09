<?php

namespace App\Http\Controllers;

use App\Models\State;
use App\Models\Town;
use Illuminate\Http\Request;

class StateController extends Controller
{
    public function index()
   
    {
        $states = State::orderby('ID_STATE')->pluck('DES_STATE', 'ID_STATE');
        return view('admin.providers.index', compact('states'));

    }

    public function getTowns(Request $request, $town_id){

        if ($request->ajax()){
            $towns = Town::where('ID_STATE', $request->ID_STATE)->get();
            foreach ($towns as $town){
                 $townsArray[$town->id] = $town->name;
            }
            return response()->json($townsArray);
                
        }   
    }
    
}
