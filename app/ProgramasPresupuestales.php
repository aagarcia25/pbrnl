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
        'ejercicioFiscal',
        'Id'
    ];
    protected $table = 'PROGRAMATICO';
    public $timestamps = false;
    
    protected $primaryKey = "Id";
    public $incrementing = true;
    public function getKeyName(){
        return "Id";
    }
}
