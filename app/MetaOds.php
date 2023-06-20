<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MetaOds extends Model
{
    protected $fillable = [
        'IdODS',
    	'IdMETAODS',
        'Descripcion',
        'Activo'
    ];
    protected $table = 'METAODS';
    public $timestamps = false;
    protected $primaryKey = ['IdODS', 'IdMETAODS'];
    public $incrementing = false;

    public function getKeyName(){
        return "IdMETAODS";
    }
}
