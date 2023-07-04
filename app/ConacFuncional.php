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
    protected $primaryKey = 'IdConac';
    public $incrementing = false;
    public function getKeyName(){
        return "IdConac";
    }
}
