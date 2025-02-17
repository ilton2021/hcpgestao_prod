<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DespesasPessoais extends Model
{
    protected $fillable = [
		'Nivel',
		'Cargo',
		'Quant',
		'Valor',
		'Mes',
		'Ano',
		'status_desp',
		'created_at',
		'updated_at'
	];
}
