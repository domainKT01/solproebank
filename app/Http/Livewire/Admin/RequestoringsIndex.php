<?php

namespace App\Http\Livewire\Admin;


use App\Models\Requestoring;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\town;
use App\Models\State;

class RequestoringsIndex extends Component
{
    use withPagination;

    protected $paginationTheme = "bootstrap";

    public $search;
    public $sort = 'state_id';
    public $direction= 'Desc';

    public $selectedEstado = null, $selectedMunicipio = null;
    public $towns = null; 

    public function updatingSearch(){
        $this->resetPage();
    }
    public function render()
    {
        $states = State::all();
        $requestorings = requestoring::where('DES_REQUESTORIG','LIKE','%'. $this->search .'%')
                ->orwhere('NIT','LIKE','%'.$this->search.'%')
                ->orwhere('des_area','LIKE','%'.$this->search.'%')
                /*->orderby($this->sort, $this->direction)*/
                ->latest('ID_REQUESTORIG')
                ->paginate(10);
            

        return view('livewire.admin.requestorings-index', compact('requestorings',['states'=>state::all()]));
       
    }

    public function updatedselectedEstado($state_id){
        $this->towns = town::where('state_id','state_id')->get();
    }

    public function order($sort){
        if ($this->sort== $sort){
            if ($this->direction == 'desc'){
                ($this->direction == 'asc');
            }else{
                ($this->direction == 'desc');
            }
        }else

            $this->sort=$sort;
    }
}
