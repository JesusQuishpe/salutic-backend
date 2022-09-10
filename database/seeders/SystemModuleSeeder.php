<?php

namespace Database\Seeders;

use App\Models\SystemModule;
use Illuminate\Database\Seeder;

class SystemModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $module = new SystemModule();
        $module->name = 'Caja';
        $module->parent_id = null;
        $module->enable = true;
        $module->canDelete = false;
        $module->path = "/caja";
        $module->save();

        $module = new SystemModule();
        $module->name = 'Enfermeria';
        $module->parent_id = null;
        $module->enable = true;
        $module->canDelete = false;
        $module->path = "/enfermeria";
        $module->save();

        $module = new SystemModule();
        $module->name = 'Medicina';
        $module->parent_id = null;
        $module->enable = true;
        $module->canDelete = false;
        $module->path = "/medicina";
        $module->save();

        $module = new SystemModule();
        $module->name = 'Odontologia';
        $module->parent_id = null;
        $module->enable = true;
        $module->canDelete = false;
        $module->path = "/odontologia";
        $module->save();

        $module = new SystemModule();
        $module->name = 'Laboratorio';
        $module->parent_id = null;
        $module->enable = true;
        $module->canDelete = false;
        $module->path = "/laboratorio";
        $module->save();

        $module = new SystemModule();
        $module->name = 'Mantenimiento';
        $module->parent_id = null;
        $module->enable = true;
        $module->canDelete = false;
        $module->path = "/mantenimiento";
        $module->save();

        //Submodulos de caja
        $module = new SystemModule();
        $module->name = 'Listado de citas';
        $module->parent_id = 1;
        $module->enable = true;
        $module->canDelete = false;
        $module->path = 'caja/citas';
        $module->save();

        $module = new SystemModule();
        $module->name = 'Listado de pacientes';
        $module->parent_id = 1;
        $module->enable = true;
        $module->canDelete = false;
        $module->path = 'caja/pacientes';
        $module->save();

        //Submodulos de enfermeria
        $module = new SystemModule();
        $module->name = 'Pacientes en espera';
        $module->parent_id = 2;
        $module->enable = true;
        $module->canDelete = false;
        $module->path = '/enfermeria/citas';
        $module->save();

        $module = new SystemModule();
        $module->name = 'Consultar historial';
        $module->parent_id = 2;
        $module->enable = true;
        $module->canDelete = false;
        $module->path = '/enfermeria/historial';
        $module->save();

        //Submodulos de medicina
        $module = new SystemModule();
        $module->name = 'Pacientes en espera';
        $module->parent_id = 3;
        $module->enable = true;
        $module->canDelete = false;
        $module->path = '/medicina/citas';
        $module->save();

        $module = new SystemModule();
        $module->name = 'Buscar expedientes';
        $module->parent_id = 3;
        $module->enable = true;
        $module->canDelete = false;
        $module->path = '/medicina/expedientes';
        $module->save();


        //Submodulos odontologia
        $module = new SystemModule();
        $module->name = 'Pacientes en espera';
        $module->parent_id = 4;
        $module->enable = true;
        $module->canDelete = false;
        $module->path = '/odontologia/citas';
        $module->save();

        $module = new SystemModule();
        $module->name = 'Consultar historial';
        $module->parent_id = 4;
        $module->enable = true;
        $module->canDelete = false;
        $module->path = 'odontologia/historial';
        $module->save();

        //Submodulos de laboratorio
        $module = new SystemModule();
        $module->name = 'Unidades de medida';
        $module->parent_id = 5;
        $module->enable = true;
        $module->canDelete = false;
        $module->path = '/unidades';
        $module->save();

        $module = new SystemModule();
        $module->name = 'Areas';
        $module->parent_id = 5;
        $module->enable = true;
        $module->canDelete = false;
        $module->path = '/areas';
        $module->save();

        $module = new SystemModule();
        $module->name = 'Grupos';
        $module->parent_id = 5;
        $module->enable = true;
        $module->canDelete = false;
        $module->path = '/grupos';
        $module->save();

        $module = new SystemModule();
        $module->name = 'Pruebas';
        $module->parent_id = 5;
        $module->enable = true;
        $module->canDelete = false;
        $module->path = '/pruebas';
        $module->save();

        $module = new SystemModule();
        $module->name = 'Captura de resultados';
        $module->parent_id = 5;
        $module->enable = true;
        $module->canDelete = false;
        $module->path = '/captura';
        $module->save();

        $module = new SystemModule();
        $module->name = 'Consultar resultados';
        $module->parent_id = 5;
        $module->enable = true;
        $module->canDelete = false;
        $module->path = '/resultados';
        $module->save();

        //Submodulos mantenimiento
        $module = new SystemModule();
        $module->name = 'Roles';
        $module->parent_id = 6;
        $module->enable = true;
        $module->canDelete = false;
        $module->path = '/roles';
        $module->save();

        $module = new SystemModule();
        $module->name = 'Roles y permisos';
        $module->parent_id = 6;
        $module->enable = true;
        $module->canDelete = false;
        $module->path = '/permisos';
        $module->save();

        $module = new SystemModule();
        $module->name = 'Usuarios';
        $module->parent_id = 6;
        $module->enable = true;
        $module->canDelete = false;
        $module->path = '/usuarios';
        $module->save();

        $module = new SystemModule();
        $module->name = 'Medicamentos';
        $module->parent_id = 6;
        $module->enable = true;
        $module->canDelete = false;
        $module->path = '/medicamentos';
        $module->save();

        $module = new SystemModule();
        $module->name = 'Cie 10';
        $module->parent_id = 6;
        $module->enable = true;
        $module->canDelete = false;
        $module->path = '/cies';
        $module->save();

        $module = new SystemModule();
        $module->name = 'Informacion de la empresa';
        $module->parent_id = 6;
        $module->enable = true;
        $module->canDelete = false;
        $module->path = '/empresa';
        $module->save();
    }
}
