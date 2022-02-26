<?php

namespace App\Http\Livewire\Admin;

use App\Models\estado;
use App\Models\Requestoring;
use Livewire\Component;
use Livewire\WithPagination;

class RequestoringsIndex extends Component
{
    use withPagination;

    protected $paginationTheme = "bootstrap";

    public $search;

    public function updatingSearch(){
        $this->resetPage();
    }
    public function render()
    {
        $estados = estado::all();
        $requestorings = requestoring::where('DES_REQUESTORIG','LIKE','%'. $this->search .'%')
                ->latest('ID_REQUESTORIG')
                ->paginate(10);
        return view('livewire.admin.requestorings-index', compact('requestorings','estados'));
       
    }
}
