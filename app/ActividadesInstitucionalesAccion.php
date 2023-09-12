<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ActividadesInstitucionalesAccion extends Model
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
        'ConacF',
        'ejercicioFiscal',
        'Id',
        'ProgramaticoId'
    ];
    protected $table = 'PROGRAMATICO_AI_COMP';
    public $timestamps = false;
    
    protected $primaryKey = 'Id';
    public $incrementing = true;
    public function getKeyName(){
        return 'Id';
    }
}
