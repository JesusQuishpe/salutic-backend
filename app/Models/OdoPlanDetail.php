<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OdoPlanDetail extends Model
{
    use HasFactory;
    protected $table = 'odo_plan_details';
    protected $fillable = [
        'diag_plan_id',
        'plan_id'
    ];
    public function plan()
    {
        return $this->belongsTo(OdoPlan::class, 'plan_id', 'id');
    }
}
