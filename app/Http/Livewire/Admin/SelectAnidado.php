<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\estado;
use App\Models\municipio;

class SelectAnidado extends Component
{
    public $selectedEstado = null, $selectedMunicipio = null;
    public $municipios = null; 

    public function render()
    {
        return view('livewire.admin.select-anidado', ['estados' =>estado::all() ]);

    }

    public function updatedselectedEstado($state_id){
        $this->municipios = municipio::where('state_id', $state_id);
    }
}
