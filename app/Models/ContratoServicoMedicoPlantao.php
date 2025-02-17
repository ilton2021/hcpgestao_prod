<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContratoServicoMedicoPlantao extends Model
{
    protected $table = 'contrato_servico_medico_plantao';

    protected $fillable = [
        'contrato_id',
        'nome_contrato', 
        'unidade_id', 
        'nome_empresa', 
        'cnpj_empresa', 
        'endereco_empresa', 
        'especialidade_medica',
        'data_inicio_contrato', 
        'prazo_vigencia', 
        'email',
        'created_at',
        'updated_at'
    ];
}