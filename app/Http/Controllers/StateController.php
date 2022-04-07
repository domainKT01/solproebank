<?php

namespace App\Http\Controllers;

use App\Models\State;
use App\Models\Town;
use Illuminate\Http\Request;

class StateController extends Controller
{
    public function index()
   
    {
        $states = State::orderby('id')->pluck('name', 'id');
        return view('admin.providers.index', compact('states'));

    }

    public function getTowns(Request $request, $town_id){

        if ($request->ajax()){
            $towns = Town::where('state_id', $request->state_id)->get();
            foreach ($towns as $town){
                 $townsArray[$town->id] = $town->name;
            }
            return response()->json($townsArray);
                
        }   
    }
    
}
