<?php

namespace App\Http\Controllers;

use App\Models\MedicalAppointment;
use App\Models\NursingArea;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
    $nursing->user_id = $request->user_id;
    $nursing->appo_id = $request->appo_id;
    $nursing->weight = $request->weight;
    $nursing->stature = $request->stature;
    $nursing->temperature = $request->temperature;
    $nursing->pressure = $request->pressure;
    $nursing->imc = $request->imc;
    $nursing->imc_diagnostic = $request->imc_diagnostic;
    $nursing->breathing_frequency = $request->breathing_frequency;
    $nursing->heart_frequency = $request->heart_frequency;
    $nursing->disability = $request->disability;
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
    $appo = MedicalAppointment::findOrFail($appoId);
    $appo->nur_cancelled = true;
    $appo->save();
    return response()->json([], 204);
  }

  public function search(Request $request)
  {
    //return response()->json($request->all());
    $nur = (new NursingArea())->newQuery();
    $nur->join('medical_appointments', 'nursing_area.appo_id', '=', 'medical_appointments.id')
      ->join('patients', 'medical_appointments.patient_id', '=', 'patients.id')
      ->select([
        'patients.fullname as patient',
        'patients.identification',
        DB::raw('DATE_FORMAT(nursing_area.created_at,"%d/%m/%Y") as date'),
        DB::raw('TIME(nursing_area.created_at) as hour'),
        'medical_appointments.id as appo_id',
        'nursing_area.id as nur_id'
      ]);
    if ($request->input('start_date')!==null && $request->input('end_date')!==null) {
      $startDate=Carbon::createFromFormat('Y-m-d', $request->input('start_date'));
      $endDate=Carbon::createFromFormat('Y-m-d', $request->input('end_date'));
      $nur->whereBetween('nursing_area.created_at',[$startDate,$endDate]);
    }
    if ($request->input('identification')) {
      $nur->where('patients.identification', $request->input('identification'));
    }
    $nur->orderBy('nursing_area.created_at','desc');
    return $this->toPagination($nur->paginate(3));
  }
}
