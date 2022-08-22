<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedConsultationCie extends Model
{
    use HasFactory;
    protected $table='med_consultation_cies';
    protected $fillable=[
        'consultation_id',
        'cie_id',
        'disease_state',
        'severity',
        'active_disease',
        'infectious_disease',
        'diagnostic_date',
        'observations',
        'diagnostic_age',
        'cured',
        'allergic_disease',
        'allergy_type',
        'warnings_during_pregnancy',
        'week_contracted',
        'currently_in_treatment',
        'aditional_information',
    ];

    public function cie()
    {
      return $this->belongsTo(Cie::class,'cie_id','id');
    }
}
