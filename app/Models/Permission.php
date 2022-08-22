<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Permission extends Model
{
  use HasFactory;
  protected $table = 'permissions';
  protected $fillable = [
    'rol_id',
    'module_id',
    'checked'
  ];
  protected $hidden = [
    'created_at',
    'updated_at'
  ];



  public function module()
  {
    return $this->belongsTo(SystemModule::class, 'module_id', 'id');
  }
  public function modules()
  {
    return $this->hasMany(SystemModule::class, 'module_id', 'id');
  }

  public function getPermissionsByRol($idRol)
  {
    $permissions = [];

    $modules = DB::table('permissions')
      ->join('system_modules', 'permissions.module_id', 'system_modules.id')
      ->select([
        'permissions.id as permission_id',
        'permissions.module_id',
        'permissions.rol_id',
        'permissions.checked',
        'system_modules.name',
        'system_modules.path',
        'system_modules.parent_id'
      ])
      ->where('system_modules.parent_id', '=', null)
      ->where('permissions.rol_id', '=', $idRol)
      ->where('permissions.checked', '=', true)
      ->get();

    foreach ($modules as $module) {
      $submodules = DB::table('permissions')
        ->join('system_modules', 'permissions.module_id', 'system_modules.id')
        ->select([
          'permissions.id as permission_id',
          'permissions.module_id',
          'permissions.rol_id',
          'system_modules.name',
          'permissions.checked',
          'system_modules.path',
          'system_modules.parent_id'
        ])
        ->where('system_modules.parent_id', '=', $module->module_id)
        ->where('permissions.rol_id', '=', $idRol)
        ->get();

      $module->submodules = $submodules;
      array_push($permissions, $module);
    }

    return $permissions;
  }

  public function getPermissions()
  {
    $permissions = [];

    $modules = DB::table('permissions')
      ->join('system_modules', 'permissions.module_id', 'system_modules.id')
      ->select([
        'permissions.id as permission_id',
        'permissions.module_id',
        'permissions.rol_id',
        'system_modules.name',
        'permissions.checked',
        'system_modules.path',
        'system_modules.parent_id'
      ])
      ->where('system_modules.parent_id', '=', null)
      ->get();

    foreach ($modules as $module) {
      $submodules = DB::table('permissions')
        ->join('system_modules', 'permissions.module_id', 'system_modules.id')
        ->select([
          'permissions.id as permission_id',
          'permissions.module_id',
          'permissions.rol_id',
          'system_modules.name',
          'permissions.checked',
          'system_modules.path',
          'system_modules.parent_id'
        ])
        ->where('system_modules.parent_id', '=', $module->module_id)
        ->get();

      $module->submodules = $submodules;
      array_push($permissions, $module);
    }

    return $permissions;
  }
}
