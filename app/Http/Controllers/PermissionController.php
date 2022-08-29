<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PermissionController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {
    if ($request->has('module_id') && $request->has('rol_id')) {
      $permissions = Permission::where('rol_id', $request->rol_id)
        ->where('module_id', $request->module_id)
        ->get();
      return response()->json($permissions);
    }
  }


  public function getIdsToRemove($submodules, $permissions)
  {
    $deletedIds = [];
    foreach ($permissions as $moduleId) {
      if (!in_array($moduleId, $submodules)) {
        array_push($deletedIds, $moduleId);
      }
    }
    return $deletedIds;
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
      $submodules = $request->input('submodules', []);
      $permissions = Permission::join('system_modules', 'permissions.module_id', '=', 'system_modules.id')
        ->where('rol_id', $request->rol_id)
        ->where('system_modules.parent_id', $request->module_id)
        ->get();
      //return response()->json($permissions);
      $permissions = collect($permissions);

      DB::beginTransaction();
      if (count($submodules) > 0) {
        foreach ($submodules as $submoduleId) {
          if (count($permissions) > 0) {
            $permissionsMapped = collect($permissions)->map(function ($per) {
              return $per->module_id;
            });
            $ids = $this->getIdsToRemove($submodules, $permissionsMapped);
            foreach ($ids as $id) {
              Permission::where('rol_id', $request->rol_id)->where('module_id', $id)->delete();
            }
            if (!in_array($submoduleId, array_column($permissions->toArray(), 'module_id'))) {
              $model = new Permission();
              $model->rol_id = $request->rol_id;
              $model->module_id = $submoduleId;
              $model->save();
            }
          } else {
            $model = new Permission();
            $model->rol_id = $request->rol_id;
            $model->module_id = $submoduleId;
            $model->save();
          }
        }
      } else {
        Permission::join('system_modules', 'permissions.module_id', '=', 'system_modules.id')
          ->where('rol_id', $request->rol_id)
          ->where('system_modules.parent_id', $request->module_id)
          ->delete();
      }
      DB::commit();
      return response()->json([], 200);
    } catch (\Throwable $th) {
      DB::rollBack();
      throw $th;
    }
  }


  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\Permission  $permission
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, Permission $permission)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\Permission  $permission
   * @return \Illuminate\Http\Response
   */
  public function destroy(Permission $permission)
  {
    //
  }
}
