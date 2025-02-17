<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EspecialidadeContratacao extends Model
{
	protected $table = 'especialidade_contratacao';

    protected $fillable = [
		'id',
        'contratacao_servicos_id',
        'especialidades_id',
		'created_at',
		'updated_at'
	];
}
