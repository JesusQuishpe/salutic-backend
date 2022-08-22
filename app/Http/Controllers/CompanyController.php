<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Carbon\Carbon;
use Error;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CompanyController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    //
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {

    $logo_path = null;
    $data = json_decode($request->input('data'));
    if ($request->hasFile('logo')) {
      $logo_path = $request->file('logo')->store('logos');
    }

    $model = new Company();
    $model->long_name = $data->long_name;
    $model->short_name = $data->short_name;
    $model->phone = $data->phone;
    $model->address = $data->address;
    $model->email = $data->email;
    $model->logo_path = $logo_path;
    $model->start_hour = $data->start_hour;
    $model->end_hour = $data->end_hour;
    $model->save();

    return response()->json($model);
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\Company  $company
   * @return \Illuminate\Http\Response
   */
  public function show(Company $company)
  {
    $exist = $company ? true : false;
    return $exist ?
      response()->json($company) :
      response()->json(['message' => 'No existe la empresa'], 404);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\Company  $company
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, Company $company)
  {
    try {
      
      $logo_path = $company->logo_path;
      $logoNameOfFile = basename(Storage::path($logo_path));
      $data = json_decode($request->input('data'));
      //return response()->json($data);
      if ($request->hasFile('logo')) {
        if ($logo_path) { //Se debe eliminar el anterior logo y actualizar con el actual
          Storage::move($logo_path, 'logos-eliminados/' . $logoNameOfFile);
          $logo_path = $request->file('logo')->store('logos');
        } else {
          $logo_path = $request->file('logo')->store('logos');
        }
      }

      $company->long_name = $data->long_name;
      $company->short_name = $data->short_name;
      $company->phone = $data->phone;
      $company->address = $data->address;
      $company->email = $data->email;
      $company->logo_path = $logo_path;
      $company->start_hour = $data->start_hour;
      $company->end_hour = $data->end_hour;
      $company->save();
      return response()->json($company);
    } catch (\Throwable $th) {
      //
      if (isset($logo_path) && Storage::exists($logo_path)) {
        //Restablecemos el anterior logo y eliminamos el nuevo
        Storage::move(
          'logos-eliminados/' . $logoNameOfFile,
          $logo_path
        ); //Movemos el antiguo odontograma a su respectivo directorio
        Storage::delete($logo_path); //Eliminamos el nuevo odontograma
      }
      throw $th;
    }
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\Company  $company
   * @return \Illuminate\Http\Response
   */
  public function destroy(Company $company)
  {
    //
  }
}
