<?php

namespace App; 

use Illuminate\Database\Eloquent\Model;

class MirProposito extends Model
{
    protected $fillable = [
        'ClasProgramatica',
        'Proposito',
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
        'TipoFormula',
        'MetaAnualOriginal',
        'LineaBaseOriginal'
    ];
    protected $table = 'PROPOSITO';
    public $timestamps = false;
    protected $primaryKey = 'ClasProgramatica';
    public $incrementing = false;

    public function getKeyName(){
        return "ClasProgramatica";
    }
}
