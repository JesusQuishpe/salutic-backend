<?php

namespace Database\Seeders;

use App\Models\Estudio;
use Illuminate\Database\Seeder;

class EstudioSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $estudio = new Estudio();
    $estudio->clave = "GLU";
    $estudio->nombre = "GLUCOSA";
    $estudio->es_individual = true;
    $estudio->id_unidad = null;
    $estudio->valor_referencia = "R";
    $estudio->indicaciones = "";
    $estudio->save();

    $estudio = new Estudio();
    $estudio->clave = "UR";
    $estudio->nombre = "UREA";
    $estudio->es_individual = true;
    $estudio->id_unidad = null;
    $estudio->valor_referencia = "R";
    $estudio->indicaciones = "";
    $estudio->save();

    $estudio = new Estudio();
    $estudio->clave = "CRE";
    $estudio->nombre = "CREATININA";
    $estudio->es_individual = true;
    $estudio->id_unidad = null;
    $estudio->valor_referencia = "R";
    $estudio->indicaciones = "";
    $estudio->save();

    $estudio = new Estudio();
    $estudio->clave = "ACU";
    $estudio->nombre = "ACIDO URICO";
    $estudio->es_individual = true;
    $estudio->id_unidad = null;
    $estudio->valor_referencia = "R";
    $estudio->indicaciones = "";
    $estudio->save();

    $estudio = new Estudio();
    $estudio->clave = "CT";
    $estudio->nombre = "COLESTEROL TOTAL";
    $estudio->es_individual = true;
    $estudio->id_unidad = null;
    $estudio->valor_referencia = "R";
    $estudio->indicaciones = "";
    $estudio->save();

    $estudio = new Estudio();
    $estudio->clave = "CHDL";
    $estudio->nombre = "COLESTEROL HDL";
    $estudio->es_individual = true;
    $estudio->id_unidad = null;
    $estudio->valor_referencia = "R";
    $estudio->indicaciones = "";
    $estudio->save();

    $estudio = new Estudio();
    $estudio->clave = "CLDL";
    $estudio->nombre = "COLESTEROL LDL";
    $estudio->es_individual = true;
    $estudio->id_unidad = null;
    $estudio->valor_referencia = "R";
    $estudio->indicaciones = "";
    $estudio->save();

    $estudio = new Estudio();
    $estudio->clave = "TRIGL";
    $estudio->nombre = "TRIGLICERIDOS";
    $estudio->es_individual = true;
    $estudio->id_unidad = null;
    $estudio->valor_referencia = "R";
    $estudio->indicaciones = "";
    $estudio->save();

    $estudio = new Estudio();
    $estudio->clave = "PT";
    $estudio->nombre = "PROTEINAS TOTALES";
    $estudio->es_individual = true;
    $estudio->id_unidad = null;
    $estudio->valor_referencia = "R";
    $estudio->indicaciones = "";
    $estudio->save();

    $estudio = new Estudio();
    $estudio->clave = "ALB";
    $estudio->nombre = "ALBUMINA";
    $estudio->es_individual = true;
    $estudio->id_unidad = null;
    $estudio->valor_referencia = "R";
    $estudio->indicaciones = "";
    $estudio->save();

    $estudio = new Estudio();
    $estudio->clave = "GLOB";
    $estudio->nombre = "GLOBULINA";
    $estudio->es_individual = true;
    $estudio->id_unidad = null;
    $estudio->valor_referencia = "R";
    $estudio->indicaciones = "";
    $estudio->save();

    $estudio = new Estudio();
    $estudio->clave = "RELAG";
    $estudio->nombre = "RELACION A/G";
    $estudio->es_individual = true;
    $estudio->id_unidad = null;
    $estudio->valor_referencia = "R";
    $estudio->indicaciones = "";
    $estudio->save();

    $estudio = new Estudio();
    $estudio->clave = "BILDIR";
    $estudio->nombre = "BILIRRUBINA DIRECTA";
    $estudio->es_individual = true;
    $estudio->id_unidad = null;
    $estudio->valor_referencia = "R";
    $estudio->indicaciones = "";
    $estudio->save();

    $estudio = new Estudio();
    $estudio->clave = "BILIND";
    $estudio->nombre = "BILIRRUBINA INDIRECTA";
    $estudio->es_individual = true;
    $estudio->id_unidad = null;
    $estudio->valor_referencia = "R";
    $estudio->indicaciones = "";
    $estudio->save();

    $estudio = new Estudio();
    $estudio->clave = "BILTOT";
    $estudio->nombre = "BILIRRUBINA TOTAL";
    $estudio->es_individual = true;
    $estudio->id_unidad = null;
    $estudio->valor_referencia = "R";
    $estudio->indicaciones = "";
    $estudio->save();

    $estudio = new Estudio();
    $estudio->clave = "GGT";
    $estudio->nombre = "GAMMA GLUTAMIL TRANSP.";
    $estudio->es_individual = true;
    $estudio->id_unidad = null;
    $estudio->valor_referencia = "R";
    $estudio->indicaciones = "";
    $estudio->save();

    $estudio = new Estudio();
    $estudio->clave = "CAL";
    $estudio->nombre = "CALCIO";
    $estudio->es_individual = true;
    $estudio->id_unidad = null;
    $estudio->valor_referencia = "R";
    $estudio->indicaciones = "";
    $estudio->save();

    $estudio = new Estudio();
    $estudio->clave = "VDRL";
    $estudio->nombre = "VDRL";
    $estudio->es_individual = true;
    $estudio->id_unidad = null;
    $estudio->valor_referencia = "R";
    $estudio->indicaciones = "";
    $estudio->save();

    $estudio = new Estudio();
    $estudio->clave = "PROTCR";
    $estudio->nombre = "PROTEINA C REACT";
    $estudio->es_individual = true;
    $estudio->id_unidad = null;
    $estudio->valor_referencia = "R";
    $estudio->indicaciones = "";
    $estudio->save();

    $estudio = new Estudio();
    $estudio->clave = "RATEST";
    $estudio->nombre = "R.A TEST (LATEX)";
    $estudio->es_individual = true;
    $estudio->id_unidad = null;
    $estudio->valor_referencia = "R";
    $estudio->indicaciones = "";
    $estudio->save();

    $estudio = new Estudio();
    $estudio->clave = "ASTO";
    $estudio->nombre = "A.S.T.O";
    $estudio->es_individual = true;
    $estudio->id_unidad = null;
    $estudio->valor_referencia = "R";
    $estudio->indicaciones = "";
    $estudio->save();

    $estudio = new Estudio();
    $estudio->clave = "SALMO";
    $estudio->nombre = "SALMONELLA O";
    $estudio->es_individual = true;
    $estudio->id_unidad = null;
    $estudio->valor_referencia = "R";
    $estudio->indicaciones = "";
    $estudio->save();

    $estudio = new Estudio();
    $estudio->clave = "SALM H";
    $estudio->nombre = "SALMONELLA H";
    $estudio->es_individual = true;
    $estudio->id_unidad = null;
    $estudio->valor_referencia = "R";
    $estudio->indicaciones = "";
    $estudio->save();

    $estudio = new Estudio();
    $estudio->clave = "PARTIFA";
    $estudio->nombre = "PARATIFICA A";
    $estudio->es_individual = true;
    $estudio->id_unidad = null;
    $estudio->valor_referencia = "R";
    $estudio->indicaciones = "";
    $estudio->save();

    $estudio = new Estudio();
    $estudio->clave = "PARTIFB";
    $estudio->nombre = "PARATIFICA B";
    $estudio->es_individual = true;
    $estudio->id_unidad = null;
    $estudio->valor_referencia = "R";
    $estudio->indicaciones = "";
    $estudio->save();

    $estudio = new Estudio();
    $estudio->clave = "PROOX19";
    $estudio->nombre = "PROTEUS OX19";
    $estudio->es_individual = true;
    $estudio->id_unidad = null;
    $estudio->valor_referencia = "R";
    $estudio->indicaciones = "";
    $estudio->save();

    $estudio = new Estudio();
    $estudio->clave = "PROOX2";
    $estudio->nombre = "PROTEUS OX2";
    $estudio->es_individual = true;
    $estudio->id_unidad = null;
    $estudio->valor_referencia = "R";
    $estudio->indicaciones = "";
    $estudio->save();

    $estudio = new Estudio();
    $estudio->clave = "PROTEUS OXK";
    $estudio->nombre = "PROTEUS OXK";
    $estudio->es_individual = true;
    $estudio->id_unidad = null;
    $estudio->valor_referencia = "R";
    $estudio->indicaciones = "";
    $estudio->save();

    $estudio = new Estudio();
    $estudio->clave = "TRANCOX";
    $estudio->nombre = "TRANSAMINASA COX";
    $estudio->es_individual = true;
    $estudio->id_unidad = null;
    $estudio->valor_referencia = "R";
    $estudio->indicaciones = "";
    $estudio->save();

    $estudio = new Estudio();
    $estudio->clave = "TRANPIR";
    $estudio->nombre = "TRANSAMINASA PIR";
    $estudio->es_individual = true;
    $estudio->id_unidad = null;
    $estudio->valor_referencia = "R";
    $estudio->indicaciones = "";
    $estudio->save();

    $estudio = new Estudio();
    $estudio->clave = "FOSFAA";
    $estudio->nombre = "FOSFATASA ALCALINA ADUL";
    $estudio->es_individual = true;
    $estudio->id_unidad = null;
    $estudio->valor_referencia = "R";
    $estudio->indicaciones = "";
    $estudio->save();

    $estudio = new Estudio();
    $estudio->clave = "FOSFAN";
    $estudio->nombre = "FOSFATASA ALCALINA NIÑOS";
    $estudio->es_individual = true;
    $estudio->id_unidad = null;
    $estudio->valor_referencia = "R";
    $estudio->indicaciones = "";
    $estudio->save();

    $estudio = new Estudio();
    $estudio->clave = "AMIL";
    $estudio->nombre = "AMILASA";
    $estudio->es_individual = true;
    $estudio->id_unidad = null;
    $estudio->valor_referencia = "R";
    $estudio->indicaciones = "";
    $estudio->save();

    $estudio = new Estudio();
    $estudio->clave = "LIPASA";
    $estudio->nombre = "LIPASA";
    $estudio->es_individual = true;
    $estudio->id_unidad = null;
    $estudio->valor_referencia = "R";
    $estudio->indicaciones = "";
    $estudio->save();

    $estudio = new Estudio();
    $estudio->clave = "COLOR";
    $estudio->nombre = "COLOR";
    $estudio->es_individual = true;
    $estudio->id_unidad = null;
    $estudio->valor_referencia = "C";
    $estudio->indicaciones = "";
    $estudio->save();

    $estudio = new Estudio();
    $estudio->clave = "OLOR";
    $estudio->nombre = "OLOR";
    $estudio->es_individual = true;
    $estudio->id_unidad = null;
    $estudio->valor_referencia = "C";
    $estudio->indicaciones = "";
    $estudio->save();

    $estudio = new Estudio();
    $estudio->clave = "SED";
    $estudio->nombre = "SEDIMENTO";
    $estudio->es_individual = true;
    $estudio->id_unidad = null;
    $estudio->valor_referencia = "C";
    $estudio->indicaciones = "";
    $estudio->save();

    $estudio = new Estudio();
    $estudio->clave = "PH";
    $estudio->nombre = "PH";
    $estudio->es_individual = true;
    $estudio->id_unidad = null;
    $estudio->valor_referencia = "I"; //I=INDEFINIDO
    $estudio->indicaciones = "";
    $estudio->save();

    $estudio = new Estudio();
    $estudio->clave = "DENSIDAD";
    $estudio->nombre = "DENSIDAD";
    $estudio->es_individual = true;
    $estudio->id_unidad = null;
    $estudio->valor_referencia = "I";
    $estudio->indicaciones = "";
    $estudio->save();

    $estudio = new Estudio();
    $estudio->clave = "LEU";
    $estudio->nombre = "LEUCOCITURIA";
    $estudio->es_individual = true;
    $estudio->id_unidad = null;
    $estudio->valor_referencia = "I";
    $estudio->indicaciones = "";
    $estudio->save();

    $estudio = new Estudio();
    $estudio->clave = "NIT";
    $estudio->nombre = "NITRITOS";
    $estudio->es_individual = true;
    $estudio->id_unidad = null;
    $estudio->valor_referencia = "I";
    $estudio->indicaciones = "";
    $estudio->save();

    $estudio = new Estudio();
    $estudio->clave = "CET";
    $estudio->nombre = "CETONAS";
    $estudio->es_individual = true;
    $estudio->id_unidad = null;
    $estudio->valor_referencia = "I";
    $estudio->indicaciones = "";
    $estudio->save();

    $estudio = new Estudio();
    $estudio->clave = "UROBILI";
    $estudio->nombre = "UROBILINOGENO";
    $estudio->es_individual = true;
    $estudio->id_unidad = null;
    $estudio->valor_referencia = "I";
    $estudio->indicaciones = "";
    $estudio->save();

    $estudio = new Estudio();
    $estudio->clave = "SAHEME";
    $estudio->nombre = "SANGRE (HEM.ENTEROS)";
    $estudio->es_individual = true;
    $estudio->id_unidad = null;
    $estudio->valor_referencia = "I";
    $estudio->indicaciones = "";
    $estudio->save();

    $estudio = new Estudio();
    $estudio->clave = "SAHLIS";
    $estudio->nombre = "SANGRE (H.LISADOS)";
    $estudio->es_individual = true;
    $estudio->id_unidad = null;
    $estudio->valor_referencia = "I";
    $estudio->indicaciones = "";
    $estudio->save();

    $estudio = new Estudio();
    $estudio->clave = "ACASCOR";
    $estudio->nombre = "ACIDO ASCORBICO";
    $estudio->es_individual = true;
    $estudio->id_unidad = null;
    $estudio->valor_referencia = "I";
    $estudio->indicaciones = "";
    $estudio->save();

    $estudio = new Estudio();
    $estudio->clave = "HEMA";
    $estudio->nombre = "HEMATIES";
    $estudio->es_individual = true;
    $estudio->id_unidad = null;
    $estudio->valor_referencia = "I";
    $estudio->indicaciones = "";
    $estudio->save();

    $estudio = new Estudio();
    $estudio->clave = "LEUCOCITOS";
    $estudio->nombre = "LEUCOCITOS";
    $estudio->es_individual = true;
    $estudio->id_unidad = null;
    $estudio->valor_referencia = "I";
    $estudio->indicaciones = "";
    $estudio->save();

    $estudio = new Estudio();
    $estudio->clave = "CEPI";
    $estudio->nombre = "CEL. EPITELIALES";
    $estudio->es_individual = true;
    $estudio->id_unidad = null;
    $estudio->valor_referencia = "I";
    $estudio->indicaciones = "";
    $estudio->save();

    $estudio = new Estudio();
    $estudio->clave = "FMUC";
    $estudio->nombre = "FIL. MUCOSOS";
    $estudio->es_individual = true;
    $estudio->id_unidad = null;
    $estudio->valor_referencia = "I";
    $estudio->indicaciones = "";
    $estudio->save();

    $estudio = new Estudio();
    $estudio->clave = "BACT";
    $estudio->nombre = "BACTERIAS";
    $estudio->es_individual = true;
    $estudio->id_unidad = null;
    $estudio->valor_referencia = "I";
    $estudio->indicaciones = "";
    $estudio->save();

    $estudio = new Estudio();
    $estudio->clave = "BACILOS";
    $estudio->nombre = "BACILOS";
    $estudio->es_individual = true;
    $estudio->id_unidad = null;
    $estudio->valor_referencia = "I";
    $estudio->indicaciones = "";
    $estudio->save();

    $estudio = new Estudio();
    $estudio->clave = "CRIST";
    $estudio->nombre = "CRISTALES";
    $estudio->es_individual = true;
    $estudio->id_unidad = null;
    $estudio->valor_referencia = "I";
    $estudio->indicaciones = "";
    $estudio->save();

    $estudio = new Estudio();
    $estudio->clave = "CIL";
    $estudio->nombre = "CILINDROS";
    $estudio->es_individual = true;
    $estudio->id_unidad = null;
    $estudio->valor_referencia = "I";
    $estudio->indicaciones = "";
    $estudio->save();

    $estudio = new Estudio();
    $estudio->clave = "PIO";
    $estudio->nombre = "PIOCITOS";
    $estudio->es_individual = true;
    $estudio->id_unidad = null;
    $estudio->valor_referencia = "I";
    $estudio->indicaciones = "";
    $estudio->save();

    $estudio = new Estudio();
    $estudio->clave = "PRO";
    $estudio->nombre = "PROTOZOARIOS";
    $estudio->es_individual = true;
    $estudio->id_unidad = null;
    $estudio->valor_referencia = "I";
    $estudio->indicaciones = "";
    $estudio->save();

    $estudio = new Estudio();
    $estudio->clave = "AMEBA HIS";
    $estudio->nombre = "AMEBA HISTOLITICA";
    $estudio->es_individual = true;
    $estudio->id_unidad = null;
    $estudio->valor_referencia = "I";
    $estudio->indicaciones = "";
    $estudio->save();

    $estudio = new Estudio();
    $estudio->clave = "AMEBA COLI";
    $estudio->nombre = "AMEBA COLI";
    $estudio->es_individual = true;
    $estudio->id_unidad = null;
    $estudio->valor_referencia = "I";
    $estudio->indicaciones = "";
    $estudio->save();

    $estudio = new Estudio();
    $estudio->clave = "GIARDIALAM";
    $estudio->nombre = "GIARDIA LAMBLIA";
    $estudio->es_individual = true;
    $estudio->id_unidad = null;
    $estudio->valor_referencia = "I";
    $estudio->indicaciones = "";
    $estudio->save();

    $estudio = new Estudio();
    $estudio->clave = "TRICHOMONA";
    $estudio->nombre = "TRICHOMONA HOMINIS";
    $estudio->es_individual = true;
    $estudio->id_unidad = null;
    $estudio->valor_referencia = "I";
    $estudio->indicaciones = "";
    $estudio->save();

    $estudio = new Estudio();
    $estudio->clave = "CHILOMASTIK";
    $estudio->nombre = "CHILOMASTIK MESNILE";
    $estudio->es_individual = true;
    $estudio->id_unidad = null;
    $estudio->valor_referencia = "I";
    $estudio->indicaciones = "";
    $estudio->save();

    $estudio = new Estudio();
    $estudio->clave = "HELMIN";
    $estudio->nombre = "HELMINTOS";
    $estudio->es_individual = true;
    $estudio->id_unidad = null;
    $estudio->valor_referencia = "I";
    $estudio->indicaciones = "";
    $estudio->save();

    $estudio = new Estudio();
    $estudio->clave = "TRICHURIS";
    $estudio->nombre = "TRICHURIS TRICHURA";
    $estudio->es_individual = true;
    $estudio->id_unidad = null;
    $estudio->valor_referencia = "I";
    $estudio->indicaciones = "";
    $estudio->save();

    $estudio = new Estudio();
    $estudio->clave = "ASCARIS";
    $estudio->nombre = "ASCARIS LUMBRICOIDES";
    $estudio->es_individual = true;
    $estudio->id_unidad = null;
    $estudio->valor_referencia = "I";
    $estudio->indicaciones = "";
    $estudio->save();

    $estudio = new Estudio();
    $estudio->clave = "STRONGY";
    $estudio->nombre = "STRONGYLOIDES STERCOLARIE";
    $estudio->es_individual = true;
    $estudio->id_unidad = null;
    $estudio->valor_referencia = "I";
    $estudio->indicaciones = "";
    $estudio->save();

    $estudio = new Estudio();
    $estudio->clave = "OXIUROS";
    $estudio->nombre = "OXIUROS";
    $estudio->es_individual = true;
    $estudio->id_unidad = null;
    $estudio->valor_referencia = "I";
    $estudio->indicaciones = "";
    $estudio->save();
  }
}
