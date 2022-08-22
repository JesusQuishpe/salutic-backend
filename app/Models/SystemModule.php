<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SystemModule extends Model
{
  use HasFactory;
  protected $table = 'system_modules';

  /*public function operaciones()
    {
        return $this->belongsToMany(Operacion::class,'modulo_operaciones','id_modulo','id_operacion');
    }*/

  public function submodules()
  {
    return $this->hasMany(SystemModule::class, 'parent_id', 'id')->where('enable', '=', true);
  }

  public function parent()
  {
    return $this->belongsTo(SystemModule::class, 'parent_id', 'id');
  }
}
