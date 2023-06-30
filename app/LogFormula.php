<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LogFormula extends Model
{
    protected $fillable = [
        'Consecutivo',
    	'idElemento',
        'Seccion',
        'Elemento',
        'Descripcion',
        'ValorOriginal',
        'ValorModificado'
    ];
    protected $table = 'LogFormulasMIR';
    public $timestamps = false;
    protected $primaryKey = 'Consecutivo';
    public $incrementing = false;

    public function getKeyName(){
        return "Consecutivo";
    }
}
