<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GestorContrato extends Model
{
	protected $table = 'gestor_contrato';
	
	protected $fillable = [
		'contrato_id',
		'gestor_id',
		'unidade_id',
		'created_at',
		'updated_at'
	];
}
