<?php

namespace App\Http\Controllers;

use App\Roles;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RolesController extends Controller
{
    public function index()
    {
        $query = "SELECT * FROM ROL;";
        $informacion = DB::select($query);
        return response()->json(array('error' => false, 'data' => $informacion, 'code' => 200));
    }

    public function update(Request $request)
    {
        $update = Roles::find($request->Id);

        if (is_null($update)) {
            return response()->json(array('error' => true, 'result' => "El rol que intenta editar no existe.", 'code' => 404));
        }
        
        try {
            $update->RolAdmin           = $request->AccesoTotal;
            $update->RolAdd             = $request->Anadir;
            $update->RolEdit            = $request->Editar;
            $update->RolEditDatosMir    = $request->EditarDatosMir;
            $update->save();
        }catch (Exception $e) {
            return response()->json(array('error' => true , 'result' => $e->getMessage(), 'code' => 500));
        }
        
        return response()->json(array('error' => false, 'result' => "" , 'code' => 200));
    }

}
