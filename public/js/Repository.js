async function Requests(method = '', url = '', data = null) {

    const options = {
        method: method,
        mode: 'cors',
        cache: 'no-cache',
        credentials: 'same-origin',
        headers: {
            'Content-Type': 'application/json'
        },
        redirect: 'follow',
        referrer: 'no-referrer'
    };

    if (data) {
        options.body = JSON.stringify(data);
    }

    const response = await fetch(url, options);

    if (response.status == 404) {
        console.log(response)
        Func_Aviso("Error 404", "La petición que estas intentando realizar no puede ser encontrada en el servidor.", "error");
        return;
    } else if (response.status == 500) {
        console.log(response)
        Func_Aviso("Error 500", "La petición que estas intentando realizar ha tenido un error interno en el servidor.", "error");
        return;
    } else {
        const info = await response.json();
        return info;
    }
}


class Repository {

    constructor() {
        // Local
        this.Url = "http://evalua-pbr.nl.gob.mx/interfaz";

        this._secretarias = null;
        this._conacadmin = null;
        this._conacfuncional = null;
        this._conactipologia = null;
        this._unidadesadministrativas = null;
        this._eje = null;
        this._ods = null;
        this._metaods = null;
        this._tema = null;
        this._login = null;
        this._roles = null;
        this._usuarios = null;
        this._programasp = null;
        this._actividadesi = null;
        this._ppinversion = null;
        this._objetivos = null;
        this._tiposbeneficiarios = null;
        this._beneficiarios = null;
    }

    get Secretarias() {
        if (!this._secretarias) {
            this._secretarias = new SecretariasController(this.Url);
        }

        return this._secretarias;
    }

    get ConacAdministrativo() {
        if (!this._conacadmin) {
            this._conacadmin = new ConacAdministrativoController(this.Url);
        }

        return this._conacadmin;
    }

    get ConacFuncional() {
        if (!this._conacfuncional) {
            this._conacfuncional = new ConacFuncionalController(this.Url);
        }

        return this._conacfuncional;
    }

    get ConacTipologia() {
        if (!this._conactipologia) {
            this._conactipologia = new ConacTipologiaController(this.Url);
        }

        return this._conactipologia;
    }

    get UnidadesAdministrativas() {
        if (!this._unidadesadministrativas) {
            this._unidadesadministrativas = new UnidadesAdministrativasController(this.Url);
        }

        return this._unidadesadministrativas;
    }

    get Eje() {
        if (!this._eje) {
            this._eje = new EjeController(this.Url);
        }

        return this._eje;
    }

    get Ods() {
        if (!this._ods) {
            this._ods = new OdsController(this.Url);
        }

        return this._ods;
    }

    get MetaOds() {
        if (!this._metaods) {
            this._metaods = new MetaOdsController(this.Url);
        }

        return this._metaods;
    }

    get Tema() {
        if (!this._tema) {
            this._tema = new TemaController(this.Url);
        }

        return this._tema;
    }
    
    get Login() {
        if (!this._login) {
            this._login = new LoginController(this.Url);
        }

        return this._login;
    }

    get Roles() {
        if (!this._roles) {
            this._roles = new RolesController(this.Url);
        }

        return this._roles;
    }

    get Usuarios() {
        if (!this._usuarios) {
            this._usuarios = new UsuariosController(this.Url);
        }

        return this._usuarios;
    }

    get ProgramasPresupuestales() {
        if (!this._programasp) {
            this._programasp = new ProgramasPresupuestalesController(this.Url);
        }

        return this._programasp;
    }

    get ActividadesInstitucionales() {
        if (!this._actividadesi) {
            this._actividadesi = new ActividadesInstitucionalesController(this.Url);
        }

        return this._actividadesi;
    }

    get ProgramasProyectosInversion() {
        if (!this._ppinversion) {
            this._ppinversion = new ProgramasProyectosInversionController(this.Url);
        }

        return this._ppinversion;
    }

    get Objetivos() {
        if (!this._objetivos) {
            this._objetivos = new ObjetivosController(this.Url);
        }

        return this._objetivos;
    }

    get TiposBeneficiarios() {
        if (!this._tiposbeneficiarios) {
            this._tiposbeneficiarios = new TiposBeneficiariosController(this.Url);
        }

        return this._tiposbeneficiarios;
    }

    get Beneficiarios() {
        if (!this._beneficiarios) {
            this._beneficiarios = new BeneficiariosController(this.Url);
        }

        return this._beneficiarios;
    }

}

class SecretariasController {
    constructor(url = '') {
        this.Url = url;
    }

    GetSecretarias() {
        return Requests('GET', this.Url + "/GetSecretarias");
    }

    AddSecretaria(request) {
        return Requests('POST', this.Url + "/AddSecretaria", request);
    }

    EditSecretaria(request) {
        return Requests('POST', this.Url + "/EditSecretaria", request);
    }

    DeleteSecretaria(id) {
        return Requests('POST', this.Url + "/DeleteSecretaria", id);
    }
}

class ConacAdministrativoController {
    constructor(url = '') {
        this.Url = url;
    }

    GetConacAdministrativo() {
        return Requests('GET', this.Url + "/GetConacAdministrativo");
    }
}

class ConacFuncionalController {
    constructor(url = '') {
        this.Url = url;
    }

    GetConacFuncional() {
        return Requests('GET', this.Url + "/GetConacFuncional");
    }
}

class ConacTipologiaController {
    constructor(url = '') {
        this.Url = url;
    }

    GetConacTipologia() {
        return Requests('GET', this.Url + "/GetConacTipologia");
    }
}

class UnidadesAdministrativasController {
    constructor(url = '') {
        this.Url = url;
    }

    GetAllUnidadesAdministrativas() {
        return Requests('GET', this.Url + "/GetAllUnidadesAdministrativas");
    }

    GetUnidadesAdministrativas(request) {
        return Requests('POST', this.Url + "/GetUnidadesAdministrativas", request);
    }

    AddUnidadAdministrativa(request) {
        return Requests('POST', this.Url + "/AddUnidadAdministrativa", request);
    }

    EditUnidadAdministrativa(request) {
        return Requests('POST', this.Url + "/EditUnidadAdministrativa", request);
    }

    DeleteUnidadAdministrativa(id) {
        return Requests('POST', this.Url + "/DeleteUnidadAdministrativa", id);
    }
}

class EjeController {
    constructor(url = '') {
        this.Url = url;
    }

    GetEjes() {
        return Requests('GET', this.Url + "/GetEjes");
    }

    AddEje(request) {
        return Requests('POST', this.Url + "/AddEje", request);
    }

    EditEje(request) {
        return Requests('POST', this.Url + "/EditEje", request);
    }

    DeleteEje(id) {
        return Requests('POST', this.Url + "/DeleteEje", id);
    }
}

class OdsController {
    constructor(url = '') {
        this.Url = url;
    }

    GetOds() {
        return Requests('GET', this.Url + "/GetOds");
    }

    AddOds(request) {
        return Requests('POST', this.Url + "/AddOds", request);
    }

    EditOds(request) {
        return Requests('POST', this.Url + "/EditOds", request);
    }

    DeleteOds(id) {
        return Requests('POST', this.Url + "/DeleteOds", id);
    }
}

class MetaOdsController {
    constructor(url = '') {
        this.Url = url;
    }

    GetMetaOds(request) {
        return Requests('POST', this.Url + "/GetMetaOds", request);
    }

    AddMetaOds(request) {
        return Requests('POST', this.Url + "/AddMetaOds", request);
    }

    EditMetaOds(request) {
        return Requests('POST', this.Url + "/EditMetaOds", request);
    }

    DeleteMetaOds(id) {
        return Requests('POST', this.Url + "/DeleteMetaOds", id);
    }
}

class TemaController {
    constructor(url = '') {
        this.Url = url;
    }

    GetTemas(request) {
        return Requests('POST', this.Url + "/GetTemas", request);
    }

    Addtema(request) {
        return Requests('POST', this.Url + "/AddTema", request);
    }

    EditTema(request) {
        return Requests('POST', this.Url + "/EditTema", request);
    }

    DeleteTema(id) {
        return Requests('POST', this.Url + "/DeleteTema", id);
    }
}

class LoginController {
    constructor(url = '') {
        this.Url = url;
    }

    Login(request) {
        return Requests('POST', this.Url + "/AccessLogin", request);
    }

    Recuperar(request) {
        return Requests('POST', this.Url + "/RecoverPassword", request);
    }
}

class RolesController {
    constructor(url = '') {
        this.Url = url;
    }

    GetRoles() {
        return Requests('GET', this.Url + "/GetRoles");
    }

    UpdateRoles(request) {
        return Requests('POST', this.Url + "/UpdateRoles", request);
    }
}

class UsuariosController {
    constructor(url = '') {
        this.Url = url;
    }

    GetUsuarios() {
        return Requests('GET', this.Url + "/GetUsuarios");
    }

    SaveCerrarSesion(request) {
        return Requests('POST', this.Url + "/SaveCerrarSesion", request);
    }

    SaveNotificacion(request) {
        return Requests('POST', this.Url + "/SaveNotificacion", request);
    }

    AddUsuario(request) {
        return Requests('POST', this.Url + "/AddUsuario", request);
    }

    EditUsuario(request) {
        return Requests('POST', this.Url + "/EditUsuario", request);
    }

    DeleteUsuario(id) {
        return Requests('POST', this.Url + "/DeleteUsuario", id);
    }

}

class ProgramasPresupuestalesController {
    constructor(url = '') {
        this.Url = url;
    }

    GetAllProgramasP() {
        return Requests('GET', this.Url + "/GetAllProgramasP");
    }

    GetProgramasP(request) {
        return Requests('POST', this.Url + "/GetProgramasP", request);
    }

    GetInfoComponentes(request) {
        return Requests('POST', this.Url + "/GetInfoComponentes", request);
    }

    GetComponentes(request) {
        return Requests('POST', this.Url + "/GetComponentes", request);
    }

    EditComponente(request) {
        return Requests('POST', this.Url + "/EditComponente", request);
    }

    EditProgramaPresupuestal(request) {
        return Requests('POST', this.Url + "/EditProgramaPresupuestal", request);
    }
}

class ActividadesInstitucionalesController {
    constructor(url = '') {
        this.Url = url;
    }

    GetAllActividadesI() {
        return Requests('GET', this.Url + "/GetAllActividadesI");
    }

    GetActividadesI(request) {
        return Requests('POST', this.Url + "/GetActividadesI", request);
    }

    GetInfoComponentesAI(request) {
        return Requests('POST', this.Url + "/GetInfoComponentesAI", request);
    }

    GetComponentesAI(request) {
        return Requests('POST', this.Url + "/GetComponentesAI", request);
    }

    EditComponenteAI(request) {
        return Requests('POST', this.Url + "/EditComponenteAI", request);
    }

    EditActividadInstitucional(request) {
        return Requests('POST', this.Url + "/EditActividadInstitucional", request);
    }
}

class ProgramasProyectosInversionController {
    constructor(url = '') {
        this.Url = url;
    }

    GetAllPPI() {
        return Requests('GET', this.Url + "/GetAllPPI");
    }

    GetPPI(request) {
        return Requests('POST', this.Url + "/GetPPI", request);
    }

    GetInfoComponentesPPI(request) {
        return Requests('POST', this.Url + "/GetInfoComponentesPPI", request);
    }

    GetComponentes(request) {
        return Requests('POST', this.Url + "/GetComponentes", request);
    }

    EditComponente(request) {
        return Requests('POST', this.Url + "/EditComponente", request);
    }

    EditActividadInstitucional(request) {
        return Requests('POST', this.Url + "/EditActividadInstitucional", request);
    }
}

class ObjetivosController {
    constructor(url = '') {
        this.Url = url;
    }

    GetAllObjetivos() {
        return Requests('GET', this.Url + "/GetAllObjetivos");
    }
}

class BeneficiariosController {
    constructor(url = '') {
        this.Url = url;
    }

    GetTiposBeneficiarios() {
        return Requests('GET', this.Url + "/GetTiposBeneficiarios");
    }

    GetBeneficiarios(request) {
        return Requests('POST', this.Url + "/GetBeneficiarios", request);
    }

    AddBeneficiario(request) {
        return Requests('POST', this.Url + "/AddBeneficiario", request);
    }

    EditBeneficiario(request) {
        return Requests('POST', this.Url + "/EditBeneficiario", request);
    }

    DeleteBeneficiario(id) {
        return Requests('POST', this.Url + "/DeleteBeneficiario", id);
    }

    AddTipoBeneficiario(request) {
        return Requests('POST', this.Url + "/AddTipoBeneficiario", request);
    }

    EditTipoBeneficiario(request) {
        return Requests('POST', this.Url + "/EditTipoBeneficiario", request);
    }
}




