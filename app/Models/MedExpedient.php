<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class MedExpedient extends Model
{
  use HasFactory;
  protected $table = 'med_expedients';
  protected $fillable = [
    'patient_id',
    'date',
    'hour'
  ];



  public function patient()
  {
    return $this->belongsTo(Patient::class, 'patient_id', 'id');
  }

  public function patientRecord()
  {
    return $this->hasOne(MedFamilyHistory::class, 'record_id', 'id');
  }
  public function physicalExploration()
  {
    return $this->hasOne(MedPhysicalExploration::class, 'record_id', 'id');
  }
  public function interrogation()
  {
    return $this->hasOne(MedInterrogation::class, 'record_id', 'id');
  }
  public function lifeStyle()
  {
    return $this->hasOne(MedLifestyle::class, 'record_id', 'id');
  }
  public function allergies()
  {
    return $this->hasOne(MedAllergie::class, 'record_id', 'id');
  }

  public function getPatientQueue()
  {
    return DB::table('nursing_area')
      ->join('medical_appointments', 'nursing_area.appo_id', 'medical_appointments.id')
      ->join('patients', 'medical_appointments.patient_id', 'patients.id')
      ->select([
        'nursing_area.id as nur_id',
        'patients.id as patient_id',
        'patients.identification',
        'patients.fullname',
        'medical_appointments.id as appo_id',
        'medical_appointments.date as date',
        'medical_appointments.hour as hour',
      ])
      ->where('medical_appointments.date', '=', Carbon::now()->format('Y-m-d'))
      ->where('medical_appointments.area', '=', 'Medicina')
      ->where('medical_appointments.attended', '=', false)
      ->where('medical_appointments.nur_attended', '=', true)
      ->orderBy('medical_appointments.hour', 'asc')
      ->get();
  }

  /**
   * The attributes that should be hidden for serialization.
   *
   * @var array<int, string>
   */
  protected $hidden = [
    //'password',
    'created_at',
    'updated_at'
  ];
}
