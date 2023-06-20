<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ConacTipologia extends Model
{
    protected $fillable = [
        'IdTipologia',
        'Descripcion'
    ];
    protected $table = 'TIPOLOGIA';
    //public $timestamps = false;
    protected $primaryKey = 'IdTipologia';
    //protected $primaryKey = array('id','id_conac');
    public $incrementing = false;
    public function getKeyName(){
        return "IdTipologia";
    }
}
