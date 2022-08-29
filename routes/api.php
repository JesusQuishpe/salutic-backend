<?php

use App\Http\Controllers\CieController;
use App\Http\Controllers\CitationController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ExpedientController;
use App\Http\Controllers\LaboratoryController;
use App\Http\Controllers\LbAreaController;
use App\Http\Controllers\LbGroupController;
use App\Http\Controllers\LbOrderController;
use App\Http\Controllers\LbResultController;
use App\Http\Controllers\LbTestController;
use App\Http\Controllers\LbUnitController;
use App\Http\Controllers\MedConsultationController;
use App\Http\Controllers\NursingController;
use App\Http\Controllers\OdontologyController;
use App\Http\Controllers\OdoPDFController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RolController;
use App\Http\Controllers\SystemModuleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['prefix' => 'v1'], function () {
  //Pdf routes
  Route::get('odontologia/pdf/{recId}',[OdoPDFController::class,'pdf']);
  Route::get('resultado/pdf/{orderId}',[LaboratoryController::class,'pdf']);
  Route::get('permisos',[PermissionController::class,'index']);
  //Delete routes
  Route::delete('enfermeria/{appoId}/eliminar-paciente',[NursingController::class,'removeOfQueue']);
  Route::delete('medicina/{appoId}/eliminar-paciente',[MedConsultationController::class,'removeOfQueue']);
  Route::delete('odontologia/{appoId}/eliminar-paciente',[OdontologyController::class,'removeOfQueue']);
  //Posts
  Route::post('permisos',[PermissionController::class,'store']);
  //Search
  Route::get('cies/search',[CieController::class,'search']);
  Route::apiResource('modulos', SystemModuleController::class)->parameters(['modulos' => 'module']);
  Route::apiResource('citas', CitationController::class)->parameters(['citas' => 'citation']);
  Route::apiResource('enfermerias', NursingController::class)->parameters(['enfermerias' => 'nursing']);
  Route::apiResource('odontologias', OdontologyController::class)->parameters(['odontologias' => 'odontology']);
  //Route::apiResource('medicinas', MedicineController::class)->parameters(['medicinas' => 'medicine']);
  Route::apiResource('expedientes', ExpedientController::class)->parameters(['expedientes' => 'expedient']);
  Route::apiResource('med-consultations', MedConsultationController::class)->parameters(['med-consultations' => 'consultation']);
  Route::apiResource('patients', PatientController::class)->parameters(['patients' => 'patient']);
  Route::apiResource('areas', LbAreaController::class)->parameters(['areas' => 'area']);
  Route::apiResource('grupos', LbGroupController::class)->parameters(['grupos' => 'group']);
  Route::apiResource('pruebas', LbTestController::class)->parameters(['pruebas' => 'test']);
  Route::apiResource('unidades', LbUnitController::class)->parameters(['unidades' => 'unit']);
  Route::apiResource('ordenes', LbOrderController::class)->parameters(['ordenes' => 'order']);
  Route::apiResource('resultados',LbResultController::class)->parameters(['resultados'=>'lb_result']);
  Route::apiResource('cies', CieController::class)->parameters(['cies' => 'cie']);
  Route::apiResource('roles', RolController::class)->parameters(['roles' => 'rol']);
  Route::apiResource('usuarios', UserController::class)->parameters(['usuarios' => 'user']);
  Route::apiResource('empresas',CompanyController::class)->parameters(['empresas'=>'company']);
  Route::post('login', [UserController::class, 'login']);
  Route::put('usuarios/password-change/{id}', [UserController::class, 'passwordChange']);
});
