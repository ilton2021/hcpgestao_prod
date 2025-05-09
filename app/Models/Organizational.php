<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Organizational extends Model
{
    protected $table = 'organizationals';
	
	protected $fillable = [
		'cargo',
		'name',
		'email',
		'telefone',
		'unidade_id',
		'status_organizacional',
		'created_at',
		'updated_at'
	];
	
	public $rules = [
		
		'name'  	 => 'required|min:5',
		'cargo' 	 => 'required|min:2',
		'email' 	 => 'required|email',
		'telefone' 	 => 'required|min:8'
	];
}
