<?php

namespace App\Http\Controllers;

use App\Models\MedAllergie;
use App\Models\MedExpedient;
use App\Models\MedFamilyHistory;
use App\Models\MedFeedingHabit;
use App\Models\MedInterrogation;
use App\Models\MedLifestyle;
use App\Models\MedOther;
use App\Models\MedPhysicalActivity;
use App\Models\MedPhysicalExploration;
use App\Models\MedSmoking;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ExpedientController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {
    if ($request->has('queue')) {
      $model = new MedExpedient();
      $result = $model->getPatientQueue();
      return response()->json($result);
    }
    if ($request->has('identification')) {
      return MedExpedient::join('patients', 'patient_id', '=', 'patients.id')
        ->select([
          'med_expedients.id as id',
          'patients.id as patient_id',
          'patients.identification',
          'patients.city',
          'patients.fullname'
        ])
        ->where('patients.identification', $request->identification)
        ->first();
    }
    //Return all expedients paginated with 10
    $expedients = MedExpedient::join('patients', 'patient_id', '=', 'patients.id')
      ->select([
        'med_expedients.id as id',
        'patients.id as patient_id',
        'patients.identification',
        'patients.city',
        'patients.fullname'
      ])
      ->paginate(10);
    return $this->toPagination($expedients);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    //
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\MedExpedient  $expedient
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    return response()->json(
      MedExpedient::with(
        ['patient', 
        'patientRecord', 
        'physicalExploration', 
        'interrogation', 
        'physicalActivity', 
        'smoking',
        'feedingHabits',
        'others',
        'allergies']
      )->findOrFail($id)
    );
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\MedExpedient  $expedient
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, MedExpedient $expedient)
  {
    try {
      DB::beginTransaction();
      $recId = $request->input('id'); //Expedient Id
      $patient = $request->input('patient');
      $fullname = $patient['name'] . ' ' . $patient['lastname'];
      $patient['fullname'] = $fullname;
      //Actualizamos la informacion del paciente, personal y adicional
      Patient::find($patient['id'])->update($patient);
      //Actualizamos los antecedentes
      MedFamilyHistory::where('record_id', $recId)->update($request->input('patient_record'));
      //Actualizamos la exploracion fisica
      MedPhysicalExploration::where('record_id', $recId)->update($request->input('physical_exploration'));
      //Actualizamos el interrogatorio
      MedInterrogation::where('record_id', $recId)->update($request->input('interrogation'));
      //Actualizamos el estilo de vida
      //MedLifestyle::where('record_id', $recId)->update($request->input('lifestyle'));
      MedPhysicalActivity::where('record_id',$recId)->update($request->input('physical_activity'));
      MedSmoking::where('record_id',$recId)->update($request->input('smoking'));
      MedFeedingHabit::where('record_id',$recId)->update($request->input('feeding_habits'));
      MedOther::where('record_id',$recId)->update($request->input('others'));
      //Actualizamos las alergias
      $alergieModel = MedAllergie::where('record_id', $recId)->firstOrFail();
      $alergieModel->description = $request->input('allergies.description');
      $alergieModel->save();
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
   * @param  \App\Models\MedExpedient  $expedient
   * @return \Illuminate\Http\Response
   */
  public function destroy(MedExpedient $expedient)
  {
    try {
      DB::beginTransaction();
      MedFamilyHistory::where('record_id', $expedient->id)->delete();
      MedPhysicalExploration::where('record_id', $expedient->id)->delete();
      MedInterrogation::where('record_id', $expedient->id)->delete();
      MedLifestyle::where('record_id', $expedient->id)->delete();
      MedAllergie::where('record_id', $expedient->id)->delete();
      $expedient->delete();
      DB::commit();
      return response()->json([],204);
    } catch (\Throwable $th) {
      DB::rollBack();
      throw $th;
    }
  }
}
