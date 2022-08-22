<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedConsultation extends Model
{
    use HasFactory;
    protected $table="med_consultations";
    protected $fillable=[
        'user_id',
        'nur_id',
        'date',
        'hour',
        'consultation_type',
        'reason_consultation',
        'symptoms',
        'apparatus_and_systems',
        'physical_exploration',
        'diagnostics',
        'laboratory_studies',
        'treatments'
    ];

    public static function getConsultationsOfPatient($patientId)
    {
        return MedConsultation::join('nursing_area','med_consultations.nur_id','=','nursing_area.id')
        ->join('medical_appointments','nursing_area.appo_id','=','medical_appointments.id')
        ->join('patients','medical_appointments.patient_id','=','patients.id')
        ->select([
            'patients.id as patient_id',
            'medical_appointments.id as appo_id',
            'nursing_area.id as nur_id',
            'nursing_area.weight',
            'nursing_area.temperature',
            'nursing_area.stature',
            'nursing_area.pressure',
            'med_consultations.*',
        ])
        //->where('users.id',$userId)
        ->where('patients.id',$patientId)
        ->get();
    }

    public static function getDataForNewConsultation($appoId)
    {
      $medicalAppo=MedicalAppointment::with('patient','nursingArea')->findOrFail($appoId);
      return $medicalAppo;
    }

    public function cies()
    {
      return $this->hasMany(MedConsultationCie::class,'consultation_id','id');
    }
    public function nursingArea()
    {
      return $this->belongsTo(NursingArea::class,'nur_id','id');
    }
}
