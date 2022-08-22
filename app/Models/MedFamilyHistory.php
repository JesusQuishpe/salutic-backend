<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedFamilyHistory extends Model
{
    use HasFactory;
    protected $table='med_family_history';
    protected $hidden = [
        'created_at',
        'updated_at'
    ];
    protected $fillable=[
        'pathological',
        'no_pathological',
        'perinatal',
        'gynecological',
    ];
}
