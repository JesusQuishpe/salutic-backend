<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OdoStomatognathicTest extends Model
{
    use HasFactory;
    protected $table = 'odo_stomatognathic_tests';

    public function details()
    {
        return $this->hasMany(OdoStomatognathicDetail::class, 'sto_test_id', 'id');
    }
}
