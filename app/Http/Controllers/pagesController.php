<?php

namespace App\Http\Controllers;

use App\Http\Livewire\insertPatient;

use App\Http\Livewire\Compare;

use App\Http\Livewire\Dashboard;

use Illuminate\Http\Request;

class pagesController extends Controller
{
    public static function insertPatient(){

        return InsertPatient::class;
    }

    public static function compare(){

        return Compare::class;
    }

    public static function Dashboard(){

        return Dashboard::class;
    }
}
