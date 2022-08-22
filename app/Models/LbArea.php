<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LbArea extends Model
{
  use HasFactory;
  protected $table = 'lb_areas';

  public function groups()
  {
    return $this->hasMany(LbGroup::class, 'area_id', 'id');
  }
}
