<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Estrategias extends Model
{
    protected $fillable = [
        'IdEje',
    	'IdTema',
        'IdObjetivo',
        'IdEstrategias',
        'Descripcion',
        'Activo'
    ];
    protected $table = 'ESTRATEGIAS';
    public $timestamps = false;
    protected $primaryKey = ['IdEje', 'IdTema', 'IdObjetivo', 'IdEstrategias'];
    public $incrementing = false;

    public function getKeyName(){
        return array('IdEje', 'IdTema', 'IdObjetivo', 'IdEstrategias');
    }
}
