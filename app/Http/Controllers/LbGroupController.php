<?php

namespace App\Http\Controllers;

use App\Models\LbGroup;
use Illuminate\Http\Request;

class LbGroupController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $groups = LbGroup::with('area')->get();
    return response()->json($groups);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $group = new LbGroup();
    $group->code = $request->code;
    $group->name = $request->name;
    $group->area_id = $request->area_id;
    $group->price = $request->price;
    $group->save();
    return response()->json($group);
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\LbGroup  $group
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    $group=LbGroup::with('area')->find($id);
    return response()->json($group);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\LbGroup  $group
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, LbGroup $group)
  {
    $group->code = $request->code;
    $group->name = $request->name;
    $group->area_id = $request->area_id;
    $group->price = $request->price;
    $group->save();
    return response()->json($group);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\LbGroup  $group
   * @return \Illuminate\Http\Response
   */
  public function destroy(LbGroup $group)
  {
    $group->delete();
    return response()->json([], 204);
  }
}
