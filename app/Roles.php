<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Roles extends Model
{
    protected $fillable = [
        'Descripcion',
        'RolAdmin',
        'RolAdd',
        'RolEdit',
        'RolDel',
        'RolRevisar',
        'RolAutorizar',
        'RolEditDatosMir'
    ];
    protected $table = 'ROL';
    public $timestamps = false;
    protected $primaryKey = 'idRol';
    //protected $primaryKey = array('id','id_conac');
    public $incrementing = false;
    public function getKeyName(){
        return "idRol";
    }
}
