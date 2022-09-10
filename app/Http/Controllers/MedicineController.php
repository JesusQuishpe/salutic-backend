<?php

namespace App\Http\Controllers;

use App\Models\Medicine;
use Illuminate\Http\Request;

class MedicineController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $results = Medicine::paginate(10);
    return $this->toPagination($results);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $medicine = new Medicine();
    $medicine->generic_name = $request->generic_name;
    $medicine->comercial_name = $request->comercial_name;
    $medicine->pharmaceutical_form = $request->pharmaceutical_form;
    $medicine->presentation = $request->presentation;
    $medicine->save();
    return response()->json($medicine, 204);
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\Medicine  $medicine
   * @return \Illuminate\Http\Response
   */
  public function show(Medicine $medicine)
  {
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\Medicine  $medicine
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, Medicine $medicine)
  {
    $medicine->generic_name = $request->generic_name;
    $medicine->comercial_name = $request->comercial_name;
    $medicine->pharmaceutical_form = $request->pharmaceutical_form;
    $medicine->presentation = $request->presentation;
    $medicine->save();
    return response()->json([], 204);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\Medicine  $medicine
   * @return \Illuminate\Http\Response
   */
  public function destroy(Medicine $medicine)
  {
    $medicine->delete();
    return response()->json([], 204);
  }

  public function search(Request $request)
  {
    //return response()->json($request->all());
    $medicine = (new Medicine())->newQuery();

    if ($request->input('medicine_name')) {
      $medicine->where('generic_name', 'LIKE', '%' . $request->input('medicine_name') . '%')
        ->orWhere('comercial_name', 'LIKE', '%' . $request->input('medicine_name') . '%');
    }
    return $this->toPagination($medicine->paginate(10));
  }
}
