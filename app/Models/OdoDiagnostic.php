<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OdoDiagnostic extends Model
{
    use HasFactory;
    protected $table='odo_diagnostics';

    public function cie()
    {
        return $this->belongsTo(Cie::class,'cie_id','id');
    }
}
