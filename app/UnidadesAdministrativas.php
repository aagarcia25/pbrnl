<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UnidadesAdministrativas extends Model
{
    protected $fillable = [
        'idSecretaria',
    	'idUnidad',
        'Descripcion',
        'idConacFun',
        'Activo'
    ];
    protected $table = 'UNIDADES';
    public $timestamps = false;
    protected $primaryKey = ['idSecretaria', 'idUnidad'];
    public $incrementing = false;

    public function getKeyName(){
        return "idUnidad";
    }
}
