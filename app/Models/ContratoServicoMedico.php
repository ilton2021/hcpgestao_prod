<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContratoServicoMedico extends Model
{
    protected $table = 'contrato_servico_medico';

    protected $fillable = [
        'contrato_id',
        'nome_contrato', 
        'unidade_id', 
        'nome_empresa', 
        'cnpj_empresa', 
        'endereco_empresa', 
        'especialidade_medica', 
        'numero_consultas_mensais', 
        'nome_exame', 
        'valor_unitario_consulta', 
        'data_inicio_contrato', 
        'data_fim_contrato', 
        'prazo_vigencia', 
        'data_assinatura', 
        'email',
        'created_at',
        'updated_at'
    ];
}