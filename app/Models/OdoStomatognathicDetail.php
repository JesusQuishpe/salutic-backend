<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OdoStomatognathicDetail extends Model
{
    use HasFactory;
    protected $table='odo_stomatognathic_details';
    protected $fillable=[
        'sto_test_id',
        'pat_id'
    ];
}
