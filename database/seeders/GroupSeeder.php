<?php

namespace Database\Seeders;

use App\Models\LbGroup;
use Illuminate\Database\Seeder;

class GroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $group=new LbGroup();
        $group->code="GRBIOSAN";
        $group->name="GRUPO BIOQUIMICA SANGUINEA";
        $group->area_id=1;
        $group->show_at_print=false;
        $group->price=0;
        $group->save();

        $group=new LbGroup();
        $group->code="GRCOPROLO";
        $group->name="GRUPO COPROLOGIA";
        $group->area_id=2;
        $group->show_at_print=false;
        $group->price=0;
        $group->save();

        $group=new LbGroup();
        $group->code="GRCOPROPARA";
        $group->name="GRUPO COPROPARASITARIO";
        $group->area_id=3;
        $group->show_at_print=false;
        $group->price=0;
        $group->save();

        $group=new LbGroup();
        $group->code="GREXAMORIFIS";
        $group->name="FISICO QUIMICO";
        $group->area_id=4;
        $group->show_at_print=true;
        $group->price=0;
        $group->save();

        $group=new LbGroup();
        $group->code="GREXAMORIMIC";
        $group->name="MICROSCOPIO";
        $group->area_id=4;
        $group->show_at_print=true;
        $group->price=0;
        $group->save();

        $group=new LbGroup();
        $group->code="GREXAMHELIHECES";
        $group->name="GRUPO HELICOBACTER HECES";
        $group->area_id=5;
        $group->show_at_print=false;
        $group->price=0;
        $group->save();

        $group=new LbGroup();
        $group->code="GREXAMHELI";
        $group->name="GRUPO HELICOBACTER";
        $group->area_id=6;
        $group->show_at_print=false;
        $group->price=0;
        $group->save();

        //Para examen hematologia
        $group=new LbGroup();
        $group->code="GREXAMHEMAT";
        $group->name="HEMATOLOGIA";
        $group->area_id=7;
        $group->show_at_print=true;
        $group->price=0;
        $group->save();

        $group=new LbGroup();
        $group->code="GRFORMLEU";
        $group->name="FORMULA LEUCOCITORIA";
        $group->area_id=7;
        $group->show_at_print=true;
        $group->price=0;
        $group->save();

        $group=new LbGroup();
        $group->code="GRHEMOSTASIA";
        $group->name="HEMOSTASIA";
        $group->area_id=7;
        $group->show_at_print=true;
        $group->price=0;
        $group->save();

        //Para examen hemoglobina
        $group=new LbGroup();
        $group->code="GREXAMHEMOGLO";
        $group->name="GRUPO HEMOGLOBINA GLICOSILADA A1C";
        $group->area_id=8;
        $group->show_at_print=false;
        $group->price=0;
        $group->save();

        $group=new LbGroup();
        $group->code="GREXAMEMBARA";
        $group->name="GRUPO PRUEBA DE EMBARAZO";
        $group->area_id=9;
        $group->show_at_print=false;
        $group->price=0;
        $group->save();


    }
}
