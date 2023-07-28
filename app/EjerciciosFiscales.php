<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EjerciciosFiscales extends Model
{
    protected $fillable = [
        'Id',
        'Comentarios',
        'Estatus'
    ];
    protected $table = 'EJERCICIOS_FISCALES';
    public $timestamps = false;

    protected $primaryKey = array('Id');
    public $incrementing = false;
    public function getKeyName(){
        return array('Id');
    }
}
