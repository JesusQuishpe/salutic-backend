<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LbOrderTest extends Model
{
    use HasFactory;
    protected $table='lb_order_tests';

    public function test()
    {
        return $this->belongsTo(LbTest::class,'test_id','id');
    }
}
