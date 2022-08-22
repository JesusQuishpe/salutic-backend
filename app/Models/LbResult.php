<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use stdClass;

class LbResult extends Model
{
    use HasFactory;
    protected $table = 'lb_results';

    public function parentable()
    {
        return $this->morphTo();
    }

    public function resultsByIdentification($identification)
    {
        return LbResult::join('lb_orders', 'lb_results.order_id', '=', 'lb_orders.id')
            ->join('medical_appointments', 'lb_orders.appo_id', '=', 'medical_appointments.id')
            ->join('patients','medical_appointments.patient_id','=','patients.id')
            ->select([
                'lb_orders.date',
                'lb_orders.hour',
                'lb_orders.id as order_id',
                'lb_results.id as result_id',
                'lb_orders.test_items',
                'lb_orders.total',
                'patients.fullname as patient'
            ])
            ->where('patients.identification', '=', $identification)
            ->get();
    }

    public function order()
    {
        return $this->belongsTo(LbOrder::class, 'order_id', 'id');
    }

    public function tests()
    {
        return $this->belongsToMany(LbTest::class, 'lb_result_details', 'test_id', 'id')
            ->withPivot('string_result', 'numeric_result', 'remarks');
    }

    public function resultados()
    {
        return $this->hasMany(LbResultDetail::class, 'result_id', 'id');
    }

    public function results($idResult)
    {
        $header = LbResult::join('lb_orders', 'lb_results.order_id', '=', 'lb_orders.id')
            ->join('medical_appointments', 'lb_orders.appo_id', '=', 'medical_appointments.id')
            ->join('patients', 'medical_appointments.patient_id', '=', 'patients.id')
            ->select([
                'lb_results.id as result_id',
                'lb_orders.id as order_id',
                'lb_orders.date as order_date',
                'lb_orders.hour as order_hour',
                'lb_orders.test_items as order_items',
                'lb_orders.total as order_total',
                'patients.fullname as patient',
                'patients.name',
                'patients.lastname',
                'patients.identification',
                'patients.gender',
                'patients.cellphone',
                'patients.address'
            ])
            ->where('lb_results.id', '=', $idResult)
            ->firstOrFail();
        $tests = LbResultDetail::join('lb_tests', 'lb_result_details.test_id', '=', 'lb_tests.id')
            ->select([
                'lb_tests.*',
                'lb_result_details.string_result',
                'lb_result_details.numeric_result',
                'lb_result_details.remarks',
                'lb_result_details.id as detail_id',
            ])
            ->where('lb_result_details.result_id', '=', $header->result_id)
            ->get();
        $header->tests = $tests;
        return $header;
    }

    public function dataToPdf($orderId)
    {
        $order = LbOrder::find($orderId);
        $result = LbResult::where('order_id', '=', $orderId)->first();
        $areas = DB::table('lb_result_details')->join('lb_tests', 'test_id', '=', 'lb_tests.id')
            ->join('lb_groups', 'lb_tests.group_id', '=', 'lb_groups.id')
            ->join('lb_areas', 'lb_groups.area_id', '=', 'lb_areas.id')
            ->select([
                'lb_areas.id',
                'lb_areas.name'
            ])
            ->where('lb_result_details.result_id', '=', $result->id)
            ->distinct()
            ->get();

        $groups = DB::table('lb_result_details')->join('lb_tests', 'test_id', '=', 'lb_tests.id')
            ->join('lb_groups', 'lb_tests.group_id', '=', 'lb_groups.id')
            ->join('lb_areas', 'lb_groups.area_id', '=', 'lb_areas.id')
            ->select([
                'lb_groups.id',
                'lb_groups.area_id',
                'lb_groups.name',
                'lb_groups.showAtPrint'
            ])
            ->where('lb_result_details.result_id', '=', $result->id)
            ->distinct()
            ->get();

        $tests = DB::table('lb_result_details')->join('lb_tests', 'test_id', '=', 'lb_tests.id')
            ->join('lb_groups', 'lb_tests.group_id', '=', 'lb_groups.id')
            ->join('lb_areas', 'lb_groups.area_id', '=', 'lb_areas.id')
            ->leftJoin('lb_measurement', 'lb_tests.measure_id', '=', 'lb_measurement.id')
            ->select([
                'lb_tests.*',
                'lb_measurement.abbreviation',
                'lb_result_details.numeric_result',
                'lb_result_details.string_result'
            ])
            ->where('lb_result_details.result_id', '=', $result->id)
            ->get();

        $resultados = new stdClass();
        foreach ($areas as $area) {
            $newGroups = [];
            foreach ($groups as $group) {
                if ($group->area_id === $area->id) {
                    array_push($newGroups, $group);
                }
                $newTests = [];
                foreach ($tests as $test) {
                    if ($test->group_id === $group->id) {
                        array_push($newTests, $test);
                    }
                }
                $group->tests = $newTests;
            }
            $area->groups = $newGroups;
        }
        $resultados->areas = $areas;
        $resultados->date = $result->date;
        //dd($resultados);
        return $resultados;
    }

    /*public function getResultadosByAreaJSON($resultId)
    {
        return LbArea::with([
            'groups:id,name,area_id',
            'groups.tests:id,name,is_numeric,group_id',
            'groups.tests.result:id,numeric_result,string_result,remarks,test_id,result_id',
        ])
            ->whereHas(
                'groups.tests.result.exam',
                function ($query) use ($resultId) {
                    $query->where('lb_results.id', $resultId);
                }
            )
            ->get();
    }*/

    public function getResultsByPatientId($patientId)
    {
        return LbResult::join('lb_orders', 'lb_results.order_id', '=', 'lb_orders.id')
            ->join('medical_appointments', 'lb_orders.appo_id', '=', 'medical_appointments.id')
            ->select([
                'lb_orders.id as order_id',
                'lb_orders.date as date',
                'lb_orders.test_items as items',
                'lb_results.id as result_id'
            ])
            ->where('medical_appointments.patient_id', $patientId)
            ->get();
    }

    public function getResultadosByAreaJSON($resultId)
    {
        $result = LbResult::find($resultId);
        //Areas que estan relacionadas con los resultados de las pruebas
        $areas = DB::table('lb_result_details')->join('lb_tests', 'test_id', '=', 'lb_tests.id')
            ->join('lb_groups', 'lb_tests.group_id', '=', 'lb_groups.id')
            ->join('lb_areas', 'lb_groups.area_id', '=', 'lb_areas.id')
            ->select([
                'lb_areas.id',
                'lb_areas.name'
            ])
            ->where('lb_result_details.result_id', '=', $result->id)
            ->distinct()
            ->get();
        //Grupos que estan relacionadas con los resultados de las pruebas
        $groups = DB::table('lb_result_details')->join('lb_tests', 'test_id', '=', 'lb_tests.id')
            ->join('lb_groups', 'lb_tests.group_id', '=', 'lb_groups.id')
            ->join('lb_areas', 'lb_groups.area_id', '=', 'lb_areas.id')
            ->select([
                'lb_groups.id',
                'lb_groups.area_id',
                'lb_groups.name',
                'lb_groups.showAtPrint'
            ])
            ->where('lb_result_details.result_id', '=', $result->id)
            ->distinct()
            ->get();
        //Areas que estan relacionadas con los resultados de las pruebas
        $tests = DB::table('lb_result_details')->join('lb_tests', 'test_id', '=', 'lb_tests.id')
            ->join('lb_groups', 'lb_tests.group_id', '=', 'lb_groups.id')
            ->join('lb_areas', 'lb_groups.area_id', '=', 'lb_areas.id')
            ->leftJoin('lb_measurement', 'lb_tests.measure_id', '=', 'lb_measurement.id')
            ->select([
                'lb_tests.*',
                'lb_measurement.abbreviation',
                'lb_result_details.numeric_result',
                'lb_result_details.string_result'
            ])
            ->where('lb_result_details.result_id', '=', $result->id)
            ->get();

        $resultados = new stdClass();
        foreach ($areas as $area) {
            $newGroups = [];
            foreach ($groups as $group) {
                if ($group->area_id === $area->id) {
                    array_push($newGroups, $group);
                }
                $newTests = [];
                foreach ($tests as $test) {
                    if ($test->group_id === $group->id) {
                        array_push($newTests, $test);
                    }
                }
                $group->tests = $newTests;
            }
            $area->groups = $newGroups;
        }
        /*$resultados->areas = $areas;
        $resultados->date = $result->date;*/
        //dd($resultados);
        return $areas;
    }
}
