<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OdoIndicator extends Model
{
    use HasFactory;
    protected $table='odo_indicators';

    public function details()
    {
        return $this->hasMany(OdoIndicatorDetail::class,'id_ind','id');
    }
}
