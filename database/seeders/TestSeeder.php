<?php

namespace Database\Seeders;

use App\Models\LbTest;
use Illuminate\Database\Seeder;

class TestSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $test = new LbTest();
    $test->code = "GLU";
    $test->name = "GLUCOSA";
    $test->group_id = 1;
    $test->measure_id = null;
    $test->ref_value = "M";
    $test->operator_type = "range";
    $test->of = 75;
    $test->until = 115;
    $test->interpretation = "75-115mg%";
    $test->is_numeric = true;
    $test->save();

    $test = new LbTest();
    $test->code = "UR";
    $test->name = "UREA";
    $test->group_id = 1;
    $test->measure_id = null;
    $test->ref_value = "M";
    $test->of = 10;
    $test->until = 50;
    $test->operator_type = "range";
    $test->interpretation = "10-50mg%";
    $test->is_numeric = true;
    $test->save();

    $test = new LbTest();
    $test->code = "CRE";
    $test->name = "CREATININA";
    $test->group_id = 1;
    $test->measure_id = null;
    $test->ref_value = "M";
    $test->of = 0.4;
    $test->until = 1.1;
    $test->operator_type = "range";
    $test->interpretation = "0.4-1.1mg%";
    $test->is_numeric = true;
    $test->save();

    $test = new LbTest();
    $test->code = "ACU";
    $test->name = "ACIDO URICO";
    $test->group_id = 1;
    $test->measure_id = null;
    $test->ref_value = "M";
    $test->of = 2.5;
    $test->until = 6;
    $test->operator_type = "range";
    $test->interpretation = "2.5-6mg%";
    $test->is_numeric = true;
    $test->save();

    $test = new LbTest();
    $test->code = "CT";
    $test->name = "COLESTEROL TOTAL";
    $test->group_id = 1;
    $test->measure_id = null;
    $test->ref_value = "M";
    $test->of = 150;
    $test->until = 200;
    $test->operator_type = "range";
    $test->interpretation = "150-200mg%";
    $test->is_numeric = true;
    $test->save();

    $test = new LbTest();
    $test->code = "CHDL";
    $test->name = "COLESTEROL HDL";
    $test->group_id = 1;
    $test->measure_id = null;
    $test->ref_value = "M";
    $test->operator_type = "<";
    $test->operator_value = 55;
    $test->formula = "CT/5";
    $test->operands = "CT";
    $test->interpretation = "<55mg%";
    $test->is_numeric = true;
    $test->save();

    $test = new LbTest();
    $test->code = "TRIGL";
    $test->name = "TRIGLICERIDOS";
    $test->group_id = 1;
    $test->measure_id = null;
    $test->ref_value = "M";
    $test->operator_type = "<";
    $test->operator_value = 200;
    $test->interpretation = "<200mg%";
    $test->is_numeric = true;
    $test->save();

    $test = new LbTest();
    $test->code = "CLDL";
    $test->name = "COLESTEROL LDL";
    $test->group_id = 1;
    $test->measure_id = null;
    $test->ref_value = "M";
    $test->operator_type = "<";
    $test->operator_value = 140;
    $test->formula = "CT-CHDL-(TRIGL/5)";
    $test->operands = "CT,CHDL,TRIGL";
    $test->interpretation = "<140mg%";
    $test->is_numeric = true;
    $test->save();

    $test = new LbTest();
    $test->code = "PROT";
    $test->name = "PROTEINAS TOTALES";
    $test->group_id = 1;
    $test->measure_id = null;
    $test->ref_value = "M";
    $test->of = 6;
    $test->until = 8;
    $test->operator_type = "range";
    $test->interpretation = "6-8mg%";
    $test->is_numeric = true;
    $test->save();

    $test = new LbTest();
    $test->code = "ALB";
    $test->name = "ALBUMINA";
    $test->group_id = 1;
    $test->measure_id = null;
    $test->ref_value = "M";
    $test->of = 3.5;
    $test->until = 5.5;
    $test->operator_type = "range";
    $test->interpretation = "3.5-5.5mg%";
    $test->is_numeric = true;
    $test->save();

    $test = new LbTest();
    $test->code = "GLOB";
    $test->name = "GLOBULINA";
    $test->group_id = 1;
    $test->measure_id = null;
    $test->ref_value = "M";
    $test->operator_type = "<";
    $test->operator_value = 2.4;
    $test->formula = "PROT-ALB";
    $test->operands = "PROT,ALB";
    $test->interpretation = "<2.4mg%";
    $test->is_numeric = true;
    $test->save();

    $test = new LbTest();
    $test->code = "RELAG";
    $test->name = "RELACION A/G";
    $test->group_id = 1;
    $test->measure_id = null;
    $test->ref_value = "M";
    $test->of = 1.4;
    $test->until = 3;
    $test->operator_type = "range";
    $test->formula = "ALB/GLOB";
    $test->operands = "ALB,GLOB";
    $test->interpretation = "1.4-3mg%";
    $test->is_numeric = true;
    $test->save();

    $test = new LbTest();
    $test->code = "BILTOT";
    $test->name = "BILIRRUBINA TOTAL";
    $test->group_id = 1;
    $test->measure_id = null;
    $test->ref_value = "M";
    $test->operator_type = "<";
    $test->operator_value = 1;
    $test->interpretation = "<1mg%";
    $test->is_numeric = true;
    $test->save();

    $test = new LbTest();
    $test->code = "BILDIR";
    $test->name = "BILIRRUBINA DIRECTA";
    $test->group_id = 1;
    $test->measure_id = null;
    $test->ref_value = "M";
    $test->operator_type = ">";
    $test->operator_value = 0.25;
    $test->interpretation = ">0.25mg%";
    $test->is_numeric = true;
    $test->save();

    $test = new LbTest();
    $test->code = "BILIND";
    $test->name = "BILIRRUBINA INDIRECTA";
    $test->group_id = 1;
    $test->measure_id = null;
    $test->ref_value = "M";
    $test->operator_type = "<";
    $test->operator_value = 1;
    $test->formula = "BILTOT-BILDIR";
    $test->operands = "BILTOT,BILDIR";
    $test->interpretation = "<1mg%";
    $test->is_numeric = true;
    $test->save();

    $test = new LbTest();
    $test->code = "GGT";
    $test->name = "GAMMA GLUTAMIL TRANSP.";
    $test->group_id = 1;
    $test->measure_id = null;
    $test->ref_value = "M";
    $test->of = 9;
    $test->until = 61;
    $test->operator_type = "range";
    $test->interpretation = "9-61 U/L";
    $test->is_numeric = true;
    $test->save();

    $test = new LbTest();
    $test->code = "CAL";
    $test->name = "CALCIO";
    $test->group_id = 1;
    $test->measure_id = null;
    $test->ref_value = "M";
    $test->of = 9;
    $test->until = 11;
    $test->operator_type = "range";
    $test->interpretation = "9-11mg%";
    $test->is_numeric = true;
    $test->save();

    $test = new LbTest();
    $test->code = "VDRL";
    $test->name = "VDRL";
    $test->group_id = 1;
    $test->measure_id = null;
    $test->ref_value = "M";
    $test->save();

    $test = new LbTest();
    $test->code = "PROTCR";
    $test->name = "PROTEINA C REACT";
    $test->group_id = 1;
    $test->measure_id = null;
    $test->ref_value = "M";
    $test->save();

    $test = new LbTest();
    $test->code = "RATEST";
    $test->name = "R.A TEST (LATEX)";
    $test->group_id = 1;
    $test->measure_id = null;
    $test->ref_value = "M";
    $test->save();

    $test = new LbTest();
    $test->code = "ASTO";
    $test->name = "A.S.T.O";
    $test->group_id = 1;
    $test->measure_id = null;
    $test->ref_value = "M";
    $test->save();

    $test = new LbTest();
    $test->code = "SALMO";
    $test->name = "SALMONELLA O";
    $test->group_id = 1;
    $test->measure_id = null;
    $test->ref_value = "M";
    $test->save();

    $test = new LbTest();
    $test->code = "SALM H";
    $test->name = "SALMONELLA H";
    $test->group_id = 1;
    $test->measure_id = null;
    $test->ref_value = "M";
    $test->save();

    $test = new LbTest();
    $test->code = "PARTIFA";
    $test->name = "PARATIFICA A";
    $test->group_id = 1;
    $test->measure_id = null;
    $test->ref_value = "M";
    $test->save();

    $test = new LbTest();
    $test->code = "PARTIFB";
    $test->name = "PARATIFICA B";
    $test->group_id = 1;
    $test->measure_id = null;
    $test->ref_value = "M";
    $test->save();

    $test = new LbTest();
    $test->code = "PROOX19";
    $test->name = "PROTEUS OX19";
    $test->group_id = 1;
    $test->measure_id = null;
    $test->ref_value = "M";
    $test->save();

    $test = new LbTest();
    $test->code = "PROOX2";
    $test->name = "PROTEUS OX2";
    $test->group_id = 1;
    $test->measure_id = null;
    $test->ref_value = "M";
    $test->save();

    $test = new LbTest();
    $test->code = "PROTEUS OXK";
    $test->name = "PROTEUS OXK";
    $test->group_id = 1;
    $test->measure_id = null;
    $test->ref_value = "M";
    $test->save();

    $test = new LbTest();
    $test->code = "TRANCOX";
    $test->name = "TRANSAMINASA COX";
    $test->group_id = 1;
    $test->measure_id = null;
    $test->ref_value = "M";
    $test->save();

    $test = new LbTest();
    $test->code = "TRANPIR";
    $test->name = "TRANSAMINASA PIR";
    $test->group_id = 1;
    $test->measure_id = null;
    $test->ref_value = "M";
    $test->save();

    $test = new LbTest();
    $test->code = "FOSFAA";
    $test->name = "FOSFATASA ALCALINA ADUL";
    $test->group_id = 1;
    $test->measure_id = null;
    $test->ref_value = "M";
    $test->save();

    $test = new LbTest();
    $test->code = "FOSFAN";
    $test->name = "FOSFATASA ALCALINA NIÑOS";
    $test->group_id = 1;
    $test->measure_id = null;
    $test->ref_value = "M";
    $test->save();

    $test = new LbTest();
    $test->code = "AMIL";
    $test->name = "AMILASA";
    $test->group_id = 1;
    $test->measure_id = null;
    $test->ref_value = "M";
    $test->save();

    $test = new LbTest();
    $test->code = "LIPASA";
    $test->name = "LIPASA";
    $test->group_id = 1;
    $test->measure_id = null;
    $test->ref_value = "M";
    $test->save();

    $test = new LbTest();
    $test->code = "COLOR";
    $test->name = "COLOR";
    $test->group_id = 4;
    $test->measure_id = null;
    $test->ref_value = "C";
    $test->save();

    $test = new LbTest();
    $test->code = "OLOR";
    $test->name = "OLOR";
    $test->group_id = 4;
    $test->measure_id = null;
    $test->ref_value = "C";
    $test->save();

    $test = new LbTest();
    $test->code = "SED";
    $test->name = "SEDIMENTO";
    $test->group_id = 4;
    $test->measure_id = null;
    $test->ref_value = "C";
    $test->save();

    $test = new LbTest();
    $test->code = "PH";
    $test->name = "PH";
    $test->group_id = 4;
    $test->measure_id = null;
    $test->ref_value = "M"; //I=INDEFINIDO
    $test->save();

    $test = new LbTest();
    $test->code = "DENSIDAD";
    $test->name = "DENSIDAD";
    $test->group_id = 4;
    $test->measure_id = null;
    $test->ref_value = "M";
    $test->save();

    $test = new LbTest();
    $test->code = "LEU";
    $test->name = "LEUCOCITURIA";
    $test->group_id = 4;
    $test->measure_id = null;
    $test->ref_value = "M";
    $test->save();

    $test = new LbTest();
    $test->code = "NIT";
    $test->name = "NITRITOS";
    $test->group_id = 4;
    $test->measure_id = null;
    $test->ref_value = "M";
    $test->save();

    $test = new LbTest();
    $test->code = "CET";
    $test->name = "CETONAS";
    $test->group_id = 4;
    $test->measure_id = null;
    $test->ref_value = "M";
    $test->save();

    $test = new LbTest();
    $test->code = "UROBILI";
    $test->name = "UROBILINOGENO";
    $test->group_id = 4;
    $test->measure_id = null;
    $test->ref_value = "M";
    $test->save();

    $test = new LbTest();
    $test->code = "SAHEME";
    $test->name = "SANGRE (HEM.ENTEROS)";
    $test->group_id = 4;
    $test->measure_id = null;
    $test->ref_value = "M";
    $test->save();

    $test = new LbTest();
    $test->code = "SAHLIS";
    $test->name = "SANGRE (H.LISADOS)";
    $test->group_id = 4;
    $test->measure_id = null;
    $test->ref_value = "M";
    $test->save();

    $test = new LbTest();
    $test->code = "ACASCOR";
    $test->name = "ACIDO ASCORBICO";
    $test->group_id = 4;
    $test->measure_id = null;
    $test->ref_value = "M";
    $test->save();

    $test = new LbTest();
    $test->code = "HEMA";
    $test->name = "HEMATIES";
    $test->group_id = 5;
    $test->measure_id = null;
    $test->ref_value = "M";
    $test->save();

    $test = new LbTest();
    $test->code = "LEUCOCITOS";
    $test->name = "LEUCOCITOS";
    $test->group_id = 5;
    $test->measure_id = null;
    $test->ref_value = "M";
    $test->save();

    $test = new LbTest();
    $test->code = "CEPI";
    $test->name = "CEL. EPITELIALES";
    $test->group_id = 5;
    $test->measure_id = null;
    $test->ref_value = "M";
    $test->save();

    $test = new LbTest();
    $test->code = "FMUC";
    $test->name = "FIL. MUCOSOS";
    $test->group_id = 5;
    $test->measure_id = null;
    $test->ref_value = "M";
    $test->save();

    $test = new LbTest();
    $test->code = "BACT";
    $test->name = "BACTERIAS";
    $test->group_id = 5;
    $test->measure_id = null;
    $test->ref_value = "M";
    $test->save();

    $test = new LbTest();
    $test->code = "BACILOS";
    $test->name = "BACILOS";
    $test->group_id = 5;
    $test->measure_id = null;
    $test->ref_value = "M";
    $test->save();

    $test = new LbTest();
    $test->code = "CRIST";
    $test->name = "CRISTALES";
    $test->group_id = 5;
    $test->measure_id = null;
    $test->ref_value = "M";
    $test->save();

    $test = new LbTest();
    $test->code = "CIL";
    $test->name = "CILINDROS";
    $test->group_id = 5;
    $test->measure_id = null;
    $test->ref_value = "M";
    $test->save();

    $test = new LbTest();
    $test->code = "PIO";
    $test->name = "PIOCITOS";
    $test->group_id = 5;
    $test->measure_id = null;
    $test->ref_value = "M";
    $test->save();

    $test = new LbTest();
    $test->code = "PRO";
    $test->name = "PROTOZOARIOS";
    $test->group_id = 3;
    $test->measure_id = null;
    $test->ref_value = "M";
    $test->save();

    $test = new LbTest();
    $test->code = "AMEBA HIS";
    $test->name = "AMEBA HISTOLITICA";
    $test->group_id = 3;
    $test->measure_id = null;
    $test->ref_value = "M";
    $test->save();

    $test = new LbTest();
    $test->code = "AMEBA COLI";
    $test->name = "AMEBA COLI";
    $test->group_id = 3;
    $test->measure_id = null;
    $test->ref_value = "M";
    $test->save();

    $test = new LbTest();
    $test->code = "GIARDIALAM";
    $test->name = "GIARDIA LAMBLIA";
    $test->group_id = 3;
    $test->measure_id = null;
    $test->ref_value = "M";
    $test->save();

    $test = new LbTest();
    $test->code = "TRICHOMONA";
    $test->name = "TRICHOMONA HOMINIS";
    $test->group_id = 3;
    $test->measure_id = null;
    $test->ref_value = "M";
    $test->save();

    $test = new LbTest();
    $test->code = "CHILOMASTIK";
    $test->name = "CHILOMASTIK MESNILE";
    $test->group_id = 3;
    $test->measure_id = null;
    $test->ref_value = "M";
    $test->save();

    $test = new LbTest();
    $test->code = "HELMIN";
    $test->name = "HELMINTOS";
    $test->group_id = 3;
    $test->measure_id = null;
    $test->ref_value = "M";
    $test->save();

    $test = new LbTest();
    $test->code = "TRICHURIS";
    $test->name = "TRICHURIS TRICHURA";
    $test->group_id = 3;
    $test->measure_id = null;
    $test->ref_value = "M";
    $test->save();

    $test = new LbTest();
    $test->code = "ASCARIS";
    $test->name = "ASCARIS LUMBRICOIDES";
    $test->group_id = 3;
    $test->measure_id = null;
    $test->ref_value = "M";
    $test->save();

    $test = new LbTest();
    $test->code = "STRONGY";
    $test->name = "STRONGYLOIDES STERCOLARIE";
    $test->group_id = 3;
    $test->measure_id = null;
    $test->ref_value = "M";
    $test->save();

    $test = new LbTest();
    $test->code = "OXIUROS";
    $test->name = "OXIUROS";
    $test->group_id = 3;
    $test->measure_id = null;
    $test->ref_value = "M";
    $test->save();
  }
}
