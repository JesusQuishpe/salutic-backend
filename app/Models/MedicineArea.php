<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class MedicineArea extends Model
{
    use HasFactory;

    protected $table = 'medicine_area';
    protected $fillable = [
        'user_id',
        'nur_id',
        'symptom1',
        'symptom2',
        'symptom3',
        'presumptive1',
        'presumptive2',
        'presumptive3',
        'definitive1',
        'definitive2',
        'definitive3',
        'medicine1',
        'medicine2',
        'medicine3',
        'medicine4',
        'medicine5',
        'medicine6',
        'dosage1',
        'dosage2',
        'dosage3',
        'dosage4',
        'dosage5',
        'dosage6',
        'attended'
    ];

    public function getPatientQueue()
    {
        return DB::table('nursing_area')
            ->join('medical_appointments', 'nursing_area.appo_id', 'medical_appointments.id')
            ->join('patients', 'medical_appointments.patient_id', 'patients.id')
            ->select([
                'nursing_area.id as nur_id',
                'nursing_area.weight',
                'nursing_area.stature',
                'nursing_area.temperature',
                'nursing_area.pressure',
                'patients.id as patient_id',
                'patients.identification_number as identification',
                'patients.name',
                'patients.lastname',
                'patients.gender',
                'patients.fullname',
                'patients.birth_date',
                'medical_appointments.id as appo_id',
                'medical_appointments.date as date',
                'medical_appointments.hour as hour',
                'medical_appointments.area',
            ])
            ->where('medical_appointments.date', '=', Carbon::now()->format('Y-m-d'))
            ->where('medical_appointments.area', '=', 'Medicina')
            ->where('medical_appointments.attended', '=', false)
            ->where('medical_appointments.nur_attended','=',true)
            ->orderBy('medical_appointments.hour','asc')
            ->get();
    }

    public function getMedicineRecordsByIdentification($identification)
    {
        return MedicineArea::join('nursing_area','medicine_area.nur_id','nursing_area.id')
        ->join('medical_appointments','nursing_area.appo_id','medical_appointments.id')
        ->join('patients','medical_appointments.patient_id','patients.id')
        ->select([
            'nursing_area.id as nur_id',
            'nursing_area.doctor',
            'patients.id as patient_id',
            'patients.identification_number',
            'patients.name',
            'patients.lastname',
            'patients.fullname',
            'medical_appointments.id as appo_id',
            'medical_appointments.date',
            'medical_appointments.hour',
            'medicine_area.id as medicine_id',
        ])
        ->where('patients.identification_number','=',$identification)
        ->orderBy('medical_appointments.date','desc')
        ->orderBy('medical_appointments.hour','desc')
        ->get();
    }

    public function getDataOfNursingArea($nurId)
    {
        return NursingArea::join('medical_appointments','nursing_area.appo_id','medical_appointments.id')
        ->join('patients','medical_appointments.patient_id','patients.id')
        ->select([
            'nursing_area.id as nur_id',
            'nursing_area.weight',
            'nursing_area.stature',
            'nursing_area.temperature',
            'nursing_area.pressure',
            'nursing_area.therapy',
            'nursing_area.disability',
            'nursing_area.pregnancy',
            'nursing_area.inyection',
            'nursing_area.healing',
            'nursing_area.doctor',
            'nursing_area.cardiopathy',
            'nursing_area.hypertension',
            'nursing_area.surgeries',
            'nursing_area.diabetes',
            'nursing_area.medicine_allergies',
            'nursing_area.food_allergies',
            'patients.id as patient_id',
            'patients.identification_number',
            'patients.name',
            'patients.lastname',
            'patients.gender',
            'patients.fullname',
            'patients.birth_date',
            'medical_appointments.id as appo_id',
        ])
        ->where('nursing_area.id','=',$nurId)
        ->orderBy('medical_appointments.date','desc')
        ->orderBy('medical_appointments.hour','desc')
        ->firstOrFail();
    }

    public function nursingArea()
    {
        return $this->belongsTo(NursingArea::class,'nur_id','id');
    }
}
