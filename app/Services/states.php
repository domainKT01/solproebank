<?php

namespace App\Services;

use App\state;

class States
{
    public function get()
    {
        $states = States::get();
        $statesArray[''] = 'Choose state';
        foreach ($states as $state) {
            $statesArray[$state->id] = $state->name;
        }
        return $statesArray;
        
    }
}