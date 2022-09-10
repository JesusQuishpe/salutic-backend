<?php

namespace App\Http\Controllers;

use App\Models\Cie;
use App\Models\MedicalAppointment;
use App\Models\OdoCpoCeoRatio;
use App\Models\OdoDiagnostic;
use App\Models\OdoDiagnosticPlan;
use App\Models\OdoDiseaseList;
use App\Models\OdoFamilyHistory;
use App\Models\OdoFamilyHistoryDetail;
use App\Models\OdoIndicator;
use App\Models\OdoIndicatorDetail;
use App\Models\OdoMovilitieRecession;
use App\Models\OdoOdontogram;
use App\Models\OdoPathologie;
use App\Models\OdoPatientRecord;
use App\Models\OdoPlan;
use App\Models\OdoPlanDetail;
use App\Models\OdoStomatognathicDetail;
use App\Models\OdoStomatognathicTest;
use App\Models\OdoSymbologie;
use App\Models\OdoTeethDetail;
use App\Models\OdoTooth;
use App\Models\OdoTreatment;
use Carbon\Carbon;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class OdontologyController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {
    if ($request->query('q') === "queue") {
      $queue = OdoPatientRecord::getPatientQueue();
      return response()->json($queue);
    }
    if ($request->query('q') === "data" && $request->has('appo_id')) {
      $appo = MedicalAppointment::where('id', $request->appo_id)
        ->where('area', 'Odontologia')
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
      $data = OdoPatientRecord::getDataForNewConsultation($request->input('appo_id'));
      return response()->json($data);
    }
    if ($request->query('q') === 'history' && $request->has('identification')) {
      $data = OdoPatientRecord::getMedicalHistoryByIdentification(($request->input('identification')));
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
    $date = Carbon::now()->format('Y-m-d');
    $hour = Carbon::now()->format('H:i:s');

    $actaPath = null;
    $odontogramPath = null;
    $odontogramClientBaseName = null;
    $actaClientBaseName = null;

    try {
      DB::beginTransaction();
      if ($request->hasFile('odontogram_image')) {
        $odontogramPath = $request->file('odontogram_image')->store('public/odontogramas');
        $odontogramClientBaseName = $request->file('odontogram_image')->getClientOriginalName();
      } else {
        return response()->json(['message' => 'No se ha podido cargar la imagen del odontograma'], 409);
      }
      //Guardamos el acta de constitucion si existe
      if ($request->hasFile('acta')) {
        $actaPath = $request->file('acta')->store('public/actas');
        $actaClientBaseName = $request->file('acta')->getClientOriginalName();
      }

      $data = json_decode($request->input('data'), true);
      $record = new OdoPatientRecord();
      $record->date = $date;
      $record->hour = $hour;
      $record->age_range = $data['general_info']['age_range'];
      $record->reason_consultation = $data['general_info']['reason_consultation'];
      $record->current_disease_and_problems = $data['general_info']['current_disease_and_problems'];
      $record->nur_id = $data['nur_id'];
      $record->user_id = $data['user_id'];
      $record->odontogram_path = $odontogramPath;
      $record->odontogram_client_basename = $odontogramClientBaseName;
      $record->acta_client_basename = $actaClientBaseName;
      $record->acta_path = $actaPath ? $actaPath : null;
      $record->attended = true;
      $record->value = $data['general_info']['value'];
      $record->save();
      //Guardamos los antecedentes familiares
      $familyHistoryModel = new OdoFamilyHistory();
      $familyHistoryModel->description = $data['family_history']['family_history_description'];
      $familyHistoryModel->rec_id = $record->id;
      $familyHistoryModel->save();
      //Detalles de los antecedentes familiares
      foreach ($data['family_history']['selected_family_history'] as $detailId) {
        $familyHistoryDetailModel = new OdoFamilyHistoryDetail();
        $familyHistoryDetailModel->fam_id = $familyHistoryModel->id;
        $familyHistoryDetailModel->disease_id = $detailId;
        $familyHistoryDetailModel->save();
      }
      //Guardamos el examen stomatognatico
      $stomatognathicModel = new OdoStomatognathicTest();
      $stomatognathicModel->rec_id = $record->id;
      $stomatognathicModel->description = $data['family_history']['pathologies_description'];
      $stomatognathicModel->save();
      //Detalles del examen stomatognatico (patologias seleccionadas)
      foreach ($data['family_history']['selected_pathologies'] as $detailId) {
        $stomatognathicDetailModel = new OdoStomatognathicDetail();
        $stomatognathicDetailModel->pat_id = $detailId;
        $stomatognathicDetailModel->sto_test_id = $stomatognathicModel->id;
        $stomatognathicDetailModel->save();
      }
      //Guardamos los indicadores de salud bucal
      $indicatorModel = new OdoIndicator();
      $indicatorModel->rec_id = $record->id;
      $indicatorModel->per_disease = $data['indicator']['per_disease'];
      $indicatorModel->bad_occlu = $data['indicator']['bad_occlu'];
      $indicatorModel->fluorosis = $data['indicator']['fluorosis'];
      $indicatorModel->plaque_total = $data['indicator']['plaque_total'];
      $indicatorModel->calc_total = $data['indicator']['calc_total'];
      $indicatorModel->gin_total = $data['indicator']['gin_total'];
      $indicatorModel->save();
      //Guardamos los detalles de los indicadores
      foreach ($data['indicator']['indicators'] as $indicator) {
        $indicatorDetailModel = new OdoIndicatorDetail();
        $indicatorDetailModel->id_ind = $indicatorModel->id;
        $indicatorDetailModel->selected_pieces = implode(',', $indicator['selected_pieces']);
        $indicatorDetailModel->plaque = $indicator['plaque'];
        $indicatorDetailModel->calc = $indicator['calc'];
        $indicatorDetailModel->gin = $indicator['gin'];
        $indicatorDetailModel->row_pos = $indicator['row_pos'];
        $indicatorDetailModel->save();
      }
      //Guardamos los indices
      $cpoCeoRatioModel = new OdoCpoCeoRatio();
      $cpoCeoRatioModel->rec_id = $record->id;
      $cpoCeoRatioModel->cd = $data['cpo_ceo_ratios']['cpo_c'];
      $cpoCeoRatioModel->pd = $data['cpo_ceo_ratios']['cpo_p'];
      $cpoCeoRatioModel->od = $data['cpo_ceo_ratios']['cpo_o'];
      $cpoCeoRatioModel->ce = $data['cpo_ceo_ratios']['ceo_c'];
      $cpoCeoRatioModel->ee = $data['cpo_ceo_ratios']['ceo_e'];
      $cpoCeoRatioModel->oe = $data['cpo_ceo_ratios']['ceo_o'];
      $cpoCeoRatioModel->cpo_total = $data['cpo_ceo_ratios']['cpo_total'];
      $cpoCeoRatioModel->ceo_total = $data['cpo_ceo_ratios']['ceo_total'];
      $cpoCeoRatioModel->save();
      //Guardamos el plan diagnostico
      $diagnosticPlanModel = new OdoDiagnosticPlan();
      $diagnosticPlanModel->rec_id = $record->id;
      $diagnosticPlanModel->description = $data['plan_and_diagnostics']['plan_description'];
      $diagnosticPlanModel->save();
      //Guardamos los detalles del plan diagnostico (viene como un array de ids)
      foreach ($data['plan_and_diagnostics']['selected_plans'] as $planId) {
        $diagnosticPlanDetailModel = new OdoPlanDetail();
        $diagnosticPlanDetailModel->diag_plan_id = $diagnosticPlanModel->id;
        $diagnosticPlanDetailModel->plan_id = $planId;
        $diagnosticPlanDetailModel->save();
      }
      //Guardamos los diagnosticos
      foreach ($data['plan_and_diagnostics']['diagnostics'] as $diagnostic) {
        $diagnosticModel = new OdoDiagnostic();
        $diagnosticModel->rec_id = $record->id;
        $diagnosticModel->cie_id = $diagnostic['cie_id'];
        $diagnosticModel->description = $diagnostic['description'];
        $diagnosticModel->type = $diagnostic['type'];
        $diagnosticModel->save();
      }
      //Guardamos los tratamientos
      foreach ($data['treatments'] as $treatment) {
        $treatmentModel = new OdoTreatment();
        $treatmentModel->rec_id = $record->id;
        $treatmentModel->sesion = $treatment['sesion'];
        $treatmentModel->date = $date;
        $treatmentModel->complications = $treatment['complications'];
        $treatmentModel->procedures = $treatment['procedures'];
        $treatmentModel->prescriptions = $treatment['prescriptions'];
        $treatmentModel->save();
      }
      //Guardar odontograma
      $odontogramModel = new OdoOdontogram();
      $odontogramModel->rec_id = $record->id;
      $odontogramModel->save();
      //Guardar movilidades y recesiones
      foreach ($data['odontogram']['movilities_recessions'] as $item) {
        $movilitieRecessionModel = new OdoMovilitieRecession();
        $movilitieRecessionModel->odo_id = $odontogramModel->id;
        $movilitieRecessionModel->type = $item['type'];
        $movilitieRecessionModel->value = $item['value'];
        $movilitieRecessionModel->pos = $item['pos'];
        $movilitieRecessionModel->save();
      }
      //Guardamos los dientes que han sido llenados
      foreach ($data['odontogram']['teeth'] as $tooth) {
        $toothModel = new OdoTeethDetail();
        $toothModel->odo_id = $odontogramModel->id;
        $toothModel->tooth_id = $tooth['tooth_id'];
        $toothModel->symbo_id = $tooth['symbo_id'];
        $toothModel->top_side = $tooth['top_side'];
        $toothModel->right_side = $tooth['right_side'];
        $toothModel->left_side = $tooth['left_side'];
        $toothModel->bottom_side = $tooth['bottom_side'];
        $toothModel->center_side = $tooth['center_side'];
        //$toothModel->pos = $tooth['pos'];
        $toothModel->save();
      }
      //Actualizar el estado de la cita como atendida
      $appo = MedicalAppointment::find($data['appo_id']);
      $appo->attended = true;
      $appo->value = $appo->initial_value + $record->value;
      $appo->save();
      DB::commit();
      return response()->json([]);
    } catch (\Throwable $th) {
      if (isset($odontogramPath) && Storage::exists($odontogramPath)) {
        Storage::delete($odontogramPath);
      }
      if (isset($actaPath) && Storage::exists($actaPath)) {
        Storage::delete($actaPath);
      }
      try {
        DB::rollBack();
      } catch (\Throwable $th) {
        throw $th;
      }
      throw $th;
    }
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\OdoPatientRecord  $odontology
   * @return \Illuminate\Http\Response
   */
  public function show($rec_id)
  {
    $acta = null;
    $patientRecord = OdoPatientRecord::with('nursingArea.medicalAppointment.patient')->findOrFail($rec_id);
    if ($patientRecord->acta_path) {
      $actaURL = Storage::url($patientRecord->acta_path);
      $info = pathinfo($patientRecord->acta_path);
      //$name = $info['basename'];
      $extension = $info['extension'];
      $acta = [
        'url' => $actaURL,
        'name' => $patientRecord->acta_client_basename,
        'extension' => $extension
      ];
    }

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
    $teeth = OdoTooth::all();
    $cies = Cie::take(10)->get();
    $symbologies = OdoSymbologie::all();

    $result = [
      'appo_id' => $patientRecord->nursingArea->medicalAppointment->id,
      'patient' => $patientRecord->nursingArea->medicalAppointment->patient,
      'patient_record' => $patientRecord,
      'acta' => $acta,
      'nursing_info' => $patientRecord->nursingArea,
      'disease_list' => $diseaseList,
      'pathologies' => $pathologies,
      'plans' => $plans,
      'teeth' => $teeth,
      'family_history' => $familyHistory,
      'stomatognathic_test' => $stomatognathicTest,
      'indicator' => $indicator,
      'cpo_ceo_ratios' => $cpoCeoRatios,
      'plan_diagnostic' => $planDiagnostic,
      'diagnostics' => $diagnostics,
      'treatments' => $treatments,
      'odontogram' => $odontogram,
      'cies' => $cies,
      'symbologies' => $symbologies
    ];
    return response()->json($result);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\OdoPatientRecord  $odontology
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, OdoPatientRecord $odontology)
  {
    $date = Carbon::now()->format('Y-m-d');
    $hour = Carbon::now()->format('H:i:s');

    $actaPath = null;
    $odontogramPath = null;
    $data = json_decode($request->input('data'), true);
    $actaBaseName = basename(Storage::path($odontology->acta_path));
    $odontogramBaseName = basename(Storage::path($odontology->odontogram_path));

    $actaClientBaseName = null;
    $odontogramClientBaseName = null;


    try {

      if ($request->hasFile('odontogram_image')) {
        Storage::move($odontology->odontogram_path, 'public/odontogramas-eliminados/' . $odontogramBaseName);
        $odontogramPath = $request->file('odontogram_image')->store('public/odontogramas');
        $odontogramClientBaseName = $request->file('odontogram_image')->getClientOriginalName();
        if (!$odontogramPath) return response()->json(['message' => 'No se ha podido guardar la imagen del odontograma'], 409);
      } else {
        return response()->json(['message' => 'No se ha podido cargar la imagen del odontograma'], 409);
      }

      //Validamos si a enviado una nueva acta
      if ($request->hasFile('acta')) {
        if ($odontology->acta_path) { //Verificamos si ya ha guardado una acta antes
          //Movemos la anterior acta al directorio actas-eliminadas
          Storage::move($odontology->acta_path, 'public/actas-eliminadas/' . $actaBaseName);
        }
        //Agregamos la nueva
        $actaPath = $request->file('acta')->store('public/actas');
        $actaClientBaseName = $request->file('acta')->getClientOriginalName();
      } else {
        //Eliminamos la acta anterior
        $isActaChanged = $data['is_acta_changed'];

        if ($isActaChanged && $odontology->acta_path) {
          if (Storage::exists($odontology->acta_path)) {
            Storage::delete($odontology->acta_path);
          }
        } else {
          $actaPath = $odontology->acta_path;
          $actaClientBaseName = $odontology->acta_client_basename;
          $odontogramClientBaseName = $odontology->odontogram_client_basename;
        }
      }

      DB::beginTransaction();

      //$record = OdoPatientRecord::find($data['general_info']['id']);
      $odontology->date = $date;
      $odontology->hour = $hour;
      $odontology->age_range = $data['general_info']['age_range'];
      $odontology->reason_consultation = $data['general_info']['reason_consultation'];
      $odontology->current_disease_and_problems = $data['general_info']['current_disease_and_problems'];
      $odontology->user_id = $data['user_id'];
      $odontology->odontogram_path = $odontogramPath;
      $odontology->acta_path = $actaPath;
      $odontology->odontogram_client_basename = $odontogramClientBaseName;
      $odontology->acta_client_basename = $actaClientBaseName;
      $odontology->value = $data['general_info']['value'];
      $odontology->save();

      //Actualizamos los antecedentes familiares
      $familyHistoryModel = OdoFamilyHistory::find($data['family_history']['id']);
      $familyHistoryModel->description = $data['family_history']['family_history_description'];
      $familyHistoryModel->save();

      //Detalles de los antecedentes familiaress
      //Primero eliminamos
      OdoFamilyHistoryDetail::where('fam_id', '=', $familyHistoryModel->id)->delete();
      foreach ($data['family_history']['selected_family_history'] as $diseaseId) {
        $familyHistoryDetailModel = new OdoFamilyHistoryDetail();
        $familyHistoryDetailModel->fam_id = $familyHistoryModel->id;
        $familyHistoryDetailModel->disease_id = $diseaseId; //$item es el disease_id
        $familyHistoryDetailModel->save();
      }

      //Actualizamos el examen stomatognatico
      $stomatognathicModel = OdoStomatognathicTest::find($data['family_history']['sto_test_id']);
      $stomatognathicModel->description = $data['family_history']['pathologies_description'];
      $stomatognathicModel->save();

      //Detalles del examen stomatognatico (patologias seleccionadas)
      //Primero eliminamos
      OdoStomatognathicDetail::where('sto_test_id', '=', $stomatognathicModel->id)->delete();
      foreach ($data['family_history']['selected_pathologies'] as $patId) {
        $stomatognathicDetailModel = new OdoStomatognathicDetail();
        $stomatognathicDetailModel->pat_id = $patId; //item es el pat_id
        $stomatognathicDetailModel->sto_test_id = $stomatognathicModel->id;
        $stomatognathicDetailModel->save();
      }

      //Guardamos los indicadores de salud bucal
      $indicatorModel = OdoIndicator::findOrFail($data['indicator']['id']);
      $indicatorModel->per_disease = $data['indicator']['per_disease'];
      $indicatorModel->bad_occlu = $data['indicator']['bad_occlu'];
      $indicatorModel->fluorosis = $data['indicator']['fluorosis'];
      $indicatorModel->plaque_total = $data['indicator']['plaque_total'];
      $indicatorModel->calc_total = $data['indicator']['calc_total'];
      $indicatorModel->gin_total = $data['indicator']['gin_total'];
      $indicatorModel->save();

      //Guardamos los detalles de los indicadores
      OdoIndicatorDetail::where('id_ind', '=', $indicatorModel->id)->delete();
      foreach ($data['indicator']['indicators'] as $indicator) {
        $detail = new OdoIndicatorDetail();
        $detail->id_ind = $indicatorModel->id;
        $detail->selected_pieces = implode(',', $indicator['selected_pieces']);
        $detail->plaque = $indicator['plaque'];
        $detail->calc = $indicator['calc'];
        $detail->gin = $indicator['gin'];
        $detail->row_pos = $indicator['row_pos'];
        $detail->save();
      }

      //Guardamos los indices
      $cpoCeoRatioModel = OdoCpoCeoRatio::findOrFail($data['cpo_ceo_ratios']['id']);
      $cpoCeoRatioModel->cd = $data['cpo_ceo_ratios']['cpo_c'] ?: 0;
      $cpoCeoRatioModel->pd = $data['cpo_ceo_ratios']['cpo_p'] ?: 0;
      $cpoCeoRatioModel->od = $data['cpo_ceo_ratios']['cpo_o'] ?: 0;
      $cpoCeoRatioModel->ce = $data['cpo_ceo_ratios']['ceo_c'] ?: 0;
      $cpoCeoRatioModel->ee = $data['cpo_ceo_ratios']['ceo_e'] ?: 0;
      $cpoCeoRatioModel->oe = $data['cpo_ceo_ratios']['ceo_o'] ?: 0;
      $cpoCeoRatioModel->cpo_total = $data['cpo_ceo_ratios']['cpo_total'] ?: 0;
      $cpoCeoRatioModel->ceo_total = $data['cpo_ceo_ratios']['ceo_total'] ?: 0;
      $cpoCeoRatioModel->save();

      //Guardamos el plan diagnostico
      $diagnosticPlanModel = OdoDiagnosticPlan::findOrFail($data['plan_and_diagnostics']['id']);
      $diagnosticPlanModel->description = $data['plan_and_diagnostics']['plan_description'];
      $diagnosticPlanModel->save();

      //Guardamos los detalles del plan diagnostico (viene como un array de ids)
      //Primero eliminamos
      OdoPlanDetail::where('diag_plan_id', '=', $diagnosticPlanModel->id)->delete();
      foreach ($data['plan_and_diagnostics']['selected_plans'] as $planId) {
        $diagnosticPlanDetailModel = new OdoPlanDetail();
        $diagnosticPlanDetailModel->diag_plan_id = $diagnosticPlanModel->id;
        $diagnosticPlanDetailModel->plan_id = $planId;
        $diagnosticPlanDetailModel->save();
      }

      //Primero eliminamos los diagnosticos
      OdoDiagnostic::where('rec_id', '=', $odontology->id)->delete();
      foreach ($data['plan_and_diagnostics']['diagnostics'] as $diagnostic) {
        //Guardamos los nuevos diagnosticos
        $diagnosticModel = new OdoDiagnostic();
        $diagnosticModel->rec_id = $odontology->id;
        $diagnosticModel->cie_id = $diagnostic['cie_id'];
        $diagnosticModel->description = $diagnostic['description'];
        $diagnosticModel->type = $diagnostic['type'];
        $diagnosticModel->save();
      }

      //Primero eliminamos los tratamientos
      OdoTreatment::where('rec_id', '=', $odontology->id)->delete();
      //Guardamos los tratamientos
      foreach ($data['treatments'] as $treatment) {
        $treatmentModel = new OdoTreatment();
        $treatmentModel->rec_id = $odontology->id;
        $treatmentModel->sesion = $treatment['sesion'];
        $treatmentModel->date = $date;
        $treatmentModel->complications = $treatment['complications'];
        $treatmentModel->procedures = $treatment['procedures'];
        $treatmentModel->prescriptions = $treatment['prescriptions'];
        $treatmentModel->save();
      }

      //Eliminamos las movilidades y recesiones
      OdoMovilitieRecession::where('odo_id', $data['odontogram']['odontogram_id'])->delete();
      foreach ($data['odontogram']['movilities_recessions'] as $item) {
        //Agregamos las nuevas
        $movilitieRecessionModel = new OdoMovilitieRecession();
        $movilitieRecessionModel->odo_id = $data['odontogram']['odontogram_id'];
        $movilitieRecessionModel->type = $item['type'];
        $movilitieRecessionModel->value = $item['value'];
        $movilitieRecessionModel->pos = $item['pos'];
        $movilitieRecessionModel->save();
      }
      //Eliminamos los dientes que han sido llenados
      OdoTeethDetail::where('odo_id', $data['odontogram']['odontogram_id'])->delete();
      //Insertamos nuevos dientes
      foreach ($data['odontogram']['teeth'] as $tooth) {
        $toothModel = new OdoTeethDetail();
        $toothModel->odo_id = $data['odontogram']['odontogram_id'];
        $toothModel->tooth_id = $tooth['tooth_id'];
        $toothModel->symbo_id = $tooth['symbo_id'];
        $toothModel->top_side = $tooth['top_side'];
        $toothModel->right_side = $tooth['right_side'];
        $toothModel->left_side = $tooth['left_side'];
        $toothModel->bottom_side = $tooth['bottom_side'];
        $toothModel->center_side = $tooth['center_side'];
        $toothModel->save();
      }
      //Actualizar el valor de la cita
      $appo = MedicalAppointment::findOrFail($data['appo_id']);
      $appo->attended = true;
      $appo->value = $appo->initial_value + $odontology->value; //El valor de dos es fijo, corresponde al valor de la consulta
      $appo->save();
      DB::commit();
      //Si todo se completa eliminamos los odontogramas y actas movidos
      Storage::delete('public/odontogramas-eliminados/' . $odontogramBaseName);
      Storage::delete('public/actas-eliminadas/' . $actaBaseName);
      return response()->json([], 204);
    } catch (\Throwable $th) {
      if (isset($odontogramPath) && Storage::exists($odontogramPath)) {
        //Restablecemos el anterior odontograma y eliminamos el nuevo
        Storage::move(
          'public/odontogramas-eliminados/' . $odontogramBaseName,
          $odontology->odontogram_path
        ); //Movemos el antiguo odontograma a su respectivo directorio
        Storage::delete($odontogramPath); //Eliminamos el nuevo odontograma
      }
      if (isset($actaPath) && Storage::exists($actaPath)) {
        //Restablecemos la anterior acta y eliminamos la nueva
        Storage::move(
          'public/actas-eliminadas/' . $actaBaseName,
          $odontology->acta_path
        ); //Movemos la antiguo acta a su respectivo directorio
        Storage::delete($actaPath); //Eliminamos el acta del cliente
      }
      try {
        DB::rollBack();
      } catch (\Throwable $th) {
        throw $th;
      }
      throw $th;
    }
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\OdoPatientRecord  $odontology
   * @return \Illuminate\Http\Response
   */
  public function destroy(OdoPatientRecord $odontology)
  {
    try {
      DB::beginTransaction();
      $familyHistory = OdoFamilyHistory::where('rec_id', '=', $odontology->id)->firstOrFail();
      $familyDetails = OdoFamilyHistoryDetail::where('fam_id', '=', $familyHistory->id);
      $stomatognathic = OdoStomatognathicTest::where('rec_id', '=', $odontology->id)->firstOrFail();
      $stomatognathicDetails = OdoStomatognathicDetail::where('sto_test_id', '=', $stomatognathic->id);
      $indicator = OdoIndicator::where('rec_id', '=', $odontology->id)->firstOrFail();
      $indicatorDetails = OdoIndicatorDetail::where('id_ind', '=', $indicator->id);
      $cpoCeoRatio = OdoCpoCeoRatio::where('rec_id', '=', $odontology->id)->firstOrFail();
      $diagnosticPlan = OdoDiagnosticPlan::where('rec_id', '=', $odontology->id)->firstOrFail();
      $planDetails = OdoPlanDetail::where('diag_plan_id', '=', $diagnosticPlan->id);
      $diagnostics = OdoDiagnostic::where('rec_id', '=', $odontology->id);
      $treatments = OdoTreatment::where('rec_id', '=', $odontology->id);
      $odontogram = OdoOdontogram::where('rec_id', '=', $odontology->id)->firstOrFail();
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
      $odontology->delete();
      //Eliminar actas y odontogramas archivos
      if (Storage::exists($odontology->odontogram_path)) {
        Storage::delete($odontology->odontogram_path);
      }
      if (Storage::exists($odontology->acta_path)) {
        Storage::delete($odontology->acta_path);
      }
      DB::commit();
      return response()->json([], 204);
    } catch (\Throwable $th) {
      try {
        DB::rollBack();
      } catch (\Throwable $th) {
        throw $th;
      }
      throw $th;
    }
  }

  public function removeOfQueue($appoId)
  {
    $appo = MedicalAppointment::findOrFail($appoId);
    $appo->odo_cancelled = true;
    $appo->save();
    return response()->json([], 204);
  }

  public function search(Request $request)
  {
    //return response()->json($request->all());
    $odo = (new OdoPatientRecord())->newQuery();
    $odo->join('nursing_area', 'odo_patient_records.nur_id', '=', 'nursing_area.id')
      ->join('medical_appointments', 'nursing_area.appo_id', '=', 'medical_appointments.id')
      ->join('patients', 'medical_appointments.patient_id', '=', 'patients.id')
      ->select([
        'odo_patient_records.id as rec_id',
        'patients.fullname as patient',
        'patients.identification',
        DB::raw('DATE(odo_patient_records.created_at) as date'),
        DB::raw('TIME(odo_patient_records.created_at) as hour'),
        'medical_appointments.id as appo_id',
        'nursing_area.id as nur_id'
      ]);
    if ($request->input('start_date') !== null && $request->input('end_date') !== null) {
      $startDate = Carbon::createFromFormat('Y-m-d', $request->input('start_date'));
      $endDate = Carbon::createFromFormat('Y-m-d', $request->input('end_date'));
      $odo->whereBetween('odo_patient_records.created_at', [$startDate, $endDate]);
    }
    if ($request->input('identification')) {
      $odo->where('patients.identification', $request->input('identification'));
    }
    $odo->orderBy('odo_patient_records.created_at', 'desc');
    return $this->toPagination($odo->paginate(3));
  }
  public function downloadActa($recId)
  {
    $rec = OdoPatientRecord::find($recId);
    if ($rec->acta_path) {
      $actaStoragePath = Storage::path($rec->acta_path);
      $extension = (new File($actaStoragePath))->getExtension();
      $extension = strtolower($extension);
      switch ($extension) {
        case "pdf":
          $ctype = "application/pdf";
          break;
          /*case "exe": $ctype="application/octet-stream"; break;
        case "zip": $ctype="application/zip"; break;
        case "doc": $ctype="application/msword"; break;
        case "xls": $ctype="application/vnd.ms-excel"; break;
        case "ppt": $ctype="application/vnd.ms-powerpoint"; break;
        case "gif": $ctype="image/gif"; break;*/
        case "png":
          $ctype = "image/png";
          break;
        case "jpeg":
        case "jpg":
          $ctype = "image/jpg";
          break;
        default:
          $ctype = "application/force-download";
      }


      return response()->download($actaStoragePath, 'acta.' . $extension, [
        'Content-type' => $ctype
      ]);
    } else {
      return response("<div>No hay acta disponible para descargar</div>");
    }
  }
  public function getActaFile($recId)
  {
    $rec = OdoPatientRecord::find($recId);
    $actaURL = Storage::url($rec->acta_path);
    //$info = pathinfo($rec->acta_path);
    //$name = $info['basename'];
    //$extension = $info['extension'];
    $data = [
      'url' => $actaURL,
      'name' => $rec->acta_client_basename,
    ];


    //$file=new File($actaURL);
    return response()->json($data);
  }
}
