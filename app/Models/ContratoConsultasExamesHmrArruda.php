<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContratoConsultasExamesHmrArruda extends Model
{
    protected $table = 'contrato_consultas_exames_hmr_arruda';

    protected $fillable = [
        'contrato_id',
        'nome_contrato', 
        'unidade_id', 
        'nome_empresa', 
        'cnpj_empresa', 
        'endereco_empresa', 
        'especialidade_medica', 
        'numero_consultas', 
        'valor_consulta', 
        'data_inicio_contrato', 
        'gestor_contrato', 
        'prazo_vigencia', 
        'data_assinatura', 
        'email',
        'created_at',
        'updated_at'
    ];
}