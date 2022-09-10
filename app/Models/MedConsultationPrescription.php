<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedConsultationPrescription extends Model
{
  use HasFactory;
  protected $table = "med_consultation_prescriptions";

  public function medicine()
  {
    return $this->belongsTo(Medicine::class, 'medicine_id', 'id');
  }
}
