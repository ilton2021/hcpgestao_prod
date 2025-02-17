<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ouvidoria extends Model
{
	protected $table = 'ouvidoria';
	
	protected $fillable = [
		'responsavel',
		'email',
		'telefone',
		'atendpresen',
		'hrfunciona',
		'unidade_id',
		'status_ouvidoria',
		'created_at',
		'updated_at'
	];
}

