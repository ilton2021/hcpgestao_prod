<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Associado extends Model
{
    protected $table = 'associados';
	
	protected $fillable = [
		'id',
		'name',
		'cpf',
		'tipo_membro',
		'unidade_id',
		'status_associados',
		'created_at',
		'updated_at'
	];
	
	public $rules = [
		'name'  	  => 'required|min:5',
		'cpf' 	 	  => 'required|min:10',
		'tipo_membro' => 'required'
	];
}
