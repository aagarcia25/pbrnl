<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LineasAccion extends Model
{
    protected $fillable = [
        'IdEje',
    	'IdTema',
        'IdObjetivo',
        'IdEstrategias',
        'IdLineaAccion',
        'Descripcion',
        'Activo'
    ];
    protected $table = 'LINEASACCION';
    public $timestamps = false;
    protected $primaryKey = ['IdEje', 'IdTema', 'IdObjetivo', 'IdEstrategias', 'IdLineaAccion'];
    public $incrementing = false;

    public function getKeyName(){
        return "IdLineaAccion";
    }
}
