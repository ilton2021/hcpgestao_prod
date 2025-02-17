<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OcorrenciasForm extends Model
{
    protected $table = 'ocorrencias_form';

    protected $fillable = [
        'ocorrencia',
        'unidade',
        'resp_analise',
        'descricao_ocorrencia',
        'resp_ocorren',
        'tipoocorrencia',
        'processo',
        'origem',
        'resp_disp_imed',
        'data_relato',
        'notificacao',
        'setor_notificante',
        'setor_notificado',
        'data_ocorrencia',
        'nome_paciente',
        'registro',
        'data_nascimento',
        'descricao_evento',
        'acao_imediata',
        'data_acao_corretiva',
        'responsavel_acao',
        'classificacao_ocorrencia',
        'classificacao_dano',
        'classificar_incidente',
        'processo_incidente',
        'problema_incidente',
        'created_at',
        'updated_at',
    ];
}
