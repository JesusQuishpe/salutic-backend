<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OdoOdontogram extends Model
{
    use HasFactory;
    protected $table='odo_odontogram';

    public function teeth()
    {
        return $this->hasMany(OdoTeethDetail::class,'odo_id','id');
    }

    public function movilitiesRecessions()
    {
        return $this->hasMany(OdoMovilitieRecession::class,'odo_id','id');
    }
}
