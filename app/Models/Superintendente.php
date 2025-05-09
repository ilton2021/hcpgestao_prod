<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Superintendente extends Model
{
    protected $table = 'superintendentes';
	
	protected $fillable = [
		'name',
		'cargo',
		'tipo_membro',
		'unidade_id',
		'status_superintendentes',
		'created_at',
		'updated_at'
	];
	
	public $rules = [
		'name' 		  => 'required',
		'cargo' 	  => 'required',
		'tipo_membro' => 'required'
	];
}
