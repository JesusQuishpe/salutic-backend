<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cie extends Model
{
    use HasFactory;
    protected $table='cies';


    public static function searchByDisease($diseaseName)
    {
      return Cie::where('disease','like','%'.$diseaseName.'%')->take(10)->get();
    }

    public static function searchByDiseaseWithPagination($diseaseName)
    {
      return Cie::where('disease','like','%'.$diseaseName.'%')->paginate(10);
    }
}
