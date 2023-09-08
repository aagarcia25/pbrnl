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
        'idUA',
        'ProgramaticoId',
        'Id'
    ];
    protected $table = 'PROGRAMATICO_PI_COMP';
    public $timestamps = false;
    
    protected $primaryKey = 'Id';
    public $incrementing = true;
    public function getKeyName(){
        return 'Id';
    }
}
