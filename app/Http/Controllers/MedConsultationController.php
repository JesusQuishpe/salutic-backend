<?php

namespace App\Http\Controllers;

use App\Models\MedConsultation;
use App\Models\MedConsultationCie;
use App\Models\MedicalAppointment;
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
      $data = MedConsultation::getDataForNewConsultation($request->appo_id);
      return response()->json($data);
    }

    if ($request->has('patient_id')) {
      $data = MedConsultation::getConsultationsOfPatient($request->patient_id);
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
      $appo=MedicalAppointment::findOrFail($request->appo_id);
      $appo->attended=true;
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
    $consultation = MedConsultation::with('cies.cie', 'nursingArea.medicalAppointment.patient')->findOrFail($consultation_id);
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
      DB::commit();
      return response()->json([],204);
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
    //
  }
}
