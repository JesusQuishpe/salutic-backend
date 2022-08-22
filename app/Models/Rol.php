<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    use HasFactory;
    protected $table = 'roles';

    public function permissions()
    {
        //return $this->belongsToMany(SystemModule::class,'permissions','rol_id','module_id');
        return $this->hasMany(Permission::class, 'rol_id', 'id');
    }
}
