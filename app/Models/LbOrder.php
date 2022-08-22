<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LbOrder extends Model
{
    use HasFactory;
    protected $table='lb_orders';


    public function currentOrderByIdentification($identification)
    {
        $order=LbOrder::join('medical_appointments','lb_orders.appo_id','medical_appointments.id')
        ->join('patients','medical_appointments.patient_id','patients.id')
        ->select([
            'lb_orders.*',
            'patients.fullname as patient',
            'patients.gender',
            'patients.cellphone',
            'patients.identification',
            'patients.birth_date'
        ])
        ->where('patients.identification','=',$identification)
        ->orderBy('lb_orders.date','desc')
        ->orderBy('lb_orders.hour','desc')
        ->firstOrFail();
        $tests=LbOrderTest::with('tests')->where('order_id','=',$order->id)->get();
        $order->tests=$tests;
        return $order;
    }
    public function pendingOrdersByIdentification($identification)
    {
        return LbOrder::join('medical_appointments','lb_orders.appo_id','medical_appointments.id')
        ->join('patients','medical_appointments.patient_id','patients.id')
        ->select([
            'lb_orders.*',
        ])
        ->where('patients.identification','=',$identification)
        ->where('lb_orders.is_pending','=',true)
        ->get();
    }

    public function medicalAppointment()
    {
        return $this->belongsTo(MedicalAppointment::class,'appo_id','id');
    }
}
