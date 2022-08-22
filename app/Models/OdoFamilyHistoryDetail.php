<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OdoFamilyHistoryDetail extends Model
{
    use HasFactory;
    protected $table='odo_family_history_details';
    protected $fillable=[
        'fam_id',
        'disease_id'
    ];
}
