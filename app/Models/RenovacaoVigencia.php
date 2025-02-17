<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RenovacaoVigencia extends Model
{
    protected $table = 'renovacao_vigencia';

    protected $fillable = [
        'contrato_id',
        'nome_vigencia', 
        'unidade_id', 
        'numero_aditivo', 
        'nome_empresa', 
        'cnpj_empresa', 
        'endereco_empresa', 
        'data_inicio_contrato', 
        'data_fim_contrato', 
        'prazo_vigencia', 
        'data_assinatura', 
        'email',
        'created_at',
        'updated_at'
    ];
}