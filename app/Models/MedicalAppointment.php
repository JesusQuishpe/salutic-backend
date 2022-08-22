<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MedicalAppointment extends Model
{
  use HasFactory;
  protected $table = 'medical_appointments';
  protected $fillable = [
    'user_id',
    'date',
    'hour',
    'appo_identification_number',
    'area',
    'value',
    'initial_value',
    //'factura_cita',
    //'estado_cita',
    'patient_id',
    //'statistics',
    'attended'
  ];

  protected $hidden = [
    'created_at',
    'updated_at'
  ];

  public function patient()
  {
    return $this->belongsTo(Patient::class, 'patient_id', 'id');
  }

  public function nursingArea()
  {
    return $this->hasOne(NursingArea::class,'appo_id','id');
  }

  public function getCitationsWithFullname()
  {
    return MedicalAppointment::join('patients', 'medical_appointments.patient_id', '=', 'patients.id')
      ->select([
        'medical_appointments.*',
        'patients.fullname'
      ])
      ->paginate(10);
  }

  public function getCitationsByIdentification($identification)
  {
    return MedicalAppointment::join('patients', 'medical_appointments.patient_id', '=', 'patients.id')
      ->select([
        'medical_appointments.*',
        'patients.fullname'
      ])
      ->where('patients.identification_number', $identification)
      ->paginate(10);
  }

  public function createCitation(Request $request)
  {
    $date = Carbon::now()->format('Y-m-d');
    $hour = Carbon::now()->format('H:i:s');

    try {
      DB::beginTransaction();
      $appo = MedicalAppointment::create([
        'user_id' => $request->user_id,
        'date' => $date,
        'hour' => $hour,
        'area' => $request->area,
        'value' => $request->value,
        'initial_value' => $request->value,
        'patient_id' => $request->patient_id,
      ]);

      $tests = $request->input('tests');
      //Agregamos las pruebas en caso de que el area sea laboratorio y haya tests
      if (
        $request->area === 'Laboratorio' &&
        $tests && count($tests) > 0
      ) {
        //Se crea la orden de laboratorio
        $order = new LbOrder();
        $order->appo_id = $appo->id;
        $order->date = $date;
        $order->hour = $hour;
        $order->test_items = count($tests);
        $order->total = $request->value;
        $order->save();
        //Agregamos las pruebas  a la orden
        foreach ($tests as $test) {
          $newTest = new LbOrderTest();
          $newTest->order_id = $order->id;
          $newTest->test_id = $test['id'];
          $newTest->price = $test['price'];
          $newTest->save();
        }
      }

      //Si va al area de medicina,se crea un expediente vacio
      if ($request->area === 'Medicina') {
        $existRecord = MedExpedient::where('patient_id', '=', $request->patient_id)->first();
        if (!$existRecord) {
          //Creamos el expediente o registro medico
          $medRecord = new MedExpedient();
          $medRecord->patient_id = $request->patient_id;
          $medRecord->date = $date;
          $medRecord->hour = $hour;
          $medRecord->save();
          //Antecedentes
          $medFam = new MedFamilyHistory();
          $medFam->record_id = $medRecord->id;
          $medFam->pathological = "";
          $medFam->noPathological = "";
          $medFam->perinatal = "";
          $medFam->gynecological = "";
          $medFam->save();
          //Exploracion fisica
          $medPhy = new MedPhysicalExploration();
          $medPhy->record_id = $medRecord->id;
          $medPhy->outer_habitus = "";
          $medPhy->head = "";
          $medPhy->eyes = "";
          $medPhy->otorhinolaryngology = "";
          $medPhy->neck = "";
          $medPhy->chest = "";
          $medPhy->abdomen = "";
          $medPhy->gynecological_examination = "";
          $medPhy->genitals = "";
          $medPhy->spine = "";
          $medPhy->extremities = "";
          $medPhy->neurological_examination = "";
          $medPhy->save();
          //Interrogatorio
          $medIn = new MedInterrogation();
          $medIn->record_id = $medRecord->id;
          $medIn->cardiovascular = "";
          $medIn->digestive = "";
          $medIn->endocrine = "";
          $medIn->hemolymphatic = ""; //hemolinfatico
          $medIn->mamas = "";
          $medIn->skeletal_muscle = ""; //musculo esqueletico
          $medIn->skin_and_annexes = ""; //Piel y anexos
          $medIn->reproductive = ""; //Reproductor
          $medIn->respiratory = ""; //respiratorio
          $medIn->nervous_system = ""; //sistema nervioso
          $medIn->general_systems = ""; //sistemas generales
          $medIn->urinary = ""; //urninario
          $medIn->save();
          //Estilo de vida
          $medLife = new MedLifestyle();
          $medLife->record_id = $medRecord->id;
          $medLife->save();
          //Alergias
          $medAler = new MedAllergie();
          $medAler->record_id = $medRecord->id;
          $medAler->description = "";
          $medAler->save();
        }
      }
      DB::commit();
      return $appo;
    } catch (\Throwable $th) {
      DB::rollBack();
      throw $th;
    }
  }
}
