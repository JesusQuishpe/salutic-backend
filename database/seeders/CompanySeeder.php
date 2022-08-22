<?php

namespace Database\Seeders;

use App\Models\Company;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $model = new Company();
        $model->long_name = "SALUTIC";
        $model->short_name = "Salud y tecnología";
        $model->phone = "0963933794";
        $model->address = "9 de Mayo s/n entre 25 de Junio y Sucre";
        $model->email = "salutic@gmail.com";
        $model->logo_path = null;
        $model->start_hour = "08:00:00";
        $model->end_hour = "18:00:00";
        $model->save();
    }
}
