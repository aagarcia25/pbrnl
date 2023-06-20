<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Usuarios extends Model
{
    protected $fillable = [
        'idUsuario',
        'Nombre',
        'APaterno',
        'AMaterno',
        'Password',
        'RFC',
        'eMail',
        'TelefonoOficina',
        'TelefonoParticular',
        'idSecretaria',
        'idUnidad',
        'Puesto',
        'Estatus',
        'CambiarPwd',
        'TipoUsuario',
        'FechaNacimiento',
        'AdminEvalua',
        'CatalogosPbR',
        'ClasProgramatica',
        'AdminMIR',
        'CatBeneficiarios',
        'Notificado'
    ];
    protected $table = 'USUARIOS';
    public $timestamps = false;
    protected $primaryKey = 'idUsuario';
    
    public $incrementing = false;
    public function getKeyName(){
        return "idUsuario";
    }
}
