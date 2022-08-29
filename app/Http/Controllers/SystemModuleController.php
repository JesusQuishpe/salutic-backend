<?php

namespace App\Http\Controllers;

use App\Models\SystemModule;
use Illuminate\Http\Request;

class SystemModuleController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {

    if($request->has('submodules') && $request->has('module_id')){
      $module=SystemModule::findOrFail($request->module_id);
      return response()->json($module->submodules);
    }

    return response()->json(SystemModule::with('submodules.parent')->where('parent_id', null)->get());
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    //
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\Module  $module
   * @return \Illuminate\Http\Response
   */
  public function show(SystemModule $module)
  {
    return response()->json($module);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\Module  $module
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, SystemModule $module)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\Module  $module
   * @return \Illuminate\Http\Response
   */
  public function destroy(SystemModule $module)
  {
    //
  }
}
