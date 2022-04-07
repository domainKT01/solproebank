<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Town extends Model
{
    use HasFactory;

    protected $table = 'towns';
    protected $fillable = ['name', 'state_id'];

    public static function towns($id){
        return Town::where('state_id','=',$id)
        ->get();
    }
}
