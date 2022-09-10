<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class NursingArea extends Model
{
  use HasFactory;
  protected $table = 'nursing_area';
  protected $fillable = [
    'user_id',
    'appo_id',
    'weight',
    'stature',
    'temperature',
    'pressure',
    'imc',
    'imc_diagnostic',
    'breathing_frequency',
    'heart_frequency',
    'disability',
    'attended'
  ];



  public function getPatientQueue()
  {
    return DB::table('medical_appointments')
      ->join('patients', 'medical_appointments.patient_id', 'patients.id')
      ->select(
        [
          'medical_appointments.id as appoId',
          'patients.fullname',
          'patients.identification',
          'medical_appointments.area',
          'medical_appointments.date',
          'medical_appointments.hour'
        ]
      )
      ->where('medical_appointments.date', '=', Carbon::now()->format('Y-m-d'))
      ->where('medical_appointments.area', '!=', 'Laboratorio')
      ->where('medical_appointments.attended', '=', false)
      ->where('medical_appointments.nur_attended', '=', false)
      ->where('medical_appointments.nur_cancelled', '=', false)
      ->orderBy('medical_appointments.hour', 'asc')
      ->get();
  }

  public function searchByIdentification($identification)
  {
    return NursingArea::join('medical_appointments', 'appo_id', '=', 'medical_appointments.id')
      ->join('patients', 'medical_appointments.patient_id', '=', 'patients.id')
      ->select([
        'medical_appointments.id as appo_id',
        'medical_appointments.date',
        'medical_appointments.hour',
        'nursing_area.id as nur_id',
        'patients.fullname as patient'
      ])
      ->where('patients.identification', '=', $identification)
      ->get();
  }
  public function medicalAppointment()
  {
    return $this->belongsTo(MedicalAppointment::class, 'appo_id', 'id');
  }

  public static function create(array $attributes = [])
  {
    $attributes['attended'] = true;
    $model = static::query()->create($attributes);
    return $model;
  }
  public function getHistoryByIdentification($identification,$startDate,$endDate)
  {

    if($startDate && $endDate){
      return NursingArea::join('medical_appointments', 'appo_id', '=', 'medical_appointments.id')
      ->join('patients', 'medical_appointments.patient_id', '=', 'patients.id')
      ->select([
        'medical_appointments.id as appo_id',
        'nursing_area.id as nur_id',
        'medical_appointments.date',
        'medical_appointments.hour',
        'patients.fullname as patient'
      ])
      ->where('patients.identification', '=', $identification)
      ->paginate(10);
    }
    


    return NursingArea::join('medical_appointments', 'appo_id', '=', 'medical_appointments.id')
      ->join('patients', 'medical_appointments.patient_id', '=', 'patients.id')
      ->select([
        'medical_appointments.id as appo_id',
        'nursing_area.id as nur_id',
        'medical_appointments.date',
        'medical_appointments.hour',
        'patients.fullname as patient'
      ])
      ->where('patients.identification', '=', $identification)
      ->paginate(3);
  }
}
