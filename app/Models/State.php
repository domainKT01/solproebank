<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Requestoring;

class State extends Model
{
    protected $table ='states';
    protected $fillabel= ['des_state'];
    protected $primaryKey = 'ID_STATE';

    public function requestorings(){
        return $this->hasMany(Requestoring::class);
    }

    public function towns(){
        return $this->belongsTo(Town::class);
    }
}