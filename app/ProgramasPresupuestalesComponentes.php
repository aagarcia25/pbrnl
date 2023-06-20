<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProgramasPresupuestalesComponentes extends Model
{
    protected $fillable = [
        'idObjetivoPED',
        'idClasificacion',
        'Consecutivo',
        'Componente',
        'idSecretaria',
        'idUA',
        'DescripcionComponente',
        'Observaciones',
        'ConacF'
    ];
    protected $table = 'PROGRAMATICO_COMP';
    public $timestamps = false;
    
    protected $primaryKey = array('idObjetivoPED','idClasificacion','Consecutivo','idSecretaria');
    public $incrementing = false;
    public function getKeyName(){
        return array('idObjetivoPED','idClasificacion','Consecutivo','idSecretaria');
    }
}
