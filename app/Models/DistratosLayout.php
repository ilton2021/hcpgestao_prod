<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DistratosLayout extends Model
{
    protected $table = 'distratos_layout';

    protected $fillable = [
        'contrato_id',
        'nome_distrato', 
        'unidade_id',
        'nome_empresa', 
        'cnpj_empresa', 
        'endereco_empresa', 
        'resumo', 
        'data_inicio_contrato', 
        'data_inicio_distrato', 
        'data_assinatura',
        'email',
        'created_at',
        'updated_at'
    ];
}