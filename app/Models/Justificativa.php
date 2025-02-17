<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Justificativa extends Model
{
	protected $table = 'justificativa';
	
	protected $fillable = [
		'nome',
		'mes',
		'ano',
		'caminho',
		'name_arq',
		'tabela',
		'unidade_id',
		'status',
		'created_at',
		'updated_at'
	];
}

