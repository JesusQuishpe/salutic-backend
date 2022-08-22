<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OdoPatientRecord extends Model
{
  use HasFactory;
  protected $table = 'odo_patient_records';

  public static function getPatientQueue()
  {
    return NursingArea::join('medical_appointments', 'nursing_area.appo_id', 'medical_appointments.id')
      ->join('patients', 'medical_appointments.patient_id', 'patients.id')
      ->select([
        'nursing_area.id as nur_id',
        'patients.identification',
        'patients.fullname as patient',
        'medical_appointments.date',
        'medical_appointments.hour',
        'medical_appointments.id as appo_id'
      ])
      //->where('nursing_area.attended', '=', true)
      ->where('medical_appointments.attended', '=', false)
      ->where('medical_appointments.nur_attended', '=', true)
      ->where('medical_appointments.area', '=', 'Odontologia')
      ->where('medical_appointments.date', '=', Carbon::now()->format('Y-m-d'))
      ->orderBy('medical_appointments.hour', 'asc')
      ->get();
  }


  public function getPatientRecordData($rec_id)
  {

    $patientRecord = OdoPatientRecord::with('nursingArea.medicalAppointment.patient')->find($rec_id);
    //dd($patientRecord);
    $nur = $patientRecord->nursingArea;
    $appo = $nur->medicalAppointment;
    $patient = $appo->patient;
    $familyHistory = OdoFamilyHistory::with('details')->where('rec_id', '=', $patientRecord->id)->first();
    $stomatognathicTest = OdoStomatognathicTest::with('details')->where('rec_id', '=', $patientRecord->id)->first();
    $indicator = OdoIndicator::with('details')->where('rec_id', '=', $patientRecord->id)->first();
    $cpoCeoRatios = OdoCpoCeoRatio::where('rec_id', '=', $patientRecord->id)->first();
    $planDiagnostic = OdoDiagnosticPlan::with('details.plan')->where('rec_id', '=', $patientRecord->id)->first();
    $diagnostics = OdoDiagnostic::with('cie')->where('rec_id', '=', $patientRecord->id)->get();
    $treatments = OdoTreatment::where('rec_id', '=', $patientRecord->id)->get();
    $odontogram = OdoOdontogram::with('teeth.symbologie', 'movilitiesRecessions')
      ->where('rec_id', '=', $patientRecord->id)->first();

    $diseaseList = OdoDiseaseList::all();
    $pathologies = OdoPathologie::all();
    $plans = OdoPlan::all();
    $cies = Cie::all();
    $teeth = OdoTooth::all();

    $result = [
      'patient' => $patient,
      'patient_record' => $patientRecord,
      'nursingArea' => $nur,
      'diseaseList' => $diseaseList,
      'pathologies' => $pathologies,
      'plans' => $plans,
      'cies' => $cies,
      'teeth' => $teeth,
      'familyHistory' => $familyHistory,
      'stomatognathicTest' => $stomatognathicTest,
      'indicator' => $indicator,
      'cpoCeoRatios' => $cpoCeoRatios,
      'planDiagnostic' => $planDiagnostic,
      'diagnostics' => $diagnostics,
      'treatments' => $treatments,
      'odontogram' => $odontogram
    ];

    return $result;
  }

  public static function getLastOdontogram($patientId)
  {
    //Para obtener el ultimo odontograma
    $odontologyModel = OdoPatientRecord::join('nursing_area', 'odo_patient_records.nur_id', '=', 'nursing_area.id')
      ->join('medical_appointments', 'nursing_area.appo_id', '=', 'medical_appointments.id')
      ->select([
        'odo_patient_records.*'
      ])
      ->where('medical_appointments.patient_id', '=', $patientId)
      ->where('medical_appointments.attended', '=', true)
      ->orderBy('odo_patient_records.date', 'desc')
      ->orderBy('odo_patient_records.hour', 'desc')
      ->skip(0)
      ->take(1)
      ->first();
    $odontogram = null;
    if ($odontologyModel) {
      $odontogram = OdoOdontogram::with('teeth.symbologie', 'movilitiesRecessions')->where('rec_id', '=', $odontologyModel->id)->first();
    }
    return $odontogram;
  }

  public static function getDataForNewConsultation($appo_id)
  {
    $appo = MedicalAppointment::findOrFail($appo_id);
    if ($appo->attended === 1) {
      return ['attended' => true, 'message' => 'La cita ya ha sido atendida'];
    }
    $patient = $appo->patient;
    $nur = NursingArea::where('appo_id', '=', $appo->id)->firstOrFail();
    $disease_list = OdoDiseaseList::all();
    $pathologies = OdoPathologie::all();
    $plans = OdoPlan::all();
    $cies = Cie::take(10)->get();
    $teeth = OdoTooth::all();
    $symbologies = OdoSymbologie::all();
    $odontogram = static::getLastOdontogram($patient->id);

    return [
      'appo_id' => $appo_id,
      'patient' => $patient,
      'nursing_info' => $nur,
      'disease_list' => $disease_list,
      'pathologies' => $pathologies,
      'plans' => $plans,
      'cies' => $cies,
      'teeth' => $teeth,
      'symbologies' => $symbologies,
      'odontogram' => $odontogram
    ];
  }

  public static function getMedicalHistoryByIdentification($identification)
  {
    $result = OdoPatientRecord::join('nursing_area', 'nur_id', '=', 'nursing_area.id')
      ->join('medical_appointments', 'nursing_area.appo_id', '=', 'medical_appointments.id')
      ->join('patients', 'medical_appointments.patient_id', '=', 'patients.id')
      ->select([
        'medical_appointments.id as appo_id',
        'odo_patient_records.id as rec_id',
        'patients.fullname as patient',
        'odo_patient_records.date',
        'odo_patient_records.hour',
        'nursing_area.id as nur_id'
      ])
      ->where('patients.identification', '=', $identification)
      ->get();
    return $result;
  }

  public function nursingArea()
  {
    return $this->belongsTo(NursingArea::class, 'nur_id', 'id');
  }
}
