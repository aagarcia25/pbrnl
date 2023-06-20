<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Login extends Model
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
    //protected $primaryKey = array('id','id_conac');
    public $incrementing = false;
    public function getKeyName(){
        return "idUsuario";
    }
}
