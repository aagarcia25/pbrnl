<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProgramasProyectosInversion extends Model
{
    protected $fillable = [
        'idObjetivoPED',
        'idClasificacion',
        'Consecutivo',
        'Componente',
        'ClaveFuncional',
        'Anticorrupcion',
        'idTipologia',
        'DescripcionPrograma',
        'idSecretaria',
        'idUA'
    ];
    protected $table = 'PROGRAMATICO_PI_COMP';
    public $timestamps = false;
    
    protected $primaryKey = array('idObjetivoPED','idClasificacion','Consecutivo','ejercicioFiscal');
    public $incrementing = false;
    public function getKeyName(){
        return array('idObjetivoPED','idClasificacion','Consecutivo','ejercicioFiscal');
    }
}
