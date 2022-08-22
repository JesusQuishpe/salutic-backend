<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //\App\Models\User::factory(10)->create();
        //$this->call(PatientSeeder::class);
        //$this->call(DoctorSeeder::class);
        //$this->call(CieSeeder::class);
        $this->call(CompanySeeder::class);
        $this->call(PathologieSeeder::class);
        $this->call(DiseaseListSeeder::class);
        $this->call(SystemModuleSeeder::class);
        $this->call(RolSeeder::class);
        $this->call(PermissionSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(PlanSeeder::class);
        $this->call(TeethSeeder::class);
        $this->call(SymbologieSeeder::class);
        $this->call(MeasurementSeeder::class);
        $this->call(AreaSeeder::class);
        $this->call(GroupSeeder::class);
        $this->call(TestSeeder::class);
        //$this->call(CitaSeeder::class);
    }
}
