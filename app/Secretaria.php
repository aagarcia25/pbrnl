<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Secretaria extends Model
{
    protected $fillable = [
        'idSecretaria',
    	'Conac',
        'Descripcion',
        'Activo'
    ];
    protected $table = 'SECRETARIAS';
    public $timestamps = false;
    protected $primaryKey = 'idSecretaria';
    //protected $primaryKey = array('id','id_conac');
    public $incrementing = false;
    public function getKeyName(){
        return "idSecretaria";
    }
}
