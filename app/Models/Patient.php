<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
  use HasFactory;
  protected $table = 'patients';
  protected $fillable = [
    'identification',
    'name',
    'lastname',
    'fullname',
    'birth_date',
    'age',
    'gender',
    'cellphone',
    'address',
    'province',
    'city',
    //Para la parte del area de medicina
    'email',
    'notes',
    'occupation',
    'marital_status', //Estado civil
    'mother_name',
    'father_name',
    'origin', //Procedencia
    'couple_name',
  ];

  protected $hidden = [
    'created_at',
    'updated_at',
  ];

  /**
   * Busca todos los pacientes que coincidan con
   * el apellido o la cedula
   * @param string $texto cedula
   */
  public function getPatientByIdentification($query)
  {
    return Patient::where('identification', '=', $query)
      ->firstOrFail();
  }

  /**
   * Busca todos los pacientes que coincidan con
   * el apellido o la cedula
   * @param string $texto cedula o apellidos del paciente
   */
  public function searchByIdentificationOrLastname($query)
  {
    if ($query === "") {
      return Patient::take(10);
    } else {
      return Patient::where('identification', '=', $query)
        ->orWhere('fullname', 'LIKE', '%' . $query . '%')
        ->get();
    }
  }
}
