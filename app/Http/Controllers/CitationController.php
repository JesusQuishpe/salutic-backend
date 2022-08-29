<?php

namespace App\Http\Controllers;

use App\Models\MedicalAppointment;
use Illuminate\Http\Request;

use function PHPUnit\Framework\isNull;

class CitationController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {
    $model = new MedicalAppointment();

   /*return response()->json([
    $request->query('start_date'),
    $request->query('end_date'),
    $request->query('state_filter'),
    $request->query('identification'),
   ]);*/
    if (
      $request->has('start_date')
      && $request->has('end_date')
      && $request->has('state_filter')
      && $request->has('identification')
    ) {
      $results = $model->getCitationsByFilters($request->start_date, 
      $request->end_date, 
      $request->input('state_filter',null), 
      $request->identification);
      return $this->toPagination($results);
    }
    if ($request->has('identification')) {
      return $this->toPagination($model->getCitationsByIdentification($request->identification));
    }
    return $this->toPagination($model->getCitationsWithFullname());
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $model = new MedicalAppointment();
    $citation = $model->createCitation($request);
    return response()->json($citation);
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\MedicalAppointment  $medicalAppointment
   * @return \Illuminate\Http\Response
   */
  public function show(MedicalAppointment $citation)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\MedicalAppointment  $citation
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, MedicalAppointment $citation)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\MedicalAppointment  $medicalAppointment
   * @return \Illuminate\Http\Response
   */
  public function destroy(MedicalAppointment $medicalAppointment)
  {
    //
  }
}
