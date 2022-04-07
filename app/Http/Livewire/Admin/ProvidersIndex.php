<?php

namespace App\Http\Livewire\Admin;
use App\Models\Proveedor;
use App\Models\State;
use App\Models\municipio;

use Livewire\Component;

class ProvidersIndex extends Component
{

    public function render()
    {
        $proveedores = Proveedor::all();
        $states = State::all();

        return view('livewire.admin.providers-index', compact('proveedores', 'states'));
    }

   
}
