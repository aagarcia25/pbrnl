<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ConacFuncional extends Model
{
    protected $fillable = [
        'IdConac',
        'Descripcion'
    ];
    protected $table = 'CONAC_FUN';
    //public $timestamps = false;
    protected $primaryKey = 'IdConac';
    //protected $primaryKey = array('id','id_conac');
    public $incrementing = false;
    public function getKeyName(){
        return "IdConac";
    }
}
