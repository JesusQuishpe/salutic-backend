<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estudio extends Model
{
  use HasFactory;
  protected $table = "lb_estudios";

  public function unidad()
  {
    return $this->hasOne(Unidad::class,"id",'id_unidad');
  }
  public function examenes()
  {
    return $this->belongsToMany(Examen::class,'lb_examenes_estudios','id_estudio','id_examen');
  }
  public function children()
  {
    return $this
    ->belongsToMany(Estudio::class,"lb_estudios_det",'id_estudio_padre','id_estudio_hijo');
  }
}
