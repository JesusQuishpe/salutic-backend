<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user=new User();
        $user->name="jesustfp";
        $user->email="jesusquishpe17@gmail.com";
        $user->password=Hash::make('admin');
        $user->rol_id=1;
        $user->company_id=1;
        $user->save();
    }
}
