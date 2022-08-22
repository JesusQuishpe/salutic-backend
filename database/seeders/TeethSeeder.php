<?php

namespace Database\Seeders;

use App\Models\OdoTooth;
use Illuminate\Database\Seeder;

class TeethSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    //Primer quadrant(Derecho)
    $quadrant = 1;
    for ($i = 8; $i >= 1; $i--) {
      $teeth = new OdoTooth();
      $teeth->type = "Vestibular";
      $teeth->quadrant = $quadrant;
      $teeth->teeth_num = $i;
      $teeth->dental_piece = strval($quadrant) . strval($i);
      $teeth->save();
    }

    $quadrant = 2;
    for ($i = 1; $i <= 8; $i++) {
      $teeth = new OdoTooth();
      $teeth->type = "Vestibular";
      $teeth->quadrant = $quadrant;
      $teeth->teeth_num = $i;
      $teeth->dental_piece = strval($quadrant) . strval($i);
      $teeth->save();
    }

    $quadrant = 3;
    for ($i = 1; $i <=8; $i++) {
      $teeth = new OdoTooth();
      $teeth->type = "Vestibular";
      $teeth->quadrant = $quadrant;
      $teeth->teeth_num = $i;
      $teeth->dental_piece = strval($quadrant) . strval($i);
      $teeth->save();
    }

    $quadrant = 4;
    for ($i = 8; $i >=1; $i--) {
      $teeth = new OdoTooth();
      $teeth->type = "Vestibular";
      $teeth->quadrant = $quadrant;
      $teeth->teeth_num = $i;
      $teeth->dental_piece = strval($quadrant) . strval($i);
      $teeth->save();
    }


    //Liguales
    $quadrant = 5;
    for ($i = 5; $i >= 1; $i--) {
      $teeth = new OdoTooth();
      $teeth->type = "Lingual";
      $teeth->quadrant = $quadrant;
      $teeth->teeth_num = $i;
      $teeth->dental_piece = strval($quadrant) . strval($i);
      $teeth->save();
    }

    $quadrant = 6;
    for ($i = 1; $i <= 5; $i++) {
      $teeth = new OdoTooth();
      $teeth->type = "Lingual";
      $teeth->quadrant = $quadrant;
      $teeth->teeth_num = $i;
      $teeth->dental_piece = strval($quadrant) . strval($i);
      $teeth->save();
    }

    $quadrant = 7;
    for ($i = 1; $i <= 5; $i++) {
      $teeth = new OdoTooth();
      $teeth->type = "Lingual";
      $teeth->quadrant = $quadrant;
      $teeth->teeth_num = $i;
      $teeth->dental_piece = strval($quadrant) . strval($i);
      $teeth->save();
    }

    $quadrant = 8;
    for ($i = 5; $i >=1; $i--) {
      $teeth = new OdoTooth();
      $teeth->type = "Lingual";
      $teeth->quadrant = $quadrant;
      $teeth->teeth_num = $i;
      $teeth->dental_piece = strval($quadrant) . strval($i);
      $teeth->save();
    }

  }
}
