<?php

namespace Database\Seeders;

use App\Models\Cie;
use Illuminate\Database\Seeder;

class CieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $fp = fopen('C:\Users\jesus\Desktop\recursos-tesis\CIE 10\CIE10ES_2022_Tabla_Referencia_Diagnosticos_08_03_2022.csv', 'r');
        $index = 0;
        while ($data = fgetcsv($fp, 1000, ",",'"','"')) {
            if ($index > 0) {
                $code = $data[0];
                $disease = $data[1];
                $cie = new Cie();
                $cie->code = $code;
                $cie->disease = $disease;
                $cie->save();
            }
            $index++;
        }
    }
}
