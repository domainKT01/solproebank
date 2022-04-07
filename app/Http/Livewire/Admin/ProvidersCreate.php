<?php

namespace App\Http\Livewire\Admin;

use App\Http\Controllers\TownController;
use Livewire\Component;
use App\Models\State;
use App\Models\Town;

class ProvidersCreate extends Component
{
    
    public $municipios = 1;
    
    public function mount()
    {
        $this->municipios = town::all()->isActive();
    }

    public function render()
    {
               
        return view('livewire.admin.providers-create', [
            
        ]);
    }
    
}
