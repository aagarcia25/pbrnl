<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MirComponente extends Model
{
    protected $fillable = [
        'ClasProgramatica',
        'idComponente',
        'Componente',
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
        'Id'
    ];
    protected $table = 'COMPONENTE1';
    public $timestamps = false;
    protected $primaryKey = ['Id'];
    public $incrementing = true;

    public function getKeyName(){
        return "Id";
    }
}
