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
        'idUA'
    ];
    protected $table = 'PROGRAMATICO';
    public $timestamps = false;
    
    protected $primaryKey = array('idObjetivoPED','idClasificacion','Consecutivo');
    public $incrementing = false;
    public function getKeyName(){
        return array('idObjetivoPED','idClasificacion','Consecutivo');
    }
}
