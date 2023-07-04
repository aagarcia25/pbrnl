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
    protected $primaryKey = 'IdTipologia';
    public $incrementing = false;
    public function getKeyName(){
        return "IdTipologia";
    }
}
