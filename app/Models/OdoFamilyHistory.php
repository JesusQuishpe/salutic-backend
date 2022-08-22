<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OdoFamilyHistory extends Model
{
    use HasFactory;
    protected $table='odo_family_histories';

    public function details()
    {
        return $this->hasMany(OdoFamilyHistoryDetail::class,'fam_id','id');
    }
}
