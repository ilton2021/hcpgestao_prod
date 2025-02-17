<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContratacaoServicosErratas extends Model
{
    protected $table = 'contratacao_servicos_erratas';

    protected $fillable = [
        'posicao',
        'nome_arq_errata',
        'arquivo_errata',
        'dtup_errata',
        'contratacao_servicos_id',
        'unidade_id',
        'created_at',
        'updated_at'
    ];
}
