<?php

namespace Database\Seeders;

use App\Models\OdoDiseaseList;
use Illuminate\Database\Seeder;

class DiseaseListSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $dis=new OdoDiseaseList();
        $dis->name="Alergia antibiótico";
        $dis->save();

        $dis=new OdoDiseaseList();
        $dis->name="Alergia anestesia";
        $dis->save();

        $dis=new OdoDiseaseList();
        $dis->name="Hemorragias";
        $dis->save();

        $dis=new OdoDiseaseList();
        $dis->name="vih/sida";
        $dis->save();

        $dis=new OdoDiseaseList();
        $dis->name="Tuberculosis";
        $dis->save();

        $dis=new OdoDiseaseList();
        $dis->name="Asma";
        $dis->save();

        $dis=new OdoDiseaseList();
        $dis->name="Diabetes";
        $dis->save();

        $dis=new OdoDiseaseList();
        $dis->name="Hipertensión";
        $dis->save();

        $dis=new OdoDiseaseList();
        $dis->name="Enf. cardiaca";
        $dis->save();

        $dis=new OdoDiseaseList();
        $dis->name="Otro";
        $dis->save();
    }
}
