<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Basecontroller;
use Exception;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CargarProgramasController extends BaseController
{
    public function CargarProgramas(Request $request)
    {
        $file = $request->file("archivo");

        return response()->json(array('error' => false, 'data' => '', 'code' => 200));
    }
}

?>
