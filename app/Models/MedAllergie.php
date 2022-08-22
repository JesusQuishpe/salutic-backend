<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedAllergie extends Model
{
    use HasFactory;
    protected $table='med_allergies';

    protected $hidden = [
        'created_at',
        'updated_at'
    ];
    protected $fillable=[
        'alergies'
    ];
}
