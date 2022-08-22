<?php

namespace App\Http\Controllers;

use App\Models\LbOrder;
use App\Models\LbOrderTest;
use App\Models\MedAllergie;
use App\Models\MedFamilyHistory;
use App\Models\MedicalAppointment;
use App\Models\MedicalRecord;
use App\Models\MedInterrogation;
use App\Models\MedLifestyle;
use App\Models\MedPhysicalExploration;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
