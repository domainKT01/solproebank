<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Requestoring extends Model
{
    use HasFactory;
    protected $table = 'requestoring';
    protected $primaryKey = 'ID_REQUESTORIG';
}
