<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LbGroup extends Model
{
    use HasFactory;
    protected $table='lb_groups';

    public function area()
    {
        return $this->belongsTo(LbArea::class,'area_id','id');
    }

    public function tests()
    {
        return $this->hasMany(LbTest::class,'group_id','id');
    }

    public function results()
    {
        return $this->hasManyThrough(LbResultDetail::class,LbTest::class,'group_id','test_id','id','id');
    }
}
