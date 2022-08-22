<?php

namespace App\Http\Controllers;

use App\Models\LbArea;
use App\Models\LbGroup;
use App\Models\LbOrder;
use App\Models\LbResult;
use App\Models\LbResultDetail;
use App\Models\MedicalAppointment;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LbResultController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->has('identification')) {
            $model = new LbResult();
            $results = $model->resultsByIdentification($request->input('identification'));
            return response()->json($results);
        }
        if ($request->has('patient_id')) {
            $model = new LbResult();
            $results = $model->getResultsByPatientId($request->input('patient_id'));
            return response()->json($results);
        }
        if($request->has('result_id') && $request->has('result_details')){
            $model=new LbResult();
            $data=$model->getResultadosByAreaJSON($request->input('result_id'));
            return response()->json($data);
        }
        return response()->json(LbResult::all());
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
            $date = Carbon::now()->format('Y-m-d');
            $hour = Carbon::now()->format('H:i:s');
            $order_id = $request->input('order_id');
            $new_result = new LbResult();
            $new_result->order_id = $order_id;
            $new_result->date = $date;
            $new_result->hour = $hour;
            $new_result->save();
            $tests = $request->input('tests');
            foreach ($tests as $test) {
                $new_detail = new LbResultDetail();
                $new_detail->result_id = $new_result->id;
                $new_detail->test_id = $test['id'];
                if (array_key_exists('result', $test)) {
                    if ($test['is_numeric'] === 1) {
                        $new_detail->numeric_result = $test['result'];
                        $new_detail->string_result = null;
                    } else {
                        $new_detail->string_result = $test['result'];
                        $new_detail->numeric_result = null;
                    }
                } else {
                    $new_detail->string_result = null;
                    $new_detail->numeric_result = null;
                }
                if (array_key_exists('remarks', $test)) {
                    $new_detail->remarks = $test['remarks'];
                } else {
                    $new_detail->remarks = null;
                }
                $new_detail->save();
            }
            $order = LbOrder::find($order_id);
            $order->is_pending = false;
            $order->save();

            $appo = MedicalAppointment::find($order->appo_id);
            $appo->attended = true;
            $appo->save();
            DB::commit();
            return response()->json(['message'=>'Resultados guardados']);
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\LbResult  $lb_result
     * @return \Illuminate\Http\Response
     */
    public function show($resultId)
    {
        $model = new LbResult();
        $results = $model->results($resultId);
        return response()->json($results);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\LbResult  $lb_result
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, LbResult $lb_result)
    {
        try {
            DB::beginTransaction();
            $tests = $request->input('tests');
            foreach ($tests as $test) {
                $resultFinded = LbResultDetail::find($test['detail_id']);
                if (array_key_exists('result', $test)) {
                    if ($test['is_numeric'] === 1) {
                        $resultFinded->numeric_result = $test['result'];
                        $resultFinded->string_result = null;
                    } else {
                        $resultFinded->string_result = $test['result'];
                        $resultFinded->numeric_result = null;
                    }
                } else {
                    $resultFinded->string_result = null;
                    $resultFinded->numeric_result = null;
                }
                if (array_key_exists('remarks', $test)) {
                    $resultFinded->remarks = $test['remarks'];
                } else {
                    $resultFinded->remarks = null;
                }
                $resultFinded->save();
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
     * @param  \App\Models\LbResult  $lb_result
     * @return \Illuminate\Http\Response
     */
    public function destroy(LbResult $lb_result)
    {
        try {
            DB::beginTransaction();
            $tests = LbResultDetail::where('result_id', '=', $lb_result->id)->get();
            foreach ($tests as $test) {
                $test->delete();
            }
            $lb_result->delete();
            //Falta eliminar la cita
            DB::commit();
            return response()->json([],204);
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            throw $th;
        }
    }
}
