<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContratacaoServicos extends Model
{
    protected $table = 'contratacao_servicos';

    protected $fillable = [
		'id',
        'titulo',
        'texto',
        'tipoContrata',
        'tipoPrazo',
        'prazoInicial',
        'prazoFinal',
        'prazoProrroga',
        'prazo',
        'nome_arq',
        'arquivo',
        'nome_arq_errat',
        'arquivo_errat',
        'dtup_errat',
        'nome_arq_errat_2',
        'arquivo_errat_2',
        'dtup_errat_2',
        'nome_arq_errat_3',
        'arquivo_errat_3',
        'dtup_errat_3',
        'nome_arq_errat_4',
        'arquivo_errat_4',
        'dtup_errat_4',
        'nome_arq_errat_5',
        'arquivo_errat_5',
        'dtup_errat_5',
        'unidade_id',
		'created_at',
		'updated_at',
		'status'
	];
}
