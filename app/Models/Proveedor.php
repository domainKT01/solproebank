<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    use HasFactory;
    protected $table = 'providers';
    protected $fillable =[
        'tax_identification', 
        'name',
        'cod_city',
        'od_state',
        'address',
        'phones',
        'email',
    ];
}
