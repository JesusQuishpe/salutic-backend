<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedFeedingHabit extends Model
{
    use HasFactory;
    protected $table="med_feeding_habits";
    protected $fillable=[
      'breakfast',
      'meals_per_day',
      'drink_coffe',
      'cups_per_day',
      'drink_soda',
      'do_diet',
      'diet_description'
    ];
    protected $hidden = [
      'created_at',
      'updated_at'
  ];
}
