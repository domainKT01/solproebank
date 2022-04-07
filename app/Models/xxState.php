<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    use HasFactory;
    protected $table ='state';
    protected $fillabel= ['des_state'];
    protected $primaryKey = 'ID_STATE';

    public function requestorings(){
        return $this->hasMany('app\models\requestoring','ID_REQUESTORIG','ID_STATE');
    }
}
