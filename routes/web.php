<?php

use App\Http\Controllers\ObjetivosController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SecretariaController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('Login'); // En resources -> views - index.php -- Así se llama la vista principal donde entraran 
});
Route::get('/Login', function () {
    return view('Login'); // En resources -> views - index.php -- Así se llama la vista principal donde entraran 
});
Route::post('AccessLogin','LoginController@login');
Route::get('Logout','LoginController@logout');
Route::get('/RecuperacionCredencial/{id_usuario}', function ($id_usuario) {
    return view('RecuperacionCredencial', [
        'id_usuario' => $id_usuario
    ]);
});
Route::post('RecoverPassword','LoginController@recover'); 
Route::post('SolicitarRecuperacionContrasena','LoginController@solicitar_recuperacion'); 

// Menu principal
Route::get('/Menu', function () {
    return view('Menu'); // En resources -> views - index.php -- Así se llama la vista principal donde entraran 
});

// Catalogos
Route::get('/Catalogos', function () {
    return view('Catalogos'); // En resources -> views - index.php -- Así se llama la vista principal donde entraran 
});

// ========================================
// C A T Á L O G O S   A D M I N I S T R A T I V O S
// ========================================

    // Catalogo conac administrativo
    Route::get('/ConacAdministrativo', function () {
        return view('CatConacAdministrativo'); // En resources -> views - index.php -- Así se llama la vista principal donde entraran 
    });
    Route::get('GetConacAdministrativo','ConacAdministrativoController@index');

    // Secretarias
    Route::get('/Secretarias', function () {
        return view('CatSecretarias'); // En resources -> views - index.php -- Así se llama la vista principal donde entraran 
    });
    Route::get('GetSecretarias',[SecretariaController::class,'index']);
    Route::post('AddSecretaria',[SecretariaController::class,'insert']);
    Route::post('EditSecretaria',[SecretariaController::class,'update']);
    Route::post('DeleteSecretaria',[SecretariaController::class,'delete']);

    // Unidades administrativas
    Route::get('/UnidadesAdministrativas', function () {
        return view('CatUnidadesAdministrativas'); // En resources -> views - index.php -- Así se llama la vista principal donde entraran 
    });
    Route::get('GetAllUnidadesAdministrativas','UnidadesAdministrativasController@all');
    Route::post('GetUnidadesAdministrativas','UnidadesAdministrativasController@index');
    Route::post('AddUnidadAdministrativa','UnidadesAdministrativasController@insert');
    Route::post('EditUnidadAdministrativa','UnidadesAdministrativasController@update');
    Route::post('DeleteUnidadAdministrativa','UnidadesAdministrativasController@delete');

    // Catalogo conac funcional
    Route::get('/ConacFuncional', function () {
        return view('CatConacFuncional'); // En resources -> views - index.php -- Así se llama la vista principal donde entraran 
    });
    Route::get('GetConacFuncional','ConacFuncionalController@index');

    // Catalogo conac tipologia
    Route::get('/ConacTipologia', function () {
        return view('CatConacTipologia'); // En resources -> views - index.php -- Así se llama la vista principal donde entraran 
    });
    Route::get('GetConacTipologia','ConacTipologiaController@index');

// ========================================
// C A T Á L O G O S   P R O G R A M Á T I C O S
// ========================================

    // Programas presupuestales
    Route::get('/ProgramasPresupuestarios', function () {
        return view('CatProgramasPresupuestales'); // En resources -> views - index.php -- Así se llama la vista principal donde entraran 
    });
    Route::get('GetAllProgramasPP','ProgramasPresupuestalesController@all');
    Route::post('GetProgramasPP','ProgramasPresupuestalesController@index');
    Route::post('GetInfoComponentesPP','ProgramasPresupuestalesController@info');
    Route::post('GetComponentesPP','ProgramasPresupuestalesController@components');
    Route::post('EditComponentePP','ProgramasPresupuestalesController@updatecomponent');
    Route::post('EditProgramaPresupuestal','ProgramasPresupuestalesController@updatepp');

    Route::get('GetAllCountProgramasP','ProgramasPresupuestalesController@countall');
    Route::get('GetCountProgramasP','ProgramasPresupuestalesController@count');


    // Actividades institucionales
    Route::get('/ActividadesInstitucionales', function () {
        return view('CatActividadesInstitucionales'); // En resources -> views - index.php -- Así se llama la vista principal donde entraran 
    });
    Route::get('GetAllActividadesAI','ActividadesInstitucionalesController@all');
    Route::post('GetActividadesAI','ActividadesInstitucionalesController@index');
    Route::post('GetInfoComponentesAI','ActividadesInstitucionalesController@info');
    Route::post('GetComponentesAI','ActividadesInstitucionalesController@components');
    Route::post('EditComponenteAI','ActividadesInstitucionalesController@updatecomponent');
    Route::post('EditActividadInstitucional','ActividadesInstitucionalesController@updatepp');
    Route::get('GetAllCountActividadesAI','ActividadesInstitucionalesController@countall');
    Route::get('GetCountActividadesAI','ActividadesInstitucionalesController@count');

    // Programas y proyectos de inversión
    Route::get('/ProgramasProyectosInversion', function () {
        return view('CatProgramasProyectosInversion'); // En resources -> views - index.php -- Así se llama la vista principal donde entraran 
    });
    Route::get('GetAllPPI','ProgramasProyectosInversionController@all');
    Route::post('GetPPI','ProgramasProyectosInversionController@index');
    Route::post('GetInfoComponentesPPI','ProgramasProyectosInversionController@info');
    Route::post('GetComponentesPPI','ProgramasProyectosInversionController@components');
    Route::post('EditComponentePPI','ProgramasProyectosInversionController@updatecomponent');
    Route::post('EditProgramaPresupuestoInversion','ProgramasProyectosInversionController@updatepp');
    Route::get('GetAllCountPPI','ProgramasProyectosInversionController@countall');
    Route::get('GetCountPPI','ProgramasProyectosInversionController@count');

// ========================================
// C A T Á L O G O S   P L A N E A C I O N E S
// ========================================

    // Eje
    Route::get('/Eje', function () {
        return view('CatEje'); // En resources -> views - index.php -- Así se llama la vista principal donde entraran 
    });
    Route::get('GetEjes','EjeController@index');
    Route::post('AddEje','EjeController@insert');
    Route::post('EditEje','EjeController@update');
    Route::post('DeleteEje','EjeController@delete');

    // Ods
    Route::get('/Ods', function () {
        return view('CatOds'); // En resources -> views - index.php -- Así se llama la vista principal donde entraran 
    });
    Route::get('GetOds','OdsController@index');
    Route::post('AddOds','OdsController@insert');
    Route::post('EditOds','OdsController@update');
    Route::post('DeleteOds','OdsController@delete');

    // Meta Ods
    Route::get('/MetaOds', function () {
        return view('CatMetaOds'); // En resources -> views - index.php -- Así se llama la vista principal donde entraran 
    });
    Route::post('GetMetaOds','MetaOdsController@index');
    Route::post('AddMetaOds','MetaOdsController@insert');
    Route::post('EditMetaOds','MetaOdsController@update');
    Route::post('DeleteMetaOds','MetaOdsController@delete');

    // Tema
    Route::get('/Tema', function () {
        return view('CatTema'); // En resources -> views - index.php -- Así se llama la vista principal donde entraran 
    });
    Route::get('GetAllTemas','TemaController@all');
    Route::post('GetTemas','TemaController@index');
    Route::post('AddTema','TemaController@insert');
    Route::post('EditTema','TemaController@update');
    Route::post('DeleteTema','TemaController@delete');

    // Objetivos
    Route::get('/Objetivos', function () {
        return view('CatObjetivos'); // En resources -> views - index.php -- Así se llama la vista principal donde entraran 
    });
    Route::get('GetAllObjetivos','ObjetivosController@all');
    Route::post('GetObjetivos','ObjetivosController@index');
    Route::post('AddObjetivo', 'ObjetivosController@insert');
    Route::post('EditObjetivo', 'ObjetivosController@update');
    Route::post('DeleteObjetivo', 'ObjetivosController@delete');

    // Estrategías
    Route::get('/Estrategia', function () {
        return view('CatEstrategias'); // En resources -> views - index.php -- Así se llama la vista principal donde entraran 
    });
    Route::get('GetAllEstretegias','EstrategiasController@all');
    Route::post('GetEstretegias','EstrategiasController@index');
    Route::post('GetEstrategiasObjetivos','EstrategiasController@objetivos');
    Route::post('GetEstrategiasTemas','EstrategiasController@temas');
    Route::post('AddEstrategia', 'EstrategiasController@insert');
    Route::post('EditEstrategia', 'EstrategiasController@update');
    Route::post('DeleteEstrategia','EstrategiasController@delete');

    // Líneas de acción
    Route::get('/LineasAccion', function () {
        return view('CatLineasAccion'); // En resources -> views - index.php -- Así se llama la vista principal donde entraran 
    });
    Route::get('GetAllLineasAccion','LineasAccionController@all');
    Route::post('GetLineasAccion','LineasAccionController@index');
    Route::post('AddLineaAccion', 'LineasAccionController@insert');
    Route::post('EditLineaAccion', 'LineasAccionController@update');
    Route::post('DeleteLineaAccion','LineasAccionController@delete');


// ========================================
// C A T Á L O G O S   B E N E F I C I A R I O S
// ========================================

    // Catálogo Beneficiarios
    Route::get('/Beneficiarios', function () {
        return view('CatBeneficiarios'); // En resources -> views - index.php -- Así se llama la vista principal donde entraran 
    });
    Route::get('GetTiposBeneficiarios','BeneficiariosController@types');
    Route::get('GetAllBeneficiarios','BeneficiariosController@all');
    Route::post('GetBeneficiarios','BeneficiariosController@index');
    Route::post('AddBeneficiario','BeneficiariosController@insert');
    Route::post('EditBeneficiario','BeneficiariosController@update');
    Route::post('DeleteBeneficiario','BeneficiariosController@delete');
    Route::post('AddTipoBeneficiario','BeneficiariosController@insert_tipo');
    Route::post('EditTipoBeneficiario','BeneficiariosController@update_tipo');
    Route::post('DeleteTipoBeneficiario','BeneficiariosController@eliminar_tipo');
    Route::get('GetUltimoIdTipoBeneficiario','BeneficiariosController@get_ultimo_tipo_beneficiario');
    
// ========================================
// A D M I N I S T R A C I Ó N
// ========================================

    // Administracion
    Route::get('/MenuAdmin', function () {
        return view('MenuAdmin'); // En resources -> views - index.php -- Así se llama la vista principal donde entraran 
    });

    /*Route::get('/MenuAdmin', function () {
        return view('MenuAdmin'); // En resources -> views - index.php -- Así se llama la vista principal donde entraran 
    });*/

    // Usuarios
    Route::get('/Usuarios', function () {
        return view('AdminUsuarios'); // En resources -> views - index.php -- Así se llama la vista principal donde entraran 
    });
    Route::get('GetUsuarios','UsuariosController@index');
    Route::post('SaveCerrarSesion','UsuariosController@close');
    Route::post('SaveNotificacion','UsuariosController@notif');
    Route::post('AddUsuario','UsuariosController@insert');
    Route::post('EditUsuario','UsuariosController@update');
    Route::post('DeleteUsuario','UsuariosController@delete');
    Route::post('ValidarIdUsuario','UsuariosController@validar_id'); 


    // Roles
    Route::get('/Roles', function () {
        return view('AdminRoles'); // En resources -> views - index.php -- Así se llama la vista principal donde entraran 
    });
    Route::get('GetRoles','RolesController@index');
    Route::post('UpdateRoles','RolesController@update');

// ========================================
// M I R
// ========================================

    Route::get('/MenuMIR', function () {
        return view('MenuMIR'); // En resources -> views - index.php -- Así se llama la vista principal donde entraran 
    });

    // Revisar MIR
    Route::get('/RevisarMIR', function () {
        return view('RevisarMIR'); // En resources -> views - index.php -- Así se llama la vista principal donde entraran 
    });
    Route::post('GetMir','MirController@index');
    Route::post('GetMirCaratula','MirController@caratula');
    Route::post('GetMirFin','MirController@fin');
    Route::post('GetMirProposito','MirController@proposito');
    Route::post('GetMirComponentes','MirController@componentes');
    Route::post('GetMirActividades','MirController@actividades');
    Route::post('GetMirAutoriaCarga','MirController@auditoriacarga');
    Route::post('GetMirAutoriaFormulas','MirController@auditoriaformulas');

// ========================================
// Ejercicios Fiscales
// ========================================

Route::get('/EjerciciosFiscales', function () {
    return view('EjerciciosFiscales');
});

Route::get('GetEjerciciosFiscales', "EjerciciosFiscalesController@lista");
Route::post('GuardarEjercicioFiscal', "EjerciciosFiscalesController@guardar");
Route::post('SetStatusEF', "EjerciciosFiscalesController@set_status");
