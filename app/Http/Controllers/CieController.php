<?php

namespace App\Http\Controllers;

use App\Models\Cie;
use Illuminate\Http\Request;

class CieController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {
    if ($request->has('disease')) {
      $results = Cie::searchByDisease($request->input('disease'));
      return response()->json($results);
    }
    return $this->toPagination(Cie::paginate(10));
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $cie = new Cie();
    $cie->disease = $request->disease;
    $cie->code = $request->code;
    $cie->save();
    return response()->json($cie, 204);
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\Cie  $cie
   * @return \Illuminate\Http\Response
   */
  public function show(Cie $cie)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\Cie  $cie
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, Cie $cie)
  {
    $cie->disease = $request->disease;
    $cie->code = $request->code;
    $cie->save();
    return response()->json($cie, 204);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\Cie  $cie
   * @return \Illuminate\Http\Response
   */
  public function destroy(Cie $cie)
  {
    $cie->delete();
    return response()->json([], 204);
  }

  public function search(Request $request)
  {
    //return response()->json($request->all());
    $cie = (new Cie())->newQuery();

    if ($request->input('name')) {
      $cie->where('disease', 'LIKE', '%' . $request->input('name') . '%');
    }
    return $this->toPagination($cie->paginate(10));
  }
}
