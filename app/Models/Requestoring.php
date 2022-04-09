<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\State;

class Requestoring extends Model
{
    use HasFactory;
    protected $table = 'requestoring';
    protected $primaryKey = 'ID_REQUESTORIG';
    public $timestamps = false;
    protected $fillable = [
            'NIT',
            'CHECK_DIGITAL',
            'REGIME',
            'correo',
            'DES_REQUESTORIG',
            'DES_ADDRESS',
            'persona_encargada',
            'CITIZENSHIP_CARD',
            'LANDLINE',
            'MOBILE',
            'ID_STATE',
            'DES_AREA',
            'NEIGHBORHOOD'
    ];

   //many to many relationship

  
 public function states()
   {
       return $this->belongsTo(state::class, 'ID_STATE');
   }
    


}
