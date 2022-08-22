<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OdoTeethDetail extends Model
{
    use HasFactory;
    protected $table = 'odo_teeth_details';

    public function tooth()
    {
        return $this->belongsTo(OdoTooth::class, 'teeth_id', 'id');
    }

    public function symbologie()
    {
        return $this->belongsTo(OdoSymbologie::class,'symbo_id','id');
    }
}
