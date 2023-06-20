<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Beneficiarios extends Model
{
    protected $fillable = [
        'idCatBeneficiario',
        'idBeneficiario',
        'Poblacion'
    ];
    
    protected $table = 'CAT_BENEFICIARIO';
    
    public $timestamps = false;
    
    protected $primaryKey = 'idCatBeneficiario';
    
    public $incrementing = false;
    
    public function getKeyName(){
        return "idCatBeneficiario";
    }
}
