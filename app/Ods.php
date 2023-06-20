<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ods extends Model
{
    protected $fillable = [
        'IdODS',
        'DescripcionCorta',
        'DescripcionLarga',
        'Activo'
    ];
    protected $table = 'ODS';
    public $timestamps = false;
    protected $primaryKey = 'IdODS';
    //protected $primaryKey = array('id','id_conac');
    public $incrementing = false;
    public function getKeyName(){
        return "IdODS";
    }
}
