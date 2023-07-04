<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ConacAdministrativo extends Model
{
    protected $fillable = [
        'IdConac',
        'Descripcion'
    ];
    protected $table = 'CONAC_ADM';
    protected $primaryKey = 'IdConac';
    public $incrementing = false;
    public function getKeyName(){
        return "IdConac";
    }
}
