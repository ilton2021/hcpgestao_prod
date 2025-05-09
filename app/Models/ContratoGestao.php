<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContratoGestao extends Model
{
    protected $table = 'contrato_gestaos';
	
	protected $fillable = [
		'title',
		'path_file',
		'unidade_id',
		'status_contratos',
		'created_at',
		'updated_at'
	];
	
	public $rules = [
		'title' 	=> 'required',
		'path_file' => 'required'
	];
	
}
