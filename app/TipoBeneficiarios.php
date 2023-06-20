<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoBeneficiarios extends Model
{
    protected $fillable = [
        'idBeneficiario',
        'TipoBeneficiario'
    ];
    
    protected $table = 'TIPO_BENEFICIARIO';
    
    public $timestamps = false;
    
    protected $primaryKey = 'idBeneficiario';
    
    public $incrementing = false;
    
    public function getKeyName(){
        return "idBeneficiario";
    }
}
