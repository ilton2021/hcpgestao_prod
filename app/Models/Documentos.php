<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Documentos extends Model
{
    protected $table = 'documentos';

    protected $fillable = [
        'nome',
        'email',
        'orgao',
        'tipo_documento',
        'data_inicio',
        'data_fim',
        'observacao',
        'unidade_id',
        'status',
        'created_at',
        'updated_at'
    ];
}
