<?php

namespace App\Http\Livewire\Admin;
use App\Models\Proveedor;

use Livewire\Component;

class ProvidersIndex extends Component
{

    public function render()
    {
        $proveedores = Proveedor::all();
        return view('livewire.admin.providers-index', compact('proveedores'));
    }
}
