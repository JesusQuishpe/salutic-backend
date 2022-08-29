<?php

namespace App\Http\Controllers;

use App\Models\MedicalAppointment;
use App\Models\NursingArea;
use Illuminate\Http\Request;

class NursingController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {
    $model = new NursingArea();
    if ($request->has('history')) {
      return response()->json($model->getHistoryByIdentification($request->identification));
    }
    $queue = $model->getPatientQueue();
    return response()->json($queue);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $record = NursingArea::create($request->all());
    $appo = MedicalAppointment::findOrFail($request->appo_id);
    $appo->nur_attended = true;
    $appo->save();
    return response()->json($record);
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\NursingArea  $nursing
   * @return \Illuminate\Http\Response
   */
  public function show(NursingArea $nursing)
  {
    return response()->json($nursing);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\NursingArea  $nursing
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, NursingArea $nursing)
  {
    $nursing->user_id=$request->user_id;
    $nursing->appo_id=$request->appo_id;
    $nursing->weight=$request->weight;
    $nursing->stature=$request->stature;
    $nursing->temperature=$request->temperature;
    $nursing->pressure=$request->pressure;
    $nursing->imc=$request->imc;
    $nursing->imc_diagnostic=$request->imc_diagnostic;
    $nursing->breathing_frequency=$request->breathing_frequency;
    $nursing->heart_frequency=$request->heart_frequency;
    $nursing->disability=$request->disability;
    $nursing->save();
    return response()->json($nursing);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\NursingArea  $nursing
   * @return \Illuminate\Http\Response
   */
  public function destroy(NursingArea $nursing)
  {
    //
  }

  public function removeOfQueue($appoId)
  {
    $appo=MedicalAppointment::findOrFail($appoId);
    $appo->nur_cancelled=true;
    $appo->save();
    return response()->json([],204);
  }
}
