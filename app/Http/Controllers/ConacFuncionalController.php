<?php

namespace App\Http\Controllers;

use Validator;
use App\ConacFuncional;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class ConacFuncionalController extends Controller
{
    public function index()
    {
        $query = "SELECT * FROM CONAC_FUN WHERE Seleccionar = 'S';";
        $informacion = DB::select($query);
        return response()->json(array('error' => false, 'data' => $informacion, 'code' => 200));
    }

}

?>
