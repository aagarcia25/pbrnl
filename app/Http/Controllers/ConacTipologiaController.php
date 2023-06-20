<?php

namespace App\Http\Controllers;

use Validator;
use App\ConacTipologia;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class ConacTipologiaController extends Controller
{
    public function index()
    {
        $query = "SELECT * FROM TIPOLOGIA;";
        $informacion = DB::select($query);
        return response()->json(array('error' => false, 'data' => $informacion, 'code' => 200));
    }

}

?>
