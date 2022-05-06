<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;

use App\Http\Livewire\Admin\insertPatient;

use App\Http\Livewire\Admin\Compare;

use App\Http\Livewire\Admin\Dashboard;

use Illuminate\Http\Request;

class pagesController extends Controller
{
    public function insertPatient(){

        return view('livewire.admin.compare');  
    }

    public function compare(){

        return Compare::class;
    }

    public static function Dashboard(){

        return Dashboard::class;
    }
}
