<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;

use App\Http\Livewire\Admin\insertPatient;

use App\Http\Livewire\Admin\Compare;

use App\Http\Livewire\Admin\Dashboard;

use Illuminate\Http\Request;

class pagesController extends Controller
{
    public function patients(){

        $response = new insertPatient();

        return $response->render();
    }

    public function compare(){

        $response = new Compare();

        return $response->render();
    }

    public static function Dashboard(){

        return Dashboard::class;
    }
}
