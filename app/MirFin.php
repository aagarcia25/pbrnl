<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MirFin extends Model
{
    protected $fillable = [
        'Fin',
        'Indicador',
        'Formula',
        'V1',
        'V2',
        'FormulaV1V2',
        'Frecuencia',
        'MetaAnual',
        'LineaBase',
        'MediosVerificacion',
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
        'ClaveIndicador',
        'LineaBaseV1',
        'LineaBaseV2',
        'LineaBaseEjercicio',
        'TipoFormula',
        'MetaAnualOriginal',
        'LineaBaseOriginal',
        'Id'
    ];
    protected $table = 'FIN1';
    public $timestamps = false;
    protected $primaryKey = 'Id';
    public $incrementing = true;

    public function getKeyName(){
        return "Id";
    }
}
