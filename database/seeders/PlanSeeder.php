<?php

namespace Database\Seeders;

use App\Models\OdoPlan;
use Illuminate\Database\Seeder;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $plan=new OdoPlan();
        $plan->name="Biometría";
        $plan->save();

        $plan=new OdoPlan();
        $plan->name="Química sanguínea";
        $plan->save();

        $plan=new OdoPlan();
        $plan->name="Rayos x";
        $plan->save();

        $plan=new OdoPlan();
        $plan->name="Otros";
        $plan->save();

    }
}
