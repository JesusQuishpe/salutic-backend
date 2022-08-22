<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OdoDiagnosticPlan extends Model
{
    use HasFactory;
    protected $table = 'odo_diagnostic_plans';

    public function details()
    {
        return $this->hasMany(OdoPlanDetail::class, 'diag_plan_id', 'id');
    }
}
