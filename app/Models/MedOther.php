<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedOther extends Model
{
    use HasFactory;
    protected $table="med_others";
    protected $fillable=[
      'work_authonomy', //Autonomia en el trabajo
      'work_shift', //Turno en el trabajo
      'hobbies', //Actividades que realiza en tiempos libres
      'other_situations'
    ];
    protected $hidden = [
      'created_at',
      'updated_at'
  ];
}
