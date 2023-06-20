<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UsuariosEnLinea extends Model
{
    protected $fillable = [
        'idUsuario',
    	'FechaLogin'
    ];
    protected $table = 'USUARIOS_LINEA';
    public $timestamps = false;
    protected $primaryKey = 'idUsuario';
    public $incrementing = false;

    public function getKeyName(){
        return "idUsuario";
    }
}
