<?php

namespace Database\Seeders;

use App\Models\OdoPathologie;
use Illuminate\Database\Seeder;

class PathologieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pat=new OdoPathologie();
        $pat->name="Labios";
        $pat->save();

        $pat=new OdoPathologie();
        $pat->name="Mejillas";
        $pat->save();

        $pat=new OdoPathologie();
        $pat->name="Maxilar superior";
        $pat->save();

        $pat=new OdoPathologie();
        $pat->name="Maxilar inferior";
        $pat->save();

        $pat=new OdoPathologie();
        $pat->name="Lengua";
        $pat->save();

        $pat=new OdoPathologie();
        $pat->name="Paladar";
        $pat->save();

        $pat=new OdoPathologie();
        $pat->name="Piso";
        $pat->save();

        $pat=new OdoPathologie();
        $pat->name="Carrillos";
        $pat->save();

        $pat=new OdoPathologie();
        $pat->name="Glándulas salivales";
        $pat->save();

        $pat=new OdoPathologie();
        $pat->name="Oro faringe";
        $pat->save();

        $pat=new OdoPathologie();
        $pat->name="A.T.M";
        $pat->save();

        $pat=new OdoPathologie();
        $pat->name="Ganglios";
        $pat->save();
    }
}
