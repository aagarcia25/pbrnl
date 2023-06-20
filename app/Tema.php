<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tema extends Model
{
    protected $fillable = [
        'IdEje',
    	'IdTema',
        'Descripcion',
        'Activo'
    ];
    protected $table = 'TEMA';
    public $timestamps = false;
    protected $primaryKey = ['IdEje', 'IdTema'];
    public $incrementing = false;

    public function getKeyName(){
        return "IdTema";
    }
}
