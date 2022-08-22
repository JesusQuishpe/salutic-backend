<?php

namespace Database\Seeders;

use App\Models\LbArea;
use Illuminate\Database\Seeder;

class AreaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $area=new LbArea();
        $area->code="EXAMBIOSAN";
        $area->name="BIOQUIMICA SANGUINEA";
        $area->price=15;
        $area->save();

        $area=new LbArea();
        $area->code="EXAMCOPROLO";
        $area->name="COPROLOGIA PARA EDA";
        $area->price=15;
        $area->save();

        $area=new LbArea();
        $area->code="EXAMCOPROPARA";
        $area->name="COPROPARASITARIO";
        $area->price=15;
        $area->save();

        $area=new LbArea();
        $area->code="EXAMORI";
        $area->name="EXAMEN DE ORINA";
        $area->price=15;
        $area->save();

        $area=new LbArea();
        $area->code="EXAMHELIHECES";
        $area->name="HELICOBACTER PYLORI IgG HECES";
        $area->price=15;
        $area->save();

        $area=new LbArea();
        $area->code="EXAMHELI";
        $area->name="HELICOBACTER PYLORI IgG";
        $area->price=15;
        $area->save();

        $area=new LbArea();
        $area->code="EXAMHEMAT";
        $area->name="HEMATOLOGIA";
        $area->price=15;
        $area->save();

        $area=new LbArea();
        $area->code="EXAMHEMOGLO";
        $area->name="HEMOGLOBINA";
        $area->price=15;
        $area->save();

        $area=new LbArea();
        $area->code="EXAMEMBARA";
        $area->name="PRUEBA DE EMBARAZO";
        $area->price=15;
        $area->save();



    }
}
