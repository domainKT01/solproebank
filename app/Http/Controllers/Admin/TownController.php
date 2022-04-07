<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\estado;

class TownController extends Controller
{
    public function index()
    {
        $states = estado::lists('name', 'id');
        return view('admin.providers.create');

    }
    
}
