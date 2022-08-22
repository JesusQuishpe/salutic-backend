<?php

namespace Database\Seeders;

use App\Models\LbMeasurement;
use App\Models\Unidad;
use Illuminate\Database\Seeder;

class MeasurementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $measure=new LbMeasurement();
        $measure->name="Gramos por decilitro";
        $measure->abbreviation="g/dL";
        $measure->save();

        $measure=new LbMeasurement();
        $measure->name="Gramos por litro";
        $measure->abbreviation="g/L";
        $measure->save();

        $measure=new LbMeasurement();
        $measure->name="Microlitros";
        $measure->abbreviation="mcL";
        $measure->save();

        $measure=new LbMeasurement();
        $measure->name="Miligramos por decilitro";
        $measure->abbreviation="mg/dL";
        $measure->save();
    }
}
