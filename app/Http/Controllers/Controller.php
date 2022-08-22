<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
  use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

  public function toPagination(LengthAwarePaginator $paginator)
  {
    $data = $paginator->items();
    $perPage = $paginator->perPage();
    $total = $paginator->total();
    $currentPage = $paginator->currentPage();

    return response()->json(
      [
        'result' => $data,
        'pagination' => [
          'perPage' => $perPage,
          'total' => $total,
          'currentPage' => $currentPage
        ]
      ]
    );
  }
}
