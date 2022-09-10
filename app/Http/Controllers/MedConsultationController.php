<?php

namespace App\Http\Controllers;

use App\Models\MedConsultation;
use App\Models\MedConsultationCie;
use App\Models\MedConsultationPrescription;
use App\Models\MedicalAppointment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MedConsultationController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {
    if ($request->has('new_consultation') && $request->has('appo_id')) {
      $appo = MedicalAppointment::where('id', $request->appo_id)
        ->where('area', 'Medicina')
        ->firstOrFail();
      $date = Carbon::now()->format('Y-m-d');
      if ($appo->attended === 1) {
        return response()->json(['message' => 'La cita ya ha sido atendida'], 404);
      }
      if ($appo->date !== $date) {
        return response()->json(['message' => 'La cita ya ha execedido su tiempo límite'], 404);
      }
      if ($appo->nur_cancelled === 1) {
        return response()->json(['message' => 'La cita ha sido cancelada desde el area de enfermeria'], 404);
      }
      if ($appo->nur_attended === 0) {
        return response()->json(['message' => 'El paciente debe pasar por el area de enfermeria'], 404);
      }

      $data = MedConsultation::getDataForNewConsultation($request->appo_id);
      return response()->json($data);
    }
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    try {
      DB::beginTransaction();
      $consultation = MedConsultation::create($request->all());
      if ($request->has('cies')) {
        foreach ($request->input('cies') as $cie) {
          $model = new MedConsultationCie();
          $model->consultation_id = $consultation->id;
          $model->cie_id = $cie['cie_id'];
          $model->disease_state = $cie['disease_state'];
          $model->severity = $cie['severity'];
          $model->active_disease = $cie['active_disease'];
          $model->infectious_disease = $cie['infectious_disease'];
          $model->diagnostic_date = $cie['diagnostic_date'];
          $model->observations = $cie['observations'];
          $model->diagnostic_age = $cie['diagnostic_age'];
          $model->cured = $cie['cured'];
          $model->allergic_disease = $cie['allergic_disease'];
          $model->allergy_type = $cie['allergy_type'];
          $model->warnings_during_pregnancy = $cie['warnings_during_pregnancy'];
          $model->week_contracted = $cie['week_contracted'];
          $model->currently_in_treatment = $cie['currently_in_treatment'];
          $model->aditional_information = $cie['aditional_information'];
          $model->save();
        }
      }
      if ($request->has('prescriptions')) {
        foreach ($request->input('prescriptions') as $prescription) {
          $model = new MedConsultationPrescription();
          $model->consultation_id = $consultation->id;
          $model->medicine_id = $prescription['medicine_id'];
          $model->dosification = $prescription['dosification'];
          $model->save();
        }
      }

      $appo = MedicalAppointment::findOrFail($request->appo_id);
      $appo->attended = true;
      $appo->save();
      DB::commit();
      return response()->json($consultation);
    } catch (\Throwable $th) {
      DB::rollBack();
      throw $th;
    }
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\MedConsultation  $consultation
   * @return \Illuminate\Http\Response
   */
  public function show($consultation_id)
  {
    $consultation = MedConsultation::with('cies.cie', 'prescriptions.medicine', 'nursingArea.medicalAppointment.patient')->findOrFail($consultation_id);
    return response()->json($consultation);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\MedConsultation  $consultation
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, MedConsultation $consultation)
  {
    try {
      DB::beginTransaction();
      $consultation->user_id = $request->user_id;
      $consultation->date = $request->date;
      $consultation->hour = $request->hour;
      $consultation->consultation_type = $request->consultation_type;
      $consultation->reason_consultation = $request->reason_consultation;
      $consultation->symptoms = $request->symptoms;
      $consultation->apparatus_and_systems = $request->apparatus_and_systems;
      $consultation->physical_exploration = $request->physical_exploration;
      $consultation->laboratory_studies = $request->laboratory_studies;
      $consultation->diagnostics = $request->diagnostics;
      $consultation->treatments = $request->treatments;
      $consultation->save();
      if ($request->has('cies')) {
        MedConsultationCie::where('consultation_id', $consultation->id)->delete();
        foreach ($request->cies as $cie) {
          $model = new MedConsultationCie();
          $model->consultation_id = $consultation->id;
          $model->cie_id = $cie['cie_id'];
          $model->disease_state = $cie['disease_state'];
          $model->severity = $cie['severity'];
          $model->active_disease = $cie['active_disease'];
          $model->infectious_disease = $cie['infectious_disease'];
          $model->diagnostic_date = $cie['diagnostic_date'];
          $model->observations = $cie['observations'];
          $model->diagnostic_age = $cie['diagnostic_age'];
          $model->cured = $cie['cured'];
          $model->allergic_disease = $cie['allergic_disease'];
          $model->allergy_type = $cie['allergy_type'];
          $model->warnings_during_pregnancy = $cie['warnings_during_pregnancy'];
          $model->week_contracted = $cie['week_contracted'];
          $model->currently_in_treatment = $cie['currently_in_treatment'];
          $model->aditional_information = $cie['aditional_information'];
          $model->save();
        }
      }
      if ($request->has('prescriptions')) {
        MedConsultationPrescription::where('consultation_id', $consultation->id)->delete();
        foreach ($request->input('prescriptions') as $prescription) {
          $model = new MedConsultationPrescription();
          $model->consultation_id = $consultation->id;
          $model->medicine_id = $prescription['medicine_id'];
          $model->dosification = $prescription['dosification'];
          $model->save();
        }
      }
      DB::commit();
      return response()->json([], 204);
    } catch (\Throwable $th) {
      DB::rollBack();
      throw $th;
    }
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\MedConsultation  $consultation
   * @return \Illuminate\Http\Response
   */
  public function destroy(MedConsultation $consultation)
  {
    try {
      DB::beginTransaction();
      MedConsultationCie::where('consultation_id', $consultation->id)->delete();
      MedConsultationPrescription::where('consultation_id', $consultation->id)->delete();
      $consultation->delete();
      DB::commit();
      return response()->json([], 204);
    } catch (\Throwable $th) {
      throw $th;
    }
  }

  public function removeOfQueue($appoId)
  {
    $appo = MedicalAppointment::findOrFail($appoId);
    $appo->med_cancelled = true;
    $appo->save();
    return response()->json([], 204);
  }

  public function search(Request $request)
  {
    $med = (new MedConsultation())->newQuery()
      ->join('nursing_area', 'med_consultations.nur_id', '=', 'nursing_area.id')
      ->join('medical_appointments', 'nursing_area.appo_id', '=', 'medical_appointments.id')
      ->select([
        'med_consultations.id',
        'med_consultations.consultation_type',
        'med_consultations.date',
        'med_consultations.hour',
      ]);
    if ($request->input('start_date') && $request->input('end_date')) {
      $startDate = Carbon::createFromFormat('Y-m-d', $request->input('start_date'));
      $endDate = Carbon::createFromFormat('Y-m-d', $request->input('end_date'));
      $med->whereBetween('med_consultations.created_at', [$startDate, $endDate]);
    }
    if ($request->input('patient_id')) {
      $med->where('medical_appointments.patient_id', $request->input('patient_id'));
    }
    return $this->toPagination($med->paginate(2));
  }
}
