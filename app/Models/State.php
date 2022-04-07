<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    use HasFactory;
    protected $table ='states';
    protected $fillabel= ['name'];
    
    public function get()
    {
        $states = State::get();
        $statesArray[''] = 'Choose state';
        foreach ($states as $state) {
            $statesArray[$state->id] = $state->name;
        }
        return $statesArray;
        
    }

    public function requestorings(){
        return $this->hasMany('app\models\requestoring','ID_REQUESTORIG','state_id');
    }
}
