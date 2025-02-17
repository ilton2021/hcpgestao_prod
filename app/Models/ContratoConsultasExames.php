<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContratoConsultasExames extends Model
{
    protected $table = 'contrato_consultas_exames';

    protected $fillable = [
        'contrato_id',
        'nome_contrato', 
        'unidade_id', 
        'nome_empresa', 
        'cnpj_empresa', 
        'endereco_empresa', 
        'especialidade_medica', 
        'numero_consultas', 
        'numero_exames', 
        'nome_exame', 
        'valor_unitario_consulta', 
        'valor_unitario_exame', 
        'data_inicio_contrato', 
        'data_fim_contrato', 
        'prazo_vigencia', 
        'data_assinatura', 
        'email',
        'created_at',
        'updated_at'
    ];
}