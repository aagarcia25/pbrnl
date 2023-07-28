<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProgramasPresupuestales extends Model
{
    protected $fillable = [
        'idObjetivoPED',
        'idClasificacion',
        'Consecutivo',
        'Anticorrupcion',
        'idTipologia',
        'DescripcionPrograma',
        'idSecretaria',
        'idUA',
        'ejercicioFiscal'
    ];
    protected $table = 'PROGRAMATICO';
    public $timestamps = false;
    
    protected $primaryKey = array('idObjetivoPED','idClasificacion','Consecutivo','ejercicioFiscal');
    public $incrementing = false;
    public function getKeyName(){
        return array('idObjetivoPED','idClasificacion','Consecutivo','ejercicioFiscal');
    }
}
