<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Eje extends Model
{
    protected $fillable = [
        'IdEje',
        'Descripcion',
        'Activo'
    ];
    protected $table = 'EJE';
    public $timestamps = false;
    protected $primaryKey = 'IdEje';
    //protected $primaryKey = array('id','id_conac');
    public $incrementing = false;
    public function getKeyName(){
        return "IdEje";
    }
}
