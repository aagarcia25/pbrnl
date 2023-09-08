<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ActividadesInstitucionales extends Model
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
        'ejercicioFiscal',
        'Id'
    ];
    protected $table = 'PROGRAMATICO_AI_COMP';
    public $timestamps = false;
    
    protected $primaryKey = 'Id';
    public $incrementing = false;
    public function getKeyName(){
        return 'Id';
    }
}
