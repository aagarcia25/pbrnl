<?php

namespace App\Http\Controllers;

use App\Objetivos;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ObjetivosController extends Controller
{
    public function all()
    {
        $query = "SELECT * FROM OBJETIVO WHERE Activo = 'S';";
        $informacion = DB::select($query);
        return response()->json(array('error' => false, 'data' => $informacion, 'code' => 200));
    }
}
