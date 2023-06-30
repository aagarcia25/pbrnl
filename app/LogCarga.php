<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LogCarga extends Model
{
    protected $fillable = [
        'Consecutivo',
    	'idElemento',
        'Seccion',
        'Elemento',
        'Descripcion'
    ];
    protected $table = 'LogCargaMIR';
    public $timestamps = false;
    protected $primaryKey = 'Consecutivo';
    public $incrementing = false;

    public function getKeyName(){
        return "Consecutivo";
    }
}
