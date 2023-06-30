<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MirCaratula extends Model
{
    protected $fillable = [
        'Consecutivo',
    	'EjercicioFiscal',
        'Estatus',
    	'CONAC',
        'idCatBeneficiario',
    	'idEje',
        'idTema',
    	'idObjetivo',
        'idEstrategia',
        'idLineaAccion',
        'idLineaAccion2',
    	'ProgramaSectorial',
        'idCatBeneficiario2',
        'LineaBase'
    ];
    protected $table = 'MIR_CARATULA';
    public $timestamps = false;
    protected $primaryKey = ['Consecutivo', 'EjercicioFiscal'];
    public $incrementing = false;

    public function getKeyName(){
        return "Consecutivo";
    }
}
