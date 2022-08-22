<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedInterrogation extends Model
{
    use HasFactory;
    protected $table = 'med_interrogations';
    protected $hidden = [
        'created_at',
        'updated_at'
    ];
    protected $fillable = [
        'cardiovascular',
        'digestive',
        'endocrine',
        'hemolymphatic', //hemolinfatico
        'mamas',
        'skeletalMuscle', //musculo esqueletico
        'skinAndAnnexes', //Piel y anexos
        'reproductive', //Reproductor
        'respiratory', //respiratorio
        'nervousSystem', //sistema nervioso
        'generalSystems', //sistemas generales
        'urinary', //urninario
    ];
}
