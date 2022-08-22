<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {

    //Permiso submodulos caja
    $permission = new Permission();
    $permission->rol_id = 1;
    $permission->module_id = 7;
    $permission->checked = true;
    $permission->save();

    $permission = new Permission();
    $permission->rol_id = 1;
    $permission->module_id = 8;
    $permission->checked = true;
    $permission->save();



    //Permiso submodulos de Enfermeria
    $permission = new Permission();
    $permission->rol_id = 1;
    $permission->module_id = 9;
    $permission->checked = true;
    $permission->save();

    $permission = new Permission();
    $permission->rol_id = 1;
    $permission->module_id = 10;
    $permission->checked = true;
    $permission->save();

    //Permiso submodulos medicina
    $permission = new Permission();
    $permission->rol_id = 1;
    $permission->module_id = 11;
    $permission->checked = true;
    $permission->save();

    $permission = new Permission();
    $permission->rol_id = 1;
    $permission->module_id = 12;
    $permission->checked = true;
    $permission->save();

    //Permiso submodulos de odontologia
    $permission = new Permission();
    $permission->rol_id = 1;
    $permission->module_id = 13;
    $permission->checked = true;
    $permission->save();

    $permission = new Permission();
    $permission->rol_id = 1;
    $permission->module_id = 14;
    $permission->checked = true;
    $permission->save();


    //Modulo laboratorio

    //Submodulos
    $permission = new Permission();
    $permission->rol_id = 1;
    $permission->module_id = 15;
    $permission->checked = true;
    $permission->save();

    $permission = new Permission();
    $permission->rol_id = 1;
    $permission->module_id = 16;
    $permission->checked = true;
    $permission->save();

    $permission = new Permission();
    $permission->rol_id = 1;
    $permission->module_id = 17;
    $permission->checked = true;
    $permission->save();

    $permission = new Permission();
    $permission->rol_id = 1;
    $permission->module_id = 18;
    $permission->checked = true;
    $permission->save();

    $permission = new Permission();
    $permission->rol_id = 1;
    $permission->module_id = 19;
    $permission->checked = true;
    $permission->save();

    $permission = new Permission();
    $permission->rol_id = 1;
    $permission->module_id = 20;
    $permission->checked = true;
    $permission->save();



    //Permiso submodulos de mantenimiento
    $permission = new Permission();
    $permission->rol_id = 1;
    $permission->module_id = 21;
    $permission->checked = true;
    $permission->save();

    $permission = new Permission();
    $permission->rol_id = 1;
    $permission->module_id = 22;
    $permission->checked = true;
    $permission->save();

    $permission = new Permission();
    $permission->rol_id = 1;
    $permission->module_id = 23;
    $permission->checked = true;
    $permission->save();

    $permission = new Permission();
    $permission->rol_id = 1;
    $permission->module_id = 24;
    $permission->checked = true;
    $permission->save();
  }
}
