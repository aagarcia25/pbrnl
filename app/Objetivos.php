<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Objetivos extends Model
{
    protected $fillable = [
        'IdEje',
    	'IdTema',
        'IdObjetivo',
        'Descripcion',
        'Activo'
    ];
    protected $table = 'OBJETIVO';
    public $timestamps = false;
    protected $primaryKey = ['IdEje', 'IdTema', 'IdObjetivo'];
    public $incrementing = false;

    public function getKeyName(){
        return "IdObjetivo";
    }
}
