<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedSmoking extends Model
{
    use HasFactory;
    protected $table="med_smoking";
    protected $fillable=[
      'smoke',
      'start_smoking_age',
      'former_smoker',
      'cigars_per_day',
      'passive_smoker',
      'stop_smoking_age',
    ];
    protected $hidden = [
      'created_at',
      'updated_at'
  ];
}
