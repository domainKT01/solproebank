<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Customer extends Model
{
    use HasFactory;
    protected $table = 'customer';
    protected $primaryKey = 'ID_CUSTOMER';
    protected $fillabe=['DES_REQUESTORIG ','DES_ADDRESS', 'ID_STATE','NIT','CORREO'];
}
