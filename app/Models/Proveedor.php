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
        'check_regime', 
        'name',
        'cod_city',
        'cod_state',
        'id_country',
        'address',
        'phones',
        'mobile',
        'email',
        'website',
        'check_regime'

    ];
    public function estados()
    {
        //return $this->belongsTo('app\models\estado','ID_STATE');
    }

}
