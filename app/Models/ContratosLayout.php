<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContratosLayout extends Model
{
    protected $table = 'contratos_layout';

    protected $fillable = [
		'nome',
		'criador',
        'tipo_documento',
        'arquivo',
        'caminho_arquivo',
        'data_criacao',
        'unidade_id',
        'created_at',
        'updated_at'
    ];
}
