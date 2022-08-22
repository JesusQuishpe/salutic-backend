<?php

namespace App\Http\Controllers;

use App\Models\Rol;
use Illuminate\Http\Request;

class RolController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $roles = Rol::all();
    return response()->json($roles);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $rol = new Rol();
    $rol->name = $request->name;
    $rol->save();
    return response()->json($rol);
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\Rol  $rol
   * @return \Illuminate\Http\Response
   */
  public function show(Rol $rol)
  {
    return response()->json($rol);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\Rol  $rol
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, Rol $rol)
  {
    $rol->name = $request->name;
    $rol->save();
    return response()->json($rol);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\Rol  $rol
   * @return \Illuminate\Http\Response
   */
  public function destroy(Rol $rol)
  {
    $rol->delete();
    return response()->json([], 204);
  }
}
