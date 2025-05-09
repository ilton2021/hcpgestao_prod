<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConselhoFisc extends Model
{
    protected $table = 'conselho_fiscs';
	
	protected $fillable = [
		'name',
		'level',
		'tipo_membro',
		'unidade_id',
		'status_conselho_fiscs',
		'created_at',
		'updated_at'
	];
	
	public $rules = [
		'name' => 'required',
		'level' => 'required|not_in:0',
		'tipo_membro' => 'required'
	];
}
