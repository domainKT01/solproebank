<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\calcular_IMC;

class insertPatient extends Model
{

    protected $table = 'patients';

    protected $fillable = [

        'nombre',
        'imc',
        'volemia',
        'apto'
    ];

    protected $guarded = [

        'created_at',
        'updated_at'
    ];

    public $timestamps = true;
}
