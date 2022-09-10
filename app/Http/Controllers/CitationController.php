<?php

namespace App\Http\Controllers;

use App\Models\LbOrder;
use App\Models\LbOrderTest;
use App\Models\LbResult;
use App\Models\LbResultDetail;
use App\Models\MedConsultation;
use App\Models\MedConsultationCie;
use App\Models\MedConsultationPrescription;
use App\Models\MedicalAppointment;
use App\Models\MedicineArea;
use App\Models\NursingArea;
use App\Models\OdoCpoCeoRatio;
use App\Models\OdoDiagnostic;
use App\Models\OdoDiagnosticPlan;
use App\Models\OdoFamilyHistory;
use App\Models\OdoFamilyHistoryDetail;
use App\Models\OdoIndicator;
use App\Models\OdoIndicatorDetail;
use App\Models\OdoMovilitieRecession;
use App\Models\OdoOdontogram;
use App\Models\OdoPatientRecord;
use App\Models\OdoPlanDetail;
use App\Models\OdoStomatognathicDetail;
use App\Models\OdoStomatognathicTest;
use App\Models\OdoTeethDetail;
use App\Models\OdoTreatment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Throwable;

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
   * @param  \App\Models\MedicalAppointment  $citation
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
   * @param  \App\Models\MedicalAppointment  $citation
   * @return \Illuminate\Http\Response
   */
  public function destroy(MedicalAppointment $citation)
  {
    try {
      DB::beginTransaction();
      $nur = NursingArea::where('appo_id', '=', $citation->id)->first();
      if ($nur) {
        if ($citation->area === "Medicina") {
          $med = MedConsultation::where('nur_id', '=', $nur->id)->first();
          if ($med) {
            MedConsultationCie::where('consultation_id', $med->id)->delete();
            MedConsultationPrescription::where('consultation_id', $med->id)->delete();
          }
          $med->delete();
        }
        if ($citation->area === "Odontologia") {
          $record = OdoPatientRecord::where('nur_id', '=', $nur->id)->first();
          if ($record) {
            //Falta eliminar acta y odontograma imagen
            $familyHistory = OdoFamilyHistory::where('rec_id', '=', $record->id)->firstOrFail();
            $familyDetails = OdoFamilyHistoryDetail::where('fam_id', '=', $familyHistory->id);
            $stomatognathic = OdoStomatognathicTest::where('rec_id', '=', $record->id)->firstOrFail();
            $stomatognathicDetails = OdoStomatognathicDetail::where('sto_test_id', '=', $stomatognathic->id);
            $indicator = OdoIndicator::where('rec_id', '=', $record->id)->firstOrFail();
            $indicatorDetails = OdoIndicatorDetail::where('id_ind', '=', $indicator->id);
            $cpoCeoRatio = OdoCpoCeoRatio::where('rec_id', '=', $record->id)->firstOrFail();
            $diagnosticPlan = OdoDiagnosticPlan::where('rec_id', '=', $record->id)->firstOrFail();
            $planDetails = OdoPlanDetail::where('diag_plan_id', '=', $diagnosticPlan->id);
            $diagnostics = OdoDiagnostic::where('rec_id', '=', $record->id);
            $treatments = OdoTreatment::where('rec_id', '=', $record->id);
            $odontogram = OdoOdontogram::where('rec_id', '=', $record->id)->firstOrFail();
            $teeth = OdoTeethDetail::where('odo_id', '=', $odontogram->id);
            $movilitiesReccesions = OdoMovilitieRecession::where('odo_id', '=', $odontogram->id);

            $movilitiesReccesions->delete();
            $teeth->delete();
            $odontogram->delete();
            $treatments->delete();
            $diagnostics->delete();
            $planDetails->delete();
            $diagnosticPlan->delete();
            $cpoCeoRatio->delete();
            $indicatorDetails->delete();
            $indicator->delete();
            $stomatognathicDetails->delete();
            $stomatognathic->delete();
            $familyDetails->delete();
            $familyHistory->delete();
            //Eliminar actas y odontogramas archivos
            if (Storage::exists($record->odontogram_path)) {
              Storage::delete($record->odontogram_path);
            }
            if (Storage::exists($record->acta_path)) {
              Storage::delete($record->acta_path);
            }
            $record->delete();
          }
        }
        $nur->delete();
      }

      if ($citation->area === "Laboratorio") {
        $order = LbOrder::where('appo_id', '=', $citation->id)->first();
        //dd($order);
        if ($order) {
          $orderTests = LbOrderTest::where('order_id', '=', $order->id);
          $result = LbResult::where('order_id', '=', $order->id)->first();
          if ($result) {
            $resultDetails = LbResultDetail::where('result_id', '=', $result->id);
            $resultDetails->delete();
            $result->delete();
          }
          $orderTests->delete();
          $order->delete();
        }
      }

      $citation->delete();
      DB::commit();
      return response()->json([], 204);
    } catch (Throwable $th) {
      try {
        DB::rollBack();
      } catch (\Throwable $th) {
        throw $th;
      }
      throw $th;
    }
  }
  public function search(Request $request)
  {
    //return response()->json($request->all());
    $citation = (new MedicalAppointment())->newQuery();
    $citation->join('patients', 'medical_appointments.patient_id', '=', 'patients.id')
      ->select([
        'medical_appointments.*',
        'patients.fullname',
        'patients.identification'
      ]);
    if ($request->input('start_date') !== null && $request->input('end_date') !== null) {
      $startDate = Carbon::createFromFormat('Y-m-d', $request->input('start_date'));
      $endDate = Carbon::createFromFormat('Y-m-d', $request->input('end_date'));
      $citation->whereBetween('medical_appointments.created_at', [$startDate, $endDate]);
    }
    if ($request->input('state_filter')) {
      $citation->where('medical_appointments.attended', $request->input('state_filter') === 'atendidas' ? true : false);
    }
    if ($request->input('identification')) {
      $citation->where('patients.identification', $request->input('identification'));
    }
    $citation->orderBy('medical_appointments.created_at', 'desc');
    return $this->toPagination($citation->paginate(10));
  }
}
