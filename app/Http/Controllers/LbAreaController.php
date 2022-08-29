<?php

namespace App\Http\Controllers;

use App\Models\LbArea;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class LbAreaController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {
    if ($request->has('groups') && $request->has('tests')) {
      $areas = LbArea::with('groups:id,code,name,price,area_id', 'groups.tests:id,code,name,price,group_id')->get();
      return response()->json($areas);
    }

    $areas = LbArea::all();
    return response()->json($areas);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $area = new LbArea();
    $area->code = $request->code;
    $area->name = $request->name;
    $area->price = $request->price;
    $area->save();
    return response()->json($area);
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\LbArea  $lbArea
   * @return \Illuminate\Http\Response
   */
  public function show(LbArea $area)
  {
    return response()->json($area);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\LbArea  $lbArea
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, LbArea $area)
  {
    $area->code = $request->code;
    $area->name = $request->name;
    $area->price = $request->price;
    $area->save();
    return response()->json($area);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\LbArea  $lbArea
   * @return \Illuminate\Http\Response
   */
  public function destroy(LbArea $area)
  {
    $area->delete();
    return response()->json([], 204);
  }
}
