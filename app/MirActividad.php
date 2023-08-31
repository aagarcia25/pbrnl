<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MirActividad extends Model
{
    protected $fillable = [
        'ClasProgramatica',
        'idComponente',
        'idActividad',
        'Actividad',
        'Indicador',
        'Formula',
        'V1',
        'V2',
        'FormulaV1V2',
        'Frecuencia',
        'MetaAnual',
        'LineaBase',
        'FuenteInformacion',
        'Supuestos',
        'ValorNumerador',
        'ValorDenominador',
        'ValorNumeradorOriginal',
        'ValorDenominadorOriginal',
        'UnidadMedida',
        'DescripAbsoluto',
        'SentidoIndicador',
        'TipoIndicador',
        'DimensionIndicador',
        'Claridad',
        'Relevancia',
        'Economia',
        'Monitoreable',
        'Adecuado',
        'AporteMarginal',
        'UnidadResponsable',
        'DescripcionIndicador',
        'DescripcionNumerador',
        'DescripcionDenominador',
        'MetaSemestre1',
        'MetaSemestre2',
        'MetaTrimestre1',
        'MetaTrimestre2',
        'MetaTrimestre3',
        'MetaTrimestre4',
        'MediosVerificacion',
        'ClaveIndicador',
        'LineaBaseV1',
        'LineaBaseV2',
        'LineaBaseEjercicio',
        'Semestre1V1',
        'Semestre2V1',
        'Semestre1V2',
        'Semestre2V2',
        'Trimestre1V1',
        'Trimestre2V1',
        'Trimestre3V1',
        'Trimestre4V1',
        'Trimestre1V2',
        'Trimestre2V2',
        'Trimestre3V2',
        'Trimestre4V2',
        'TipoFormula',
        'MetaAnualOriginal',
        'LineaBaseOriginal',
        'DenominadorFijo',
        'EjercicioFiscal',
        'ComponenteMidId',
        'Id'
    ];
    protected $table = 'ACTIVIDAD';
    public $timestamps = false;
    protected $primaryKey = ['Id'];
    public $incrementing = false;

    public function getKeyName(){
        return "Id";
    }
}
