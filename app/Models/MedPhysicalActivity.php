<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedPhysicalActivity extends Model
{
    use HasFactory;
    protected $table="med_physical_activity";
    protected $fillable=[
      'do_exercise',
      'min_per_day',
      'do_sport',
      'sport_description',
      'sport_frequency',
      'sleep',
      'sleep_hours',
    ];
    protected $hidden = [
      'created_at',
      'updated_at'
  ];
}
