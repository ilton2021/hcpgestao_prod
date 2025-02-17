<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RegulamentosRh extends Model
{
	protected $table = 'regulamentos_rh';

	protected $fillable = [
		'regulamentorh',
		'file_path',
		'unidade_id',
		'mes',
		'ano',
		'status_regula_rh',
		'created_at',
		'updated_at'
	];
}
