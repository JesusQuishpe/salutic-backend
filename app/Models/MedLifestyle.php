<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedLifestyle extends Model
{
    use HasFactory;
    protected $table='med_lifestyles';
    protected $fillable=[
        //Actividad Fisica
        'doExercise',
        'minPerDay',
        'doSport',
        'sportDescription',
        'sportFrequency',
        'sleep',
        'sleepHours',
        //Tabaquismo
        'smoke',
        'startSmokingAge',
        'formerSmoker',
        'cigarsPerDay',
        'passiveSmoker',
        'stopSmokingAge',
        //Habitos alimenticios
        'breakfast',
        'mealsPerDay',
        'drinkCoffe',
        'cupsPerDay',
        'drinkSoda',
        'doDiet',
        'dietDescription',
        //Otros
        'workAuthonomy',//Autonomia en el trabajo
        'workShift',//Turno en el trabajo
        'hobbies',//Actividades que realiza en tiempos libres
        'otherSituations',
        //Consumo de drogas
        'takeDrugs',//Consume drogas
        'formerAddict',
        'startAgeConsume',
        'stopAgeConsume',
        'ivDrugs',//Droga intravenosa
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    /*protected $casts = [
        'doExercise' => 'boolean',
    ];*/
}
