<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedPhysicalExploration extends Model
{
    use HasFactory;
    protected $table = 'med_physical_explorations';
    protected $hidden = [
        'created_at',
        'updated_at'
    ];
    protected $fillable = [
        'outerHabitus', //Habitus exterior
        'head',
        'eyes',
        'otorhinolaryngology',
        'neck', //cuello
        'chest', //abdomen
        'abdomen',
        'gynecologicalExamination',
        'genitals',
        'spine', //columna vertebral
        'extremities',
        'neurologicalExamination', //Exploracion neurologica
    ];
}
