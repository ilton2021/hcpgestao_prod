<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SelectiveProcess extends Model
{
    protected $table = 'selective_processes';
	
	protected $fillable = [
		'title',
		'file_path',
		'name_arq',
		'year',
		'ordering',
		'unidade_id',
		'status_processos',
		'created_at',
		'updated_at'
	];
	
	public $rules = [
		'title' 	=> 'required',
		'file_path' => 'required',
		'year' 		=> 'required',
	];
}
