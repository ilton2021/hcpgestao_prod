<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServidoresCedidosRH extends Model
{
    protected $table = 'servidores_cedidos';
	
	protected $fillable = [
		'cargo',
		'nome',
		'fone',
		'email',
		'matricula',
		'data_inicio',
		'observacao',
		'unidade_id',
		'status_servidores',
		'created_at',
		'updated_at'
	];
}
