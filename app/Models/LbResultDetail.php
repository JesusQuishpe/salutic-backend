<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LbResultDetail extends Model
{
    use HasFactory;
    protected $table='lb_result_details';

    public function test()
    {
        return $this->belongsTo(LbTest::class,'test_id','id');
    }

    public function exam()
    {
        return $this->belongsTo(LbResult::class,'result_id','id');
    }
}
