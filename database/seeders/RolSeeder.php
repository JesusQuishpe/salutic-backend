<?php

namespace Database\Seeders;

use App\Models\Rol;
use Illuminate\Database\Seeder;

class RolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $rol=new Rol();
        $rol->name='Administrador';
        $rol->save();

        $rol=new Rol();
        $rol->name='Cajero';
        $rol->save();

        $rol=new Rol();
        $rol->name='Enfermero';
        $rol->save();

        $rol=new Rol();
        $rol->name='Odontologo';
        $rol->save();

        $rol=new Rol();
        $rol->name='Laboratista';
        $rol->save();
    }
}
