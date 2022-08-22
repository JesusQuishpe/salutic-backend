<?php

namespace App\Http\Controllers;

use App\Models\LbMeasurement;
use Illuminate\Http\Request;

class LbUnitController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $units = LbMeasurement::all();
    return response()->json($units);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $unit=new LbMeasurement();
    $unit->name=$request->name;
    $unit->abbreviation=$request->abbreviation;
    $unit->save();
    return response()->json($unit);
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\LbMeasurement  $unit
   * @return \Illuminate\Http\Response
   */
  public function show(LbMeasurement $unit)
  {
    return response()->json($unit);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\LbMeasurement  $unit
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, LbMeasurement $unit)
  {
    $unit->name=$request->name;
    $unit->abbreviation=$request->abbreviation;
    $unit->save();
    return response()->json($unit);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\LbMeasurement  $unit
   * @return \Illuminate\Http\Response
   */
  public function destroy(LbMeasurement $unit)
  {
    $unit->delete();
    return response()->json([],204);
  }
}
