<?php

namespace Database\Seeders;

use App\Models\OdoSymbologie;
use Illuminate\Database\Seeder;

class SymbologieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $symbologie=new OdoSymbologie();
      $symbologie->name="Sellante necesario";
      $symbologie->path="sellante-necesario.svg";
      $symbologie->tooltip_direction="top";
      $symbologie->save();

      $symbologie=new OdoSymbologie();
      $symbologie->name="Sellante realizado";
      $symbologie->path="sellante-realizado.svg";
      $symbologie->tooltip_direction="top";
      $symbologie->save();

      $symbologie=new OdoSymbologie();
      $symbologie->name="Extracción indicada";
      $symbologie->path="extraccion-indicada.svg";
      $symbologie->tooltip_direction="top";
      $symbologie->save();


      $symbologie=new OdoSymbologie();
      $symbologie->name="Pérdida por caries";
      $symbologie->path="perdida-por-caries.svg";
      $symbologie->tooltip_direction="top";
      $symbologie->save();

      $symbologie=new OdoSymbologie();
      $symbologie->name="Pérdida otra causa";
      $symbologie->path="perdida-otra-causa.svg";
      $symbologie->tooltip_direction="top";
      $symbologie->save();

      $symbologie=new OdoSymbologie();
      $symbologie->name="Endodoncia";
      $symbologie->path="endodoncia.svg";
      $symbologie->tooltip_direction="top";
      $symbologie->save();

      $symbologie=new OdoSymbologie();
      $symbologie->name="Prótesis fija";
      $symbologie->path="protesis-fija.svg";
      $symbologie->tooltip_direction="top";
      $symbologie->save();

      $symbologie=new OdoSymbologie();
      $symbologie->name="Prótesis removible";
      $symbologie->path="protesis-removible.svg";
      $symbologie->tooltip_direction="top";
      $symbologie->save();

      $symbologie=new OdoSymbologie();
      $symbologie->name="Prótesis total";
      $symbologie->path="protesis-total.svg";
      $symbologie->tooltip_direction="top";
      $symbologie->save();

      $symbologie=new OdoSymbologie();
      $symbologie->name="Corona";
      $symbologie->path="corona.svg";
      $symbologie->tooltip_direction="top";
      $symbologie->save();

      $symbologie=new OdoSymbologie();
      $symbologie->name="Obturado";
      $symbologie->path="obturado.svg";
      $symbologie->tooltip_direction="top";
      $symbologie->save();

      $symbologie=new OdoSymbologie();
      $symbologie->name="Caries";
      $symbologie->path="caries.svg";
      $symbologie->tooltip_direction="top";
      $symbologie->save();

      /*$symbologie=new OdoSymbologie();
      $symbologie->name="Limpiar";
      $symbologie->path="clean.svg";
      $symbologie->tooltip_direction="top";
      $symbologie->save();*/
    }
}
